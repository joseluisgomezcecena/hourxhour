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
        
		//necesitamos la fecha de hoy, el shift_id y el asset_id
		$now = new DateTime();

        $data['title'] = "Plan";
		$data['asset_id'] = $asset_id = $this->input->get('asset_id');

		$shift_date = $this->shift->getIdFromCurrentTime( $now );
        //$data['shift_id'] = $shift_date['shift_id'];
		//$data['date'] = $date = $now->format(DATE_FORMAT);

   
		$this->load->view('templates/header');
        $this->load->view('pages/plan/index', $shift_date);
        $this->load->view('templates/footer');
    }


	public function api_get_plan()
	{
        $this->load->model('productionplan');
		$asset_id = $this->input->get('asset_id');
		$shift_id = $this->input->get('shift_id');
		$date = $this->input->get('date');

		$this->shift->Load($shift_id);
				//Cargar Plan
		$this->productionplan->LoadPlan($asset_id, $date, $shift_id, $this->shift->shift_start_time, $this->shift->shift_end_time);

		echo json_encode($this->productionplan);
	}


    public function api_get_items()
    {
        //SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number;
        $query = $this->db->query('SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as item_pph, item_run_labor, item_pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number');
        $data['items'] =   $query->result_array();
        echo json_encode($data);
    }


    public function api_get_interruptions()
    {
        $query = $this->db->query('SELECT * FROM interruptions');
        $data['interruptions'] =   $query->result_array();
        echo json_encode($data);
    }


    public function api_save_plan()
    {
        //this has the array to start saving
        $input = json_decode($this->input->raw_input_stream);
        $plan = $input->plan;

        $is_new_record = true;

        if(isset($plan->plan_id))
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

        
        if($is_new_record)
        {
            $this->db->insert('production_plans', $data);
            $plan->plan_id = $this->db->insert_id(); //get the last inserted id
        }
        else 
        {
            $this->db->where('plan_id', $plan->plan_id);
            $this->db->update('production_plans', $data);
        }

        
        
        for( $i=0; $i < count($plan->plan_by_hours); $i++)
        {
            unset($data_item);
            $data_item = array();

            //$plan->plan_by_hours as $item
            $item = $plan->plan_by_hours[$i];
            
                    
            if($is_new_record)
            {
                $data_item['updated_at'] = $now->format(DATETIME_FORMAT);
                $data_item['created_at'] = $now->format(DATETIME_FORMAT);


                $sql = "INSERT INTO plan_by_hours (`plan_id`, `time`, `time_end`, `planned`, `planned_head_count`, `workorder`, `item_id`, `interruption_id`, `less_time`, `std_time`, `updated_at`, `created_at`)";
                $sql .= " VALUES (";

                $sql .= $plan->plan_id . ", ";
                $sql .= "'" . $item->time . "', ";
                $sql .= "'" . $item->time_end . "', ";
                $sql .= (isset($item->planned) ? $item->planned : 'NULL') . ", ";
                $sql .= (isset($item->planned_head_count) ? $item->planned_head_count : 'NULL') . ", ";
                $sql .= (isset($item->workorder) ? "'" . $item->workorder . "'" : 'NULL') . ", ";
                $sql .= (isset($item->item_id) ? $item->item_id : 'NULL') . ", ";
                $sql .= (isset($item->interruption_id) ? $item->interruption_id : 'NULL') . ", ";
                $sql .= (isset($item->less_time) ? $item->less_time : 'NULL') . ", ";
                $sql .= (isset($item->std_time) ? $item->std_time : 'NULL') . ", ";
                $sql .= "'" . $data_item['updated_at'] . "', ";
                $sql .= "'" . $data_item['created_at'] . "'";

                $sql .= ")";
                
                if(!$this->db->simple_query($sql)){
                    echo 'ocurrion un error en ' . $sql;
                }
    
            } else
            {
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
                
                $sql .= "less_time = ";
                $sql .= (isset($item->less_time) ? $item->less_time : 'NULL') . ", ";
                
                $sql .= "std_time = ";
                $sql .= (isset($item->std_time) ? $item->std_time : 'NULL') . ", ";
                
                $sql .= "updated_at = ";
                $sql .= "'" . $data_item['updated_at'] . "'";
                
                $sql .= " WHERE plan_by_hour_id = " .  $item->plan_by_hour_id;

                if(!$this->db->simple_query($sql)){
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
        //se obtiene el turno en base al DateTime y se carga el modelo del shift
        $shift_date = $this->shift->getIdFromCurrentTime( new DateTime() );

        $plant_id = $this->input->get('plant_id');
        $this->shift->Load( $shift_date['shift_id'] );

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
        $data['title'] = "Select a Cell";
        $this->load->view('templates/header');
        $this->load->view('pages/plan/measuring_point', $data);
        $this->load->view('templates/footer');
    }

}
