<?php
class Interruption_Cause extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Interruption Cause";
        $this->load->view('templates/header');
        $this->load->view('pages/interruption_cause/index', $data);
        $this->load->view('templates/footer');
    }
    public function select_cell()
    {
        $this->load->model('plant');
        $plants = $this->plant->getAllActive();

        for ($i = 0; $i < count($plants); $i++) {
            $sql = "SELECT *, (SELECT COUNT(*)  from assets where assets.site_id  = sites.site_id AND assets.asset_active = 1 AND assets.asset_is_pom = 1) as assets_count FROM sites WHERE plant_id = {$plants[$i]['plant_id']}";
            $query = $this->db->query($sql);
            $plants[$i]['sites'] =  $query->result_array();
        }

        $data['plants'] = $plants;
        $data['title'] = "Select a Cell";
        $this->load->view('templates/header');
        $this->load->view('pages/interruption_cause/select_cell', $data);
        $this->load->view('templates/footer');
    }
    public function select_measuring()
    {$this->load->model('plant');
        $this->load->model('shift');

        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        $plant_id = $this->input->get('plant_id');
        $site_id  =   $this->input->get('site_id');

        $sql = "SELECT assets.asset_id, assets.site_id, assets.asset_name, ";
        $sql .= "(SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '{$shift_date['date']->format(DATE_FORMAT)}' AND shift_id = {$shift_date['shift_id']}) as plan_id FROM assets ";
        $sql .= "WHERE assets.asset_active=1 AND assets.site_id = {$site_id} AND assets.asset_is_pom = 1";

        $query = $this->db->query($sql);
        $data['item_by_plan'] =   $query->result_array();

        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;
        $data['shift_id'] = $shift_date['shift_id'];
        $this->plant->Load($plant_id);
        $data['title'] = "Interruption Cause";
        $this->load->view('templates/header');
        $this->load->view('pages/interruption_cause/measuring_point', $data);
        $this->load->view('templates/footer');
    }
}
