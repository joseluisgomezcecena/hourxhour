<?php
class Interruption_Cause extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('shift');
    }

    public function index()
    {
        $this->load->model('capture');
        $this->load->model('productionplan');
        $this->load->model('planbyhour');
        $asset_id = $this->input->get('asset_id');

        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        $this->shift->Load($shift_date['shift_id']);
        $this->productionplan->LoadPlan($this->input->get('asset_id'), $shift_date['date']->format(DATE_FORMAT));

        $data['production_plan'] =  $this->productionplan;
        $data['interruptions'] = $this->db->get('interruptions')->result();
        $data['not_planned_interruptions'] = $this->db->get('not_planned_interruptions')->result();
        $data['title'] = "Interruption Cause";

        $this->load->view('templates/header');
        $this->load->view('pages/interruption_cause/index', $data);
        $this->load->view('templates/footer');

        // echo json_encode($data);
    }

    public function save()
    {
        //echo json_encode($this->input->post());
        $array_input = $this->input->post();
        //not_planned_interruption_id

        //$items = array();
        $startWithChar = 'not_planned_interruption_id_';
        foreach ($array_input  as $key => $value) {
            if (substr($key, 0, strlen($startWithChar)) ===  $startWithChar) {

                $plan_by_hour_id = intval(substr($key, strlen($startWithChar)));

                $key_of_value = 'not_planned_interruption_value_' .  substr($key, strlen($startWithChar));
                $not_planned_interruption_value = $array_input = $this->input->post($key_of_value);

                $not_planned_interruption_id = null;
                if (is_numeric($value)) {
                    $not_planned_interruption_id = intval($value);
                }

                $less_time = null;
                if (is_numeric($not_planned_interruption_value)) {
                    $less_time = (float)intval($not_planned_interruption_value) / 60.0;
                }

                //array_push($items, $item);
                $this->db->set('not_planned_interruption_id', $not_planned_interruption_id);
                $this->db->set('not_planned_interruption_value', $less_time);
                $this->db->where('plan_by_hour_id', $plan_by_hour_id);
                $this->db->update('plan_by_hours');
            }
        }

        redirect(base_url() . 'interruption_cause/measuring_point?site_id=' . $this->input->post('site_id')  .  '&plant_id=' .  $this->input->post('plant_id'));
        //$this->db->update_batch('plan_by_hours', $items, 'plan_by_hour_id');
        //echo json_encode($items);
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
    {
        $this->load->model('plant');
        $this->load->model('shift');

        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        $plant_id = $this->input->get('plant_id');
        $site_id  =   $this->input->get('site_id');

        $sql = "SELECT assets.asset_id, assets.site_id, assets.asset_name, ";
        $sql .= "(SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '{$shift_date['date']->format(DATE_FORMAT)}' ) as plan_id FROM assets ";
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
