<?php
class Output_VS_Plan extends CI_Controller
{

    public function select_site()
    {

        $data['title'] = "Select a Site";

        $this->load->model('plant');
        $plants = $this->plant->getAllActive();

        for ($i = 0; $i < count($plants); $i++) {
            $sql = "SELECT *, (SELECT COUNT(*)  from assets where assets.site_id  = sites.site_id AND assets.asset_active = 1 AND assets.asset_is_pom = 1) as assets_count FROM sites WHERE plant_id = {$plants[$i]['plant_id']}";
            $query = $this->db->query($sql);
            $plants[$i]['sites'] =  $query->result_array();
        }

        $data['plants'] = $plants;
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/output_vs_plan/select_plant_button', $data);
        $this->load->view('templates/footer');
    }


    public function select_monitor()
    {
        $data['title'] = "Select a Monitor";
        $site_id = $this->input->get('site_id');
        //$plant_id = $this->input->get('plant_id');
        //$data['site_id'] = $site_id;
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/output_vs_plan/select_monitor', $data);
        $this->load->view('templates/footer');
    }


    public function get_data_plants_sites()
    {
        $this->db->select('*');
        $this->db->from('plants');
        $plants = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('sites');
        $sites = $this->db->get()->result_array();

        $data['plants'] = $plants;
        $data['sites'] = $sites;
        echo json_encode($data);
    }

    public function get_data_monitor()
    {
        $site_id = $this->input->get('site_id');

        $data = array();

        $this->db->select('*');
        $this->db->from('monitors');
        $this->db->where('site_id', $site_id);

        $monitors = $this->db->get()->result_array();

        for ($m = 0; $m < count($monitors); $m++) {

            $this->db->select('monitors_assets.*, assets.asset_name');
            $this->db->from('monitors_assets');
            $this->db->join('assets', 'monitors_assets.asset_id = assets.asset_id', 'left');
            $this->db->where('monitors_assets.monitor_id', $monitors[$m]['monitor_id']);

            $assets = $this->db->get()->result_array();
            $monitors[$m]['assets'] = $assets;
        }

        $data['monitors'] = $monitors;
        echo json_encode($data);
    }




    public function index()
    {
        $plant_id = $this->input->get('plant_id');
        $site_id = $this->input->get('site_id');
        $monitor_id = $this->input->get('monitor_id');

        $data['title'] = "Output vs plan";
        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;
        $data['monitor_id'] = $monitor_id;

        $this->load->view('pages/output_vs_plan/index', $data);
    }


