<?php
class Output_VS_Plan extends CI_Controller
{

    /*
    *  Function: select_site
    * 
    * Regrese la pagina de select_plan_button en la cual se presentan cuadros de plantas y sitios
    * La idea de esta pantalla es redireccionar hacia la pantalla en produccion, donde se muestren todos los assets de un sitio
    * 
    */
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


    /*
     * Function: select_monitor
     * En este caso la pagina selecciona un monitor disponible para el sitio
     * un sitio puede tener uno o muchos monitores generalmente 2 o 3. Un monitor representa
     * una television donde se desplegara en la linea de produccion, un monitor despliega generalmente 2 puntos de medicion.
     * */
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

    /*
    * Function: get_data_plants_sites
    *      
    *  regresa un string tipo json de las plantas y los sites
    *  disponibles en su totalidad.
    */
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


    /*
    * Function: get_data_monitor
    *      
    *  regresa un json con la informacion de cada monitor que esta configurado en un site
    *  regresa los assets, explicitamente el nombre del asset,  de cada monitor.
    */
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



    /*
    * Function  index
    * 
    * Regresa la pagina principal output vs plan, es la pagina
    * donde se despliega el plan hora por hora, tomando en cuenta
    * la hora actual (turno),  
    */
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


    /* 
    * Function add_monitor
    *
    * Este controlador nos ayuda a configurar los monitores, en esta pantalla
    * se pueden agregar monitores a una planta sitio, permite agregar configurar assets para cada monitor
    * la funcionalidad esta totalmente en angular.js
    */
    public function add_monitor()
    {
        $plant_id = $this->input->get('plant_id');
        $site_id = $this->input->get('site_id');

        $data['title'] = "Select Cell";
        $data['plant_id'] = $plant_id;
        $data['site_id'] = $site_id;

        $this->load->view('templates/header');
        $this->load->view('pages/output_vs_plan/form/index', $data);
        $this->load->view('templates/footer');
    }


    /* 
     *   Fecha de Documentación: 05/03/2022
     *   Documentado por: Emanuel Jauregui
     *
     *   Descripción: Bajo esta ruta se proveen los datos de las plantas activas, de cada planta se obtienen los datos de los sitios de esa planta y 
     *   el número de assets disponibles de cada site. Solo se mandan llamar los assets activos y que son puntos de medición.
    */

