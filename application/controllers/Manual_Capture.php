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

        $data['title'] = "Manual Capture";
        $plant_id = $this->input->get('plant_id');
        $data['plant_id'] = $plant_id;

        $data['plants'] = $this->db->get('plants')->result_array();

        /*if(true)
        {
            echo json_encode( $data['plants'] );
        }*/

        $shifts = $this->shift->get_shifts_with_date();
        for($i = 0; $i < count($shifts) ;$i++)
        {
            //En los shifts traigo el shift_id y el date, solo me falta el asset_id para saber de que plan se trata
            $assets = $this->machine_model->get_pom_active($plant_id);
            $assets_with_plan = array();
            
            $shift_id = $shifts[$i]['shift_id'];
            $date = $shifts[$i]['date'];
            $shift_start_time = $shifts[$i]['shift_start_time'];
            $shift_end_time = $shifts[$i]['shift_end_time'];

            for($a = 0; $a < count($assets); $a++)
            {
                $asset_id = $assets[$a]['asset_id'];
                     
                //Cargar el production plan
                $this->productionplan->LoadPlan($asset_id, $date->format(DATE_FORMAT), $shift_id,  $shift_start_time, $shift_end_time);
                if( $this->productionplan->plan_id != NULL )
                {
                    //Si no hay production plan
                    //$assets[$a]['production_plan'] = $this->productionplan;
                    $assets[$a]['production_plan'] =  clone $this->productionplan;
                    array_push($assets_with_plan, $assets[$a]);
                } 
            }

            //if($i == 0)
            $shifts[$i]['assets'] = $assets_with_plan;
        }
        //pass the site_id
        $data['shifts'] = $shifts;

        //echo json_encode($data);   
        $this->load->view('templates/header');
        $this->load->view('pages/plan/manual_capture', $data);
        $this->load->view('templates/footer');
    }


    public function save_manual_capture()
    {
        $this->load->model('planbyhour');
        //$this->load->model('productionplan');
        
       // echo json_encode($this->input->post());
       //$input_data = $this->input->post();
        $first_part = 'plan_by_hour_id_';

       foreach($this->input->post() as $key => $value)
       {
            if (str_starts_with($key, $first_part)) {
               $plan_by_hour_id = intval(  substr($key, strlen($first_part) ) );

               $this->planbyhour->Load($plan_by_hour_id);
               $this->planbyhour->IncrementCompleted($value, true,  CAPTURE_MANUAL);

            } 
       }

       redirect( base_url() . 'manual_capture?plant_id=' . $this->input->post('plant_id'));
       
    }


    public function tablet()
    {
        $this->load->model('capture');
        $this->load->model('shift');
        $this->load->model('productionplan');
        $this->load->model('planbyhour');


        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);
        //$asset_id, $shift_id, $date, si no hay plan regresa NULL
        $plan = $this->productionplan->getProductionPlan($this->input->get('asset_id'), $shift_date['shift_id'], $shift_date['date']->format(DATE_FORMAT));

        //Aqui ya traes los datos de plan_hourxhour.plan_by_hours si no lo encontro
        $plan_by_hour_id = $this->capture->get_current_hour($plan->plan_id);
        $this->planbyhour->Load($plan_by_hour_id);

        $plan_id = $this->planbyhour->plan_id;
        $item_id = $this->planbyhour->item_id;


        $data['plan_id'] = $plan_id;
        $data['item_id'] = $item_id;
        $data['item_number'] = $this->planbyhour->item_number;
        $data['planned'] = $this->planbyhour->planned;
        $data['title'] = "Captura manual";
        $data['plan_by_hour_id'] = $plan_by_hour_id;
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/button_tablet', $data);
        $this->load->view('templates/footer');
    }


    //add capture
    public function add_capture()
    {
        $plan_by_hour_id = $this->input->get('plan_by_hour_id');
        $reset = $this->input->get('reset');
        $capture_type = $this->input->get('capture_type '); //0 es para manual, 1 es para sensor, 2 es para button

        //i need plan_hour_by_id
        $this->load->model('planbyhour');
        $this->load->model('productionplan');

        $this->planbyhour->Load($plan_by_hour_id);

        //retrieve an object of table productions_plans

        $plan = $this->productionplan->getProductionPlanById($this->planbyhour->plan_id);
        $mult_factor = 1;
        if (isset($plan->use_multitplier_factor) && $plan->use_multitplier_factor == 1) {
            $mult_factor =  $plan->multiplier_factor;
        }

        //$last_value += $mult_factor; //capture_type
        $this->planbyhour->IncrementCompleted($mult_factor, $reset,  $capture_type);
    }

    //Modify entire capture
    public function modify_capture()
    {
        //I need plan_hour_by_id
    }


    public function select_plant_button()
    {
        $data['title'] = "Select a plant";

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
        $this->load->model('shift');

        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        $plant_id = $this->input->get('plant_id');
        $site_id  =   $this->input->get('site_id');

        $sql = "SELECT assets.asset_id, assets.site_id, assets.asset_name, ";
        $sql .= "(SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '{$shift_date['date']->format(DATE_FORMAT)}' AND shift_id = {$shift_date['shift_id']}) as plan_id FROM assets ";
        $sql .= "WHERE assets.asset_active=1 AND assets.site_id = {$site_id} AND assets.asset_is_pom = 1";

        $query = $this->db->query($sql);
        $data['item_by_plan'] =   $query->result_array();

        $data['title'] = "Measuring Point";
        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;
        $data['shift_id'] = $shift_date['shift_id'];
        $this->plant->Load($plant_id);
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/select_measuring_point_tablet', $data);
        $this->load->view('templates/footer');
    }
}
