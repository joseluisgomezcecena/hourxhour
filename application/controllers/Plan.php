<?php
/*
* Author: Emanuel Jauregui 
* Martech Number: 46716
* 
* Plan is a controler of the production plan.
* it communicates to handle pages and models for production plan
*/

class Plan extends CI_Controller
{

    /*
    * shift model is used proccess so it will be loaded all the time in constructor
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shift');
    }


    /*
    * index funtion is the 'planners' route
    * it goes to the editable production plan
    * when we call to getIdFromCurrentTime we get an array with shift_id and with date
    * the date is the date when shift starts based on the current day
    */

    public function index()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        //necesitamos la fecha de hoy, el shift_id y el asset_id
        $now = new DateTime();

        $data['title'] = "Plan";
        $data['asset_id'] = $asset_id = $this->input->get('asset_id');
        $shift_date = $this->shift->getIdFromCurrentTime($now);

        $data['date'] = $date = $shift_date['date']->format(DATE_FORMAT);

        $this->load->view('templates/header');
        $this->load->view('pages/plan/index', $data);
        $this->load->view('templates/footer');
    }


    /*
    * api_get_data retrieves the info of the production plan including plan_by_hours info.
    * in orden to achieve this task, we load the ProductionPlan Model to get the info by using $this->productionplan->LoadPlan(
    * once again we did this we need to get all the supervisors from another database, this is done by calling   $this->db->db_select('authentication');
    */
    public function api_get_data()
    {
        $query = $this->db->query('SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as item_pph, item_run_labor, item_pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number');
        $data['items'] =   $query->result_array();

        $query = $this->db->query('SELECT * FROM interruptions');
        $data['interruptions'] =   $query->result_array();

        $this->load->model('productionplan');
        $asset_id = $this->input->get('asset_id');
        //$shift_id = $this->input->get('shift_id');
        $date = $this->input->get('date');
        //$this->shift->Load($shift_id);
        $this->productionplan->LoadPlan($asset_id, $date);
        $data['production_plan'] =  $this->productionplan;


        $this->db->db_select('authentication');
        $department_name = 'Production';
        $level_name = 'Supervisor';
        $this->db->select('users.user_id, users.user_email, users.user_name, users.user_lastname, users.user_martech_number ,users.user_active, users.user_level_id, levels.level_name, users.user_department_id, departments.department_name');
        $this->db->from('users');
        $this->db->join('departments', 'users.user_department_id = departments.department_id', 'inner');
        $this->db->join('levels', 'users.user_level_id = levels.level_id', 'inner');
        if ($department_name != null)
            $this->db->where('departments.department_name', $department_name);
        if ($level_name != null)
            $this->db->where('levels.level_name', $level_name);
        $query = $this->db->get();
        $data['supervisors'] = $query->result_array();


        echo json_encode($data);
    }


    /*
     *  Function api_save_plan
     *  This is the core of the plan, this method insert or update the production plan and the items of each hour
     * it is important to mention that we are sending from the frontend a json text with the production plan and the plan by hours
     * that is the reason why we are calling the json_decode($this->input->raw_input_stream); function
     *  we retrieve all the data in a json single unit and not by a lot of parameters.
    */
    public function api_save_plan()
    {
        //this has the array to start saving
        $input = json_decode($this->input->raw_input_stream);
        $plan = $input->plan;

        $is_new_record = true;

        /*
        * if the plan is found in database then is not a new record...
        */
        if (isset($plan->plan_id))
            $is_new_record = false;

        $now = new DateTime();

        $data['asset_id'] = $plan->asset_id;
        $data['date'] = $plan->date;
        $data['supervisor'] = $plan->supervisor;

        $data['use_multiplier_factor'] = intval($plan->use_multiplier_factor);
        $data['multiplier_factor'] = intval($plan->multiplier_factor);

        if ($is_new_record) {
            $data['created_at'] = $now->format(DATETIME_FORMAT);
        }
        $data['updated_at'] = $now->format(DATETIME_FORMAT);


        /*
        * if this is a new recoerd the insert in the database and we retrieve the generated id
        * otherwise the production plan is saved 
        */
        if ($is_new_record) {
            $this->db->insert('production_plans', $data);
            $plan->plan_id = $this->db->insert_id(); //get the last inserted id
        } else {
            $this->db->where('plan_id', $plan->plan_id);
            $this->db->update('production_plans', $data);
        }

        /*
         * At this point we are going to save each hour 
         * in the json text we found $plan->plan_by_hours, it is an array with all the data of hours
         * 
         */
        for ($i = 0; $i < count($plan->plan_by_hours); $i++) {
            unset($data_item);
            $data_item = array();

            //$plan->plan_by_hours as $item
            $item = $plan->plan_by_hours[$i];

            if ($is_new_record) {
                $data_item['updated_at'] = $now->format(DATETIME_FORMAT);
                $data_item['created_at'] = $now->format(DATETIME_FORMAT);

                $sql = "INSERT INTO plan_by_hours (`plan_id`, `time`, `time_end`, `planned`, `planned_head_count`, `workorder`, `item_id`, `interruption_id`, `interruption_value`, `std_time`, `updated_at`, `created_at`)";
                $sql .= " VALUES (";

                $sql .= $plan->plan_id . ", ";
                $sql .= "'" . $item->time . "', ";
                $sql .= "'" . $item->time_end . "', ";
                $sql .= (isset($item->planned) ? $item->planned : 'NULL') . ", ";
                $sql .= (isset($item->planned_head_count) ? $item->planned_head_count : 'NULL') . ", ";
                $sql .= (isset($item->workorder) ? "'" . $item->workorder . "'" : 'NULL') . ", ";
                $sql .= (isset($item->item_id) ? $item->item_id : 'NULL') . ", ";
                $sql .= (isset($item->interruption_id) ? $item->interruption_id : 'NULL') . ", ";
                $sql .= (isset($item->interruption_value) ? $item->interruption_value : 'NULL') . ", ";
                //$sql .= (isset($item->less_time) ? $item->less_time : 'NULL') . ", ";
                $sql .= (isset($item->std_time) ? $item->std_time : 'NULL') . ", ";
                $sql .= "'" . $data_item['updated_at'] . "', ";
                $sql .= "'" . $data_item['created_at'] . "'";

                $sql .= ")";

                if (!$this->db->simple_query($sql)) {
                    echo 'ocurrion un error en ' . $sql;
                }
            } else {
                $data_item['updated_at'] = $now->format(DATETIME_FORMAT);

                $sql = "UPDATE plan_by_hours SET ";

                $sql .= "plan_id = ";
                $sql .= $plan->plan_id . ", ";

                $sql .= "planned = ";
                $sql .= (isset($item->planned) ? $item->planned : 'NULL') . ", ";

                $sql .= "planned_head_count = ";
                $sql .= (isset($item->planned_head_count) ? $item->planned_head_count : 'NULL') . ", ";

                $sql .= "workorder = ";
                $sql .= (isset($item->workorder) ? "'" . $item->workorder . "'" : 'NULL') . ", ";

                $sql .= "item_id = ";
                $sql .= (isset($item->item_id) ? $item->item_id : 'NULL') . ", ";

                $sql .= "interruption_id = ";
                $sql .= (isset($item->interruption_id) ? $item->interruption_id : 'NULL') . ", ";

                $sql .= "interruption_value = ";
                $sql .= (isset($item->interruption_value) ? $item->interruption_value : 'NULL') . ", ";

                $sql .= "std_time = ";
                $sql .= (isset($item->std_time) ? $item->std_time : 'NULL') . ", ";

                $sql .= "updated_at = ";
                $sql .= "'" . $data_item['updated_at'] . "'";

                $sql .= " WHERE plan_by_hour_id = " .  $item->plan_by_hour_id;

                if (!$this->db->simple_query($sql)) {
                    echo 'ocurrion un error en ' . $sql;
                }
            }
        }

        //if (!$is_new_record)
        //    $this->sendMail($plan->plan_id);
    }


    /*
    * this controller allows to display a screen for display sites and number of asset of each one.
    */
    public function select_cell()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        //se obtiene el turno en base al DateTime y se carga el modelo del shift
        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime());

        $plant_id = $this->input->get('plant_id');
        $this->shift->Load($shift_date['shift_id']);

        $this->load->model('plant');
        $this->plant->Load($plant_id);

        $data['title'] = "Select a Cell for shift: " . $this->shift->shift_name;
        $data['shift'] = $this->shift;
        $data['plant'] =  $this->plant;

        $sql = "SELECT *, (SELECT COUNT(*)  from assets where assets.site_id  = sites.site_id AND assets.asset_active = 1 AND assets.asset_is_pom = 1) as assets_count FROM sites WHERE plant_id = {$plant_id}";
        $query = $this->db->query($sql);
        $data['sites'] =   $query->result_array();

        $this->load->view('templates/header');
        $this->load->view('pages/plan/select_cell', $data);
        $this->load->view('templates/footer');
    }


    /*
    * function sendMail was created to send a email when an update was done.
    * it was created a helper sendmail to allow send email, passing parametesr 
    * emails, subject, message and others you can check the info in the folder of the helpers
    */
    public function sendMail($plan_id)
    {


        $recipients = array();
        //getting data for email.
        $query = $this->db->query("SELECT * FROM production_plans 
    LEFT JOIN assets ON production_plans.asset_id = assets.asset_id 
    LEFT JOIN sites ON assets.site_id = sites.site_id 
    LEFT JOIN plants ON sites.plant_id = plants.plant_id 
    LEFT JOIN mail_list ON mail_list.plant_id = plants.plant_id 
	WHERE production_plans.plan_id = $plan_id");

        $result = $query->result_array();

        foreach ($result as $item) {
            $recipients[] =  $item['email'];
        }

        echo $emails = implode(',', $recipients);
        $subject = "Plan has been updated! | {$item['asset_name']}";
        $message = "
			<p>Production plan updated in <b>{$item['site_name']}</b> in the following asset {$item['asset_name']}.</p>";

        $this->load->helper('sendemail');
        send($emails, $subject, $message, 'jgomez@martechmedical.com', 'jgomez@martechmedical.com');
    }
}
