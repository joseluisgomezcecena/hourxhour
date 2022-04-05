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

        $data['title'] = "Manual Capture";
        $data['shifts'] = $this->shift->all();


        $now = new DateTime;
        $now->setTime(0, 0, 0);

        $shift_date = $this->shift->getIdFromCurrentTime($now);
        //echo json_encode($shift_date);

        $this->load->view('templates/header');
        $this->load->view('pages/plan/manual_capture', $data);
        $this->load->view('templates/footer');
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
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/button_tablet', $data);
        $this->load->view('templates/footer');
    }


    //add capture
    public function add_capture($number)
    {
        $plan_by_hour_id = $this->input->post('plan_by_hour_id');
        $reset = $this->input->post('reset');
        $capture_type = $this->input->post('capture_type '); //0 es para sensor, 1 es para tablet, 2 es para desktop

        //i need plan_hour_by_id
        $this->load->model('planbyhour');
        $this->load->model('productionplan');

        $this->planbyhour->Load($plan_by_hour_id);

        //retrieve an object of table productions_plans
        $plan = $this->productionplan->getProductionPlanById($this->planbyhour->plan_id);

        $last_value = intval($this->planbyhour->completed);

        $mult_factor = 1;
        if ($plan->use_multitplier_factor == 1) {
            $mult_factor =  $plan->multiplier_factor;
        }

        //$last_value += $mult_factor; //capture_type
        $this->planbyhour->IncrementCompleted($mult_factor, $reset,  $capture_type);

        echo json_encode($this->planbyhour);
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
        
        $shift_date = $this->shift->getIdFromCurrentTime( new DateTime );

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
