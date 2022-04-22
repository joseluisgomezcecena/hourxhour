<?php

class Plan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('shift');
    }


    public function index()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        //necesitamos la fecha de hoy, el shift_id y el asset_id
        $now = new DateTime();

        $data['title'] = "Plan";
        $data['asset_id'] = $asset_id = $this->input->get('asset_id');
        $shift_date = $this->shift->getIdFromCurrentTime($now);

        $data['shift_id'] = $shift_date['shift_id'];
        $data['date'] = $date = $shift_date['date']->format(DATE_FORMAT);

        $this->load->view('templates/header');
        $this->load->view('pages/plan/index', $data);
        $this->load->view('templates/footer');
    }


    public function api_get_data()
    {
        $query = $this->db->query('SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as item_pph, item_run_labor, item_pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number');
        $data['items'] =   $query->result_array();

        $query = $this->db->query('SELECT * FROM interruptions');
        $data['interruptions'] =   $query->result_array();

        $this->load->model('productionplan');
        $asset_id = $this->input->get('asset_id');
        $shift_id = $this->input->get('shift_id');
        $date = $this->input->get('date');
        $this->shift->Load($shift_id);
        $this->productionplan->LoadPlan($asset_id, $date, $shift_id, $this->shift->shift_start_time, $this->shift->shift_end_time);
        $data['production_plan'] =  $this->productionplan;

        echo json_encode($data);
    }


    public function api_save_plan()
    {
        //this has the array to start saving
        $input = json_decode($this->input->raw_input_stream);
        $plan = $input->plan;

        $is_new_record = true;

        if (isset($plan->plan_id))
            $is_new_record = false;

        $now = new DateTime();

        $data['asset_id'] = $plan->asset_id;
        $data['date'] = $plan->date;
        $data['shift_id'] = $plan->shift_id;
        $data['supervisor_id'] = $plan->supervisor_id;

        $data['use_multiplier_factor'] = intval($plan->use_multiplier_factor);
        $data['multiplier_factor'] = intval($plan->multiplier_factor);

        //if($is_new_record) {
        //    $data['created_at'] = $now->format(DATETIME_FORMAT);
        // }
        //$data['updated_at'] = $now->format(DATETIME_FORMAT);


        if ($is_new_record) {
            $this->db->insert('production_plans', $data);
            $plan->plan_id = $this->db->insert_id(); //get the last inserted id
        } else {
            $this->db->where('plan_id', $plan->plan_id);
            $this->db->update('production_plans', $data);

			 $this->sendMail($plan->plan_id);
        }



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
                /* 
                UPDATE table_name
                SET column1 = value1, column2 = value2, ...
                WHERE condition;
                */
                //plan_id`, `time`, `time_end`, `planned`, `planned_head_count`, `workorder`, `item_id`, `interruption_id`, `less_time`, `std_time`, `updated_at`, `created_at
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

                //$sql .= "not_planned_interruption_id = ";
                //$sql .= (isset($item->not_planned_interruption_id) ? $item->not_planned_interruption_id : 'NULL') . ", ";

                //$sql .= "not_planned_interruption_value = ";
                //$sql .= (isset($item->not_planned_interruption_value) ? $item->not_planned_interruption_value : 'NULL') . ", ";

                //$sql .= "less_time = ";
                //$sql .= (isset($item->less_time) ? $item->less_time : 'NULL') . ", ";

                $sql .= "std_time = ";
                $sql .= (isset($item->std_time) ? $item->std_time : 'NULL') . ", ";

                $sql .= "updated_at = ";
                $sql .= "'" . $data_item['updated_at'] . "'";

                $sql .= " WHERE plan_by_hour_id = " .  $item->plan_by_hour_id;

                if (!$this->db->simple_query($sql)) {
                    echo 'ocurrion un error en ' . $sql;
                }
                //$data_item[$i]['updated_at'] = $now->format(DATETIME_FORMAT);
                //$this->db->where('plan_by_hora_id', $data_item['plan_by_hora_id']  );
                //$this->db->update('plan_by_hours', $data_item);
            }
        }
    }


    public function test()
    {
        //$shift = new Shift;

    }

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


    public function select_measuring_point()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $data['title'] = "Select a Cell";
        $this->load->view('templates/header');
        $this->load->view('pages/plan/measuring_point', $data);
        $this->load->view('templates/footer');
    }








	public function sendMail($plan_id)
	{
		$id = $plan_id;

		$recipients = array();
		//getting data for email.
		$query = $this->db->query("SELECT * FROM production_plans 
    LEFT JOIN assets ON production_plans.asset_id = assets.asset_id 
    LEFT JOIN sites ON assets.site_id = sites.site_id 
    LEFT JOIN plants ON sites.plant_id = plants.plant_id 
    LEFT JOIN mail_list ON mail_list.plant_id = plants.plant_id 
	WHERE production_plans.plan_id = $id");

		$result = $query->result_array();

		foreach ($result as $item)
		{
			$recipients[] =  $item['email'];
		}

		echo $emails = implode(',', $recipients);




		$this->load->library('email');

		$subject = 'Plan has been updated!';
		$message = '
			<p>Production plan has been updated.</p>';

		// Get full html:
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
				<title>' . html_escape($subject) . '</title>
				<style type="text/css">
					body {
						font-family: Arial, Verdana, Helvetica, sans-serif;
						font-size: 16px;
					}
				</style>
			</head>
			<body>
			' . $message . '
			</body>
			</html>';
		// Also, for getting full html you may use the following internal method:
		//$body = $this->email->full_html($subject, $message);




		$result = $this->email
			->from('jgomez@martechmedical.com')
			->reply_to('jgomez@martechmedical.com')    // Optional, an account where a human being reads.
			//->to('jgomez@martechmedical.com')
			->to("$emails")
			->subject($subject)
			->message($body)
			->send();

		var_dump($result);
		echo '<br />';
		echo $this->email->print_debugger();
		exit;
	}







}
