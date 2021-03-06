<?php

use LDAP\Result;

class Manual_Capture extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('shift');
    }

    public function index()
    {
        $this->load->model('machine_model');
        $this->load->model('productionplan');

        $data['title'] = "Captura Manual";
        //pass the site_id and the plant_id from params
        $plant_id = $this->input->get('plant_id');
        $site_id = $this->input->get('site_id');
        if ($site_id == -1) $site_id = null;


        $current_date = new DateTime();
        $current_date_more_one_day = new DateTime();
        $current_date_more_one_day->modify('+1 day');

        //Este codigo esta diseniado para las horas de las 0 hasta antes de las 6, el tercer turno
        //debe tomar el plan del dia anterior...
        if ($current_date->format('H') < 6) {
            $current_date->modify('-1 day');
            $current_date_more_one_day->modify('-1 day');
        }

        $shifts = $this->db->get('shifts')->result_array();

        for ($i = 0; $i < count($shifts); $i++) {
            //En los shifts traigo el shift_id y el date, solo me falta el asset_id para saber de que plan se trata

            //$plant_id = NULL, $site_id = NULL
            $assets = $this->machine_model->get_pom_active($plant_id, $site_id);
            $assets_with_plan = array();
            //$shifts[$i]['assets'] = $this->machine_model->get_pom_active();

            $shift_id = $shifts[$i]['shift_id'];
            $shift_start_time = $shifts[$i]['shift_start_time'];
            $shift_end_time = $shifts[$i]['shift_end_time'];


            if ($shift_start_time < $shift_end_time) {
                $shift_start_time = $current_date->format(DATE_FORMAT) . ' ' . $shift_start_time;
                $shift_end_time = $current_date->format(DATE_FORMAT) . ' ' . $shift_end_time;
            } else {
                $shift_start_time = $current_date->format(DATE_FORMAT) . ' ' . $shift_start_time;
                $shift_end_time = $current_date_more_one_day->format(DATE_FORMAT) . ' ' . $shift_end_time;
            }

            for ($a = 0; $a < count($assets); $a++) {
                $asset_id = $assets[$a]['asset_id'];

                // echo $asset_id . ' ';
                //Cargar el production plan
                $this->db->select('production_plans.plan_id, production_plans.asset_id, production_plans.date, assets.asset_name, sites.site_name');
                $this->db->from('production_plans');
                $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
                $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
                $this->db->where('production_plans.asset_id', $asset_id);
                $this->db->where('production_plans.date', $current_date->format(DATE_FORMAT));

                $production_plan = $this->db->get()->row_array();

                //echo json_encode($production_plan) . $current_date->format(DATE_FORMAT);

                if (isset($production_plan)) {
                    $assets[$a]['production_plan'] =  $production_plan;

                    //echo json_encode($production_plan);

                    $assets[$a]['shift_start_time'] = $shift_start_time;
                    $assets[$a]['shift_end_time'] = $shift_end_time;
                    //plan_by_hours

                    $sql = "SELECT plan_by_hours.plan_by_hour_id, plan_by_hours.planned, plan_by_hours.completed, plan_by_hours.time, plan_by_hours.time_end, plan_by_hours.item FROM plan_by_hours WHERE plan_id = " . $production_plan['plan_id'] . " AND ( plan_by_hours.time >= '$shift_start_time' AND plan_by_hours.time_end <= '$shift_end_time')";
                    $query = $this->db->query($sql);
                    $assets[$a]['production_plan']['plan_by_hours'] = $query->result_array();


                    array_push($assets_with_plan, $assets[$a]);
                }
            }

            $shifts[$i]['assets'] = $assets_with_plan;
        }


        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;
        $data['shifts'] = $shifts;



        $this->load->view('templates/header');
        $this->load->view('pages/plan/manual_capture', $data);
        $this->load->view('templates/footer');
    }


    public function save_manual_capture()
    {
        $this->load->model('planbyhour');
        $first_part = 'plan_by_hour_id_';

        foreach ($this->input->post() as $key => $value) {
            if (str_starts_with($key, $first_part)) {
                $plan_by_hour_id = intval(substr($key, strlen($first_part)));

                $this->planbyhour->Load($plan_by_hour_id);
                $this->planbyhour->IncrementCompleted($value, true,  CAPTURE_MANUAL);
            }
        }

        redirect(base_url() . 'manual_capture?plant_id=' . $this->input->post('plant_id'));
    }


    public function tablet()
    {
        $this->load->model('capture');
        $this->load->model('shift');
        $this->load->model('productionplan');
        $this->load->model('planbyhour');

        $current_datetime = new DateTime;
        //$current_datetime->setTime(6, 0, 0); //for test purposes

        $shift_date = $this->shift->getIdFromCurrentTime($current_datetime);
        $plan = $this->productionplan->getProductionPlan($this->input->get('asset_id'),  $shift_date['date']->format(DATE_FORMAT));

        //echo json_encode($plan);
        //if (true) return;

        if ($plan == null) {
            $this->load->helper('messages');
            $data['plan_id'] = null;
            $this->load->view('templates/header_logged_out');
            $this->load->view('pages/plan/tablet/button_tablet', $data);
            $this->load->view('templates/footer');
            return;
        }

        $plan_by_hour_id = $this->capture->get_current_hour($plan->plan_id, $current_datetime);

        $this->planbyhour->Load($plan_by_hour_id);

        $plan_id = $this->planbyhour->plan_id;
        $item = $this->planbyhour->item;
        $time = $this->planbyhour->time;
        $time_end = $this->planbyhour->time_end;
        $time = date(HOUR_MINUTE_FORMAT, strtotime($time));
        $time_end = date(HOUR_MINUTE_FORMAT, strtotime($time_end));

        //Last Hour
        $timestamp = strtotime($this->planbyhour->time) - 60 * 60;
        //echo $timestamp,' <br>';
        $result = $current_datetime;
        $result->setTimestamp($timestamp);

        //$data['use_multiplier_factor'] = $plan->use_multiplier_factor;
        if ($plan->use_multiplier_factor == 1) {
            $data['multiplier_factor'] = $plan->multiplier_factor;
        }

        //Last Hour End
        $data['plan_id'] = $plan_id;
        $data['site_name'] = $plan->site_name;
        $data['asset_name'] = $plan->asset_name;
        $data['plant_name'] = $plan->plant_name;
        $data['item'] = $this->planbyhour->item;
        $data['workorder'] = $this->planbyhour->workorder;
        $data['planned'] = $this->planbyhour->planned;
        $data['completed'] = $this->planbyhour->completed;
        $data['time'] = $time;
        $data['time_end'] = $time_end;
        $data['title'] = "Captura manual";
        $data['plan_by_hour_id'] = $plan_by_hour_id;

        //Last hour info
        $last_hour_id = $this->capture->get_current_hour($plan->plan_id, $result);


        $data['last_item'] = 'N/A';
        $data['last_workorder'] = 'N/A';
        $data['last_completed'] = 'N/A';
        $data['last_hc'] = 'N/A';
        $data['last_time'] = 'N/A';
        $data['last_time_end'] = 'N/A';

        if ($last_hour_id != null) {

            $this->planbyhour->Load($last_hour_id);
            $last_time = $this->planbyhour->time;
            $last_time_end = $this->planbyhour->time_end;
            $last_time = date(HOUR_MINUTE_FORMAT, strtotime($last_time));
            $last_time_end = date(HOUR_MINUTE_FORMAT, strtotime($last_time_end));

            if ($this->planbyhour->planned == null) {
                $data['last_time'] =  $last_time;
                $data['last_time_end'] = $last_time_end;
            } else {

                $data['last_item'] = $this->planbyhour->item;
                $data['last_workorder'] = $this->planbyhour->workorder;
                $data['last_completed'] = $this->planbyhour->completed;
                $data['last_hc'] = $this->planbyhour->planned_head_count;
                $data['last_time'] = $last_time;
                $data['last_time_end'] = $last_time_end;
            }
        }


        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/button_tablet', $data);
        $this->load->view('templates/footer');
    }

    //add capture
    public function add_capture()
    {

        $plan_by_hour_id = $this->input->get('plan_by_hour_id');
        $reset = $this->input->get('reset');
        $capture_type = $this->input->get('capture_type');

        //i need plan_hour_by_id
        $this->load->model('planbyhour');
        $this->load->model('productionplan');

        $this->planbyhour->Load($plan_by_hour_id);

        //retrieve an object of table productions_plans
        $plan = $this->productionplan->getProductionPlanById($this->planbyhour->plan_id);
        $mult_factor = 1;
        if (isset($plan->use_multiplier_factor) && $plan->use_multiplier_factor == 1) {
            $mult_factor =  $plan->multiplier_factor;
        }

        //echo 'factor ' . $mult_factor;

        $this->planbyhour->IncrementCompleted($mult_factor, $reset,  $capture_type);
        $this->db->select('*');
        $this->db->from('plan_by_hours');
        $this->db->where('plan_by_hour_id', $plan_by_hour_id);
        $result = $this->db->get()->result_array()[0];
        echo json_encode($result);
    }

    //Modify entire capture
    public function modify_capture()
    {
        $plan_by_hour_id = $this->input->post('plan_by_hour_id');
        $capture_type = $this->input->post('capture_type');
        $value = $this->input->post('value');

        echo "=>", $value;

        //i need plan_hour_by_id
        $this->load->model('planbyhour');
        $this->load->model('productionplan');
        $this->planbyhour->Load($plan_by_hour_id);

        //retrieve an object of table productions_plans
        $plan = $this->productionplan->getProductionPlanById($this->planbyhour->plan_id);
        $this->planbyhour->IncrementCompleted($value, 1,  $capture_type);

        $this->db->select('*');
        $this->db->from('plan_by_hours');
        $this->db->where('plan_by_hour_id', $plan_by_hour_id);
        $result = $this->db->get()->result_array()[0];



        $subject = "Produced items has been modified in a cell!";
        $message = "<b>The next capture has been modified:</b>";
        $message .= '<ul>';
        $message .= '<li>Plant: ' . $plan->plant_name . '</li>';
        $message .= '<li>Site: ' . $plan->site_name . '</li>';
        $message .= '<li>Asset: ' . $plan->asset_name . '</li>';
        $message .= '<li>Hour: ' . $this->planbyhour->time . '</li>';
        $message .= '<li>Item Number: ' . $this->planbyhour->item . '</li>';
        $message .= '<li>Work order: ' . $this->planbyhour->workorder . '</li>';
        $message .= '<li>Planned Production: ' .  $result['planned'] . '</li>';
        $message .= '<li>Completed Production: ' . $result['completed'] . '</li>';
        $message .= '</ul>';
        $this->send_email($this->planbyhour->plan_id, $subject, $message);

        echo json_encode($result);
    }


    public function send_email($plan_id, $subject, $message)
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


        //$this->load->helper('sendemail');
        //send($emails, $subject, $message, 'jgomez@martechmedical.com', 'jgomez@martechmedical.com');
    }


    public function select_plant_button()
    {
        $data['title'] = "Selecciona una planta";

        $this->load->model('plant');
        $plants = $this->plant->getAllActive();

        for ($i = 0; $i < count($plants); $i++) {
            $sql = "SELECT *, (SELECT COUNT(*)  from assets where assets.site_id  = sites.site_id AND assets.asset_active = 1 AND assets.asset_is_pom = 1) as assets_count FROM sites WHERE plant_id = {$plants[$i]['plant_id']}";
            $query = $this->db->query($sql);
            $plants[$i]['sites'] =  $query->result_array();
        }

        $data['plants'] = $plants;
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/select_plant_button', $data);
        $this->load->view('templates/footer');
    }

    public function measuring_point()
    {
        $this->load->model('plant');
        //$this->load->model('shift');

        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        $plant_id = $this->input->get('plant_id');
        $site_id  =   $this->input->get('site_id');

        $sql = "SELECT assets.asset_id, assets.site_id, assets.asset_name, ";
        $sql .= "(SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '{$shift_date['date']->format(DATE_FORMAT)}') as plan_id FROM assets ";
        $sql .= "WHERE assets.asset_active=1 AND assets.site_id = {$site_id} AND assets.asset_is_pom = 1";

        $query = $this->db->query($sql);
        $data['item_by_plan'] =   $query->result_array();

        $data['title'] = "Puntos de medici??n";
        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;
        $data['shift_id'] = $shift_date['shift_id'];

        $this->plant->Load($plant_id);
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/select_measuring_point_tablet', $data);
        $this->load->view('templates/footer');
    }
}