    public function select_site_monitor()
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
        $this->load->view('templates/header');
        $this->load->view('pages/output_vs_plan/form/select_plant', $data);
        $this->load->view('templates/footer');
    }


    /** 
     *    Fecha de Documentación: 05/03/2022
     *    Documentado por: Emanuel Jauregui
     *
     *    Controlador: Output_VS_Plan
     *    Método: get_data
     *    Parametros: plant_id, site_id o monitor_id
     *
     *    Ruta: 'output_vs_plan/get_data'
     *
     *       Descripción: El propósito de esta api es obtener los datos para desplegar en produccion la pantalla del plan activo
     *
     *       Si se pasa el parametro de monitor_id se regresan todos los planes de produccion actuales
     *      basados en las pantallas configuradas previamente. Si no se pasa el monitor_id se utilizara
     *     los parametros de plant_id y site_id.
     */
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



        $data['production_plans'] = $this->db->get()->result_array();


        //Se necesita iterar por todos los planes y obtener todos los datos de cada plan por hora.
        for ($i = 0; $i < count($data['production_plans']); $i++) {

            /*
                set @planned_sum = 0; set @completed_sum = 0;
                SELECT plan_by_hours.plan_by_hour_id, plan_by_hours.time, plan_by_hours.time_end, plan_by_hours.planned_head_count, items_pph.item_number, plan_by_hours.workorder, plan_by_hours.planned,
                (@planned_sum:=@planned_sum + IFNULL(plan_by_hours.planned, 0) ) as planned_sum, plan_by_hours.completed,
                (@completed_sum:=@completed_sum + plan_by_hours.completed) as completed_sum
                FROM plan_by_hours
                LEFT JOIN items_pph ON plan_by_hours.item_id = items_pph.item_id
                WHERE plan_by_hours.plan_id = 87
            */

            $plan_id = $data['production_plans'][$i]['plan_id'];

            $this->db->query('set @planned_sum = 0;');
            $this->db->query('set @completed_sum = 0;');

            $current_time = new DateTime();
            $select_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);

            $current_time->modify('-1 hours');
            $start_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);
            $current_time->modify('+4 hours');
            $end_time = $current_time->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);

            $sql = 'SELECT plan_by_hours.plan_by_hour_id, TIME_FORMAT(plan_by_hours.time, "%H") as time, DATE_FORMAT(plan_by_hours.time_end, "%H") as time_end, plan_by_hours.planned_head_count, items_pph.item_number, ';
            $sql .=  'plan_by_hours.workorder, plan_by_hours.planned, (@planned_sum:=@planned_sum + IFNULL(plan_by_hours.planned, 0) ) as planned_sum, ';
            $sql .=  "plan_by_hours.completed, (@completed_sum:=@completed_sum + plan_by_hours.completed) as completed_sum, IF( plan_by_hours.time = '" . $select_time . "', '1', '0') as current, ";
            $sql .=  "interruptions.interruption_name, not_planned_interruptions.interruption_name as not_planned_interruption_name";
            $sql .= " FROM plan_by_hours ";
            $sql .= ' LEFT JOIN items_pph ON plan_by_hours.item_id = items_pph.item_id';
            $sql .= ' LEFT JOIN interruptions ON plan_by_hours.interruption_id = interruptions.interruption_id';
            $sql .= ' LEFT JOIN not_planned_interruptions ON plan_by_hours.not_planned_interruption_id = not_planned_interruptions.interruption_id';
            $sql .= ' WHERE plan_by_hours.plan_id = ' . $plan_id;

            $plan_by_hours = $this->db->query($sql)->result_array();

            /*calculate the shift status
            * We need to calculate the shift status based on the previous hour not the current hours...
            * we are gonna use int a lopp the next code 
            * if ($plan_by_hours[$h]['current'] == 1) {
            *        $current_index = $h;
            *    }
            * in this case we
            */

            $index_for_shift_status = 0;

            for ($h = 0; $h < count($plan_by_hours); $h++) {

                if ($plan_by_hours[$h]['current'] == 1) {
                    $index_for_shift_status = $h - 1;
                }

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

            //If it is the first row
            if ($index_for_shift_status == -1)
                $data['production_plans'][$i]['shift_status'] = 0;
            else
                $data['production_plans'][$i]['shift_status'] =  ceil(($plan_by_hours[$index_for_shift_status]['completed_sum'] * 100) / $plan_by_hours[$index_for_shift_status]['planned_sum']);

            for ($h = 0; $h < count($plan_by_hours); $h++) {
                if ($plan_by_hours[$h]['current'] == '1') {
                    $data['production_plans'][$i]['current_hour_index'] = $h;
                    break;
                }
            }

            $data['production_plans'][$i]['plan_by_hours'] = $plan_by_hours;
        }

        $this->db->select('DISTINCT(asset_name)');
        $this->db->from('assets');
        $this->db->where('site_id', $site_id);
        $asset_array = $this->db->get()->result_array();

        //$data['assets'] =  json_encode($asset_array);
        if (count($asset_array) > 0) {

            //$str_assets = implode(', ',  $asset_array);
            //$assets = "'" . $str_assets . "'";
            $assets = "";
            for ($i = 0; $i < count($asset_array); $i++) {
                $item = $asset_array[$i];
                $assets .= "'" . $item['asset_name'] . "'";
                if ($i != count($asset_array) - 1) {
                    $assets .= ', ';
                }
            }

            $this->db->db_select('smartstu_martech_dev');
            $sql = "SELECT martech_fallas.*, IF(martech_fallas.atendido_flag = 'no' AND martech_fallas.offline = 'si', 'bg-danger',  IF(martech_fallas.atendido_flag = 'si' AND martech_fallas.offline = 'si', 'bg-warning',  IF(martech_fallas.atendido_flag = 'si' AND martech_fallas.offline = 'no', 'bg-success',  'other' )  ) ) AS status";
            $sql .= " FROM martech_fallas";
            $sql .= " WHERE fin = '0000-00-00 00:00:00'";
            $sql .= " AND maquina_centro_trabajo IN (" .  $assets . ")";
            $query = $this->db->query($sql);
            $data['andon'] = $query->result_array();
        }


        echo json_encode($data);
    }


    public function get_andon_data()
    {
        $this->db->db_select('smartstu_martech_dev');
        $this->db->select("martech_fallas.*, IF(martech_fallas.atendido_flag = 'no' AND martech_fallas.offline = 'si', 'bg-danger',  IF(martech_fallas.atendido_flag = 'si' AND martech_fallas.offline = 'si', 'bg-warning',  IF(martech_fallas.atendido_flag = 'si' AND martech_fallas.offline = 'no', 'bg-success',  'other' )  ) ) AS status");
        $this->db->from('martech_fallas');
        $this->db->where('fin', '0000-00-00 00:00:00');

        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }
}
