<?php

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
        $this->load->view('templates/header');
        $this->load->view('pages/plan/manual_capture', $data);
        $this->load->view('templates/footer');
    }
    public function tablet()
    {

        $sql = "SELECT * FROM plan_hourxhour.plan_by_hours WHERE plan_id = 1  ";
        $query = $this->db->query($sql);
        $data['plan'] =   $query->result_array();

        $data['isModify'] = 1;
        $data['title'] = "Captura manual";
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/button_tablet', $data);
        $this->load->view('templates/footer');
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
        $data['title'] = "Select a plant";
        $this->load->model('plant');
        $plant_id = $this->input->get('plant_id');
		$site_id  =   $this->input->get('site_id');

        $data['plant_id'] = $plant_id;
		$data['site_id'] = $site_id;
        $this->plant->Load($plant_id);
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/plan/tablet/select_measuring_point_tablet', $data);
        $this->load->view('templates/footer');
    }
}