    public function get_data()
    {
        $this->load->model('shift');
        $shift_date = $this->shift->getIdFromCurrentTime(new DateTime);

        //plant_id, site_id
        $plant_id = $this->input->get('plant_id');
        $site_id = $this->input->get('site_id');
        $monitor_id = $this->input->get('monitor_id');

        $shift_id = $shift_date['shift_id'];
        $date = $shift_date['date']->format(DATE_FORMAT);

        /*
            SELECT 
            production_plans.plan_id, 
            plants.plant_name, 
            sites.site_name, 
            assets.asset_name
            FROM production_plans
            INNER JOIN assets ON production_plans.asset_id = assets.asset_id
            INNER JOIN sites ON assets.site_id = sites.site_id
            INNER JOIN plants ON sites.plant_id = plants.plant_id
            WHERE plants.plant_id = 6 AND sites.site_id = 8 AND production_plans.date = '2022-04-18' AND production_plans.shift_id = 1
         */
        //PASO NO. 1 OBTENER UN ARREGLO CON TODOS LOS PLANES DE PRODUCCION FILTRADOS POR PLANTA, SITIO, TURNO Y FECHA TAL COMO ESTA LA QUERY DE ARRIBA

        if ($monitor_id == null) {
            $this->db->select('production_plans.plan_id, plants.plant_name, sites.site_name, assets.asset_name');
            $this->db->from('production_plans');
            $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
            $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
            $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');
            $this->db->where('plants.plant_id', $plant_id);
            $this->db->where('sites.site_id', $site_id);
            $this->db->where('production_plans.date', $date);
            $this->db->where('production_plans.shift_id', $shift_id);
        } else {
            //Si esta por monitor....desplegar lo que esta configurado en el monitor
            $this->db->select('production_plans.plan_id, plants.plant_name, sites.site_name, assets.asset_name');
            $this->db->from('production_plans');
            //INNER JOIN monitors_assets ON production_plans.asset_id = monitors_assets.asset_id
            $this->db->join('monitors_assets', 'production_plans.asset_id = monitors_assets.asset_id', 'inner');
            $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
            $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
            $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');
            $this->db->where('monitors_assets.monitor_id', $monitor_id);
            $this->db->where('production_plans.date', $date);
            $this->db->where('production_plans.shift_id', $shift_id);
        }



        $data = $this->db->get()->result_array();

        for ($i = 0; $i < count($data); $i++) {

            /*
                set @planned_sum = 0;
                set @completed_sum = 0;
                SELECT 
                plan_by_hours.plan_by_hour_id,
                plan_by_hours.time,
                plan_by_hours.time_end,
                plan_by_hours.planned_head_count,
                items_pph.item_number,
                plan_by_hours.workorder,
                plan_by_hours.planned,
                (@planned_sum:=@planned_sum + IFNULL(plan_by_hours.planned, 0) ) as planned_sum,
                plan_by_hours.completed,
                (@completed_sum:=@completed_sum + plan_by_hours.completed) as completed_sum
                FROM plan_by_hours
                LEFT JOIN items_pph ON plan_by_hours.item_id = items_pph.item_id
                WHERE plan_by_hours.plan_id = 87
            */

            //$plan_by_hour_id = $this->capture->get_current_hour($plan->plan_id, new DateTime());


            $plan_id = $data[$i]['plan_id'];

            $this->db->query('set @planned_sum = 0;');
            $this->db->query('set @completed_sum = 0;');

            $current_time = new DateTime();
            $select_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);

            $current_time->modify('-1 hours');
            $start_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);
            $current_time->modify('+4 hours');
            $end_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);

            $sql = 'SELECT plan_by_hours.plan_by_hour_id, DATE_FORMAT(plan_by_hours.time, "%h:%i %p") as time, DATE_FORMAT(plan_by_hours.time_end, "%h:%i %p") as time_end, plan_by_hours.planned_head_count, items_pph.item_number, ';
            $sql .=  'plan_by_hours.workorder, plan_by_hours.planned, (@planned_sum:=@planned_sum + IFNULL(plan_by_hours.planned, 0) ) as planned_sum, ';
            $sql .=  "plan_by_hours.completed, (@completed_sum:=@completed_sum + plan_by_hours.completed) as completed_sum, IF( plan_by_hours.time = '" . $select_time . "', '1', '0') as current, ";
            $sql .=  "interruptions.interruption_name, not_planned_interruptions.interruption_name as not_planned_interruption_name";
            $sql .= " FROM plan_by_hours ";
            $sql .= ' LEFT JOIN items_pph ON plan_by_hours.item_id = items_pph.item_id';
            $sql .= ' LEFT JOIN interruptions ON plan_by_hours.interruption_id = interruptions.interruption_id';
            $sql .= ' LEFT JOIN not_planned_interruptions ON plan_by_hours.not_planned_interruption_id = not_planned_interruptions.interruption_id';
            $sql .= ' WHERE plan_by_hours.plan_id = ' . $plan_id;
            //$sql .=  " AND plan_by_hours.time >= '{$start_time}' AND  plan_by_hours.time < '{$end_time}'";

            $plan_by_hours = $this->db->query($sql)->result_array();

            //calculate the shift status
            $last_index = count($plan_by_hours) - 1;
            $data[$i]['shift_status'] =  ceil(($plan_by_hours[$last_index]['completed_sum'] * 100) / $plan_by_hours[$last_index]['planned_sum']);


            for ($h = 0; $h < count($plan_by_hours); $h++) {
                $interruption = '';
                if ($plan_by_hours[$h]['interruption_name'] != null) {
                    $interruption .=  $plan_by_hours[$h]['interruption_name'];
                }
                if ($plan_by_hours[$h]['not_planned_interruption_name'] != null) {

                    if ($interruption != '')
                        $interruption .=  ', ';

                    $interruption .=  $plan_by_hours[$h]['not_planned_interruption_name'];
                }
                $plan_by_hours[$h]['interruption'] = $interruption;
            }


            for ($h = 0; $h < count($plan_by_hours); $h++) {
                if ($plan_by_hours[$h]['current'] == '1') {
                    $data[$i]['current_hour_index'] = $h;
                    break;
                }
            }


            $data[$i]['plan_by_hours'] = $plan_by_hours;
        }

        echo json_encode($data);
    }
}
