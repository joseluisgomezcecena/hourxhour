<?php

class Pages extends CI_Controller
{
    public function view($page = 'home')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        /*
        Author: Emanuel Jauregui
        this portion of code was modified to retrieve data in the dashboard of the current plan running in the current shift
        The general idea is to get the shift_id and the date of start of the shift based on current datetime with 
        $this->shift->getIdFromCurrentTime(new DateTime);

        Con la siguiente condicion se pretende
        if ($this->shift->shift_start_time > $this->shift->shift_end_time) {
            Si la fecha actual es igual a la fecha en la que inicia el turno entonces debemos verificar que si la hora de inicio del turno es mayor
            a la del fin entonces agregamos un dia mas a la fecha, ya que estamos en el final del dia
            este caso solo se presentara por ejemplo a las 23 horas con 15 minutos hasta las 12, 
            En el caso que se presente en el turno 3 a las 02:00 horas por ejemplo getIdFromCurrentTime regresara un dia anterior  y 
            tambien tenemos que incrementar un dia.
        */

        //Si es de las 0 horas al primer turno entonces

        /*$this->load->model('shift');
        $shift_response =  $this->shift->getIdFromCurrentTime(new DateTime);
        $shift_id = $shift_response['shift_id'];
        $start_shift_date = $shift_response['date'];

        //Se presentan el status como lo que ocurrio la hora anterior....
        $end_shift_date = new DateTime();
        $end_shift_date = $end_shift_date->modify('-1 hour');

        $this->shift->Load($shift_id);
        */

        $start_shift_date = new DateTime();

        $this->db->select('*');
        $this->db->from('shifts');
        $this->db->where('shift_id', 1);
        $first_shift = $this->db->get()->row_array();

        //Siempre va a ser la jpra actual menos una hora....
        $end_shift_date = new DateTime();
        $end_shift_date = $end_shift_date->modify('-1 hour');

        $hour = $start_shift_date->format(HOUR_FORMAT_WITH_ZEROS);
        if (!($hour >= $first_shift['shift_start_time'])) {
            //el turno comienza en el dia anterior
            $start_shift_date = $start_shift_date->modify("-1 day");
        }

        $start_date = $start_shift_date->format(DATE_FORMAT) . ' ' . $first_shift['shift_start_time'];
        $end_date = $end_shift_date->format(DATETIME_FORMAT_ZERO_MINUTES_AND_SECONDS);

        $plants = $this->db->query("SELECT plant_id, plant_name FROM plants")->result_array();

        for ($i = 0; $i < count($plants); $i++) {

            $plant = $plants[$i];
            $query = $this->db->query("SELECT DISTINCT plants.plant_id as sub_plant_id, plants.plant_name, sites.site_id as sub_site_id,sites.site_name, assets.asset_id AS sub_asset_id, assets.asset_name,
        (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date' AND plants.plant_id = " . $plant['plant_id'] . ";");


            $data_info_items = $query->result_array();
            for ($o = 0; $o < count($data_info_items); $o++) {
                $data_info_items[$o]['planned'] = ($data_info_items[$o]['planned'] == NULL) ? 0 : $data_info_items[$o]['planned'];
                $data_info_items[$o]['completed'] = ($data_info_items[$o]['planned'] == NULL) ? 0 : $data_info_items[$o]['completed'];
            }

            $plants[$i]['data'] = $data_info_items;
            //echo json_encode($query->result_array());
        }

        $data['title'] = ucfirst($page);
        $data['plants'] = $plants;

        $this->load->view('templates/header');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }
}
