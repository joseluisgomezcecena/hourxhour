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

        $start_date = date(DATE_FORMAT) . ' 0:00:00';
        $end_date = date(DATE_FORMAT) . ' 23:59:59';

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
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_one,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_one,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_two,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_two,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date'AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_three,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_three
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date' AND plants.plant_id = 6;");

        $result = $query->result_array();

        for ($i = 0; $i < count($result); $i++) {

            if ($result[$i]['planned_shift_one']  == NULL) {
                $result[$i]['planned_shift_one']  = 0;
            }
            if ($result[$i]['completed_shift_one']  == NULL) {
                $result[$i]['completed_shift_one']  = 0;
            }

            if ($result[$i]['planned_shift_two']  == NULL) {
                $result[$i]['planned_shift_two']  = 0;
            }
            if ($result[$i]['completed_shift_two']  == NULL) {
                $result[$i]['completed_shift_two']  = 0;
            }

            if ($result[$i]['planned_shift_three']  == NULL) {
                $result[$i]['planned_shift_three']  = 0;
            }
            if ($result[$i]['completed_shift_three']  == NULL) {
                $result[$i]['completed_shift_three']  = 0;
            }

            $total_planned = $result[$i]['planned_shift_one'] + $result[$i]['planned_shift_two'] + $result[$i]['planned_shift_three'];
            $result[$i]['total_planned'] = $total_planned;

            $total_completed = $result[$i]['completed_shift_one'] + $result[$i]['completed_shift_two'] + $result[$i]['completed_shift_three'];
            $result[$i]['total_completed'] = $total_completed;
        }

        $data['moldeo'] =   $result;



        $query2 = $this->db->query("SELECT DISTINCT plants.plant_id as sub_plant_id, plants.plant_name, sites.site_id as sub_site_id,sites.site_name, assets.asset_id AS sub_asset_id, assets.asset_name,
        (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_one,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_one,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_two,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_two,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date'AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_three,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_three
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date' AND plants.plant_id = 7;");

        $result2 = $query2->result_array();

        for ($i = 0; $i < count($result2); $i++) {

            if ($result2[$i]['planned_shift_one']  == NULL) {
                $result2[$i]['planned_shift_one']  = 0;
            }
            if ($result2[$i]['completed_shift_one']  == NULL) {
                $result2[$i]['completed_shift_one']  = 0;
            }

            if ($result2[$i]['planned_shift_two']  == NULL) {
                $result2[$i]['planned_shift_two']  = 0;
            }
            if ($result2[$i]['completed_shift_two']  == NULL) {
                $result2[$i]['completed_shift_two']  = 0;
            }

            if ($result2[$i]['planned_shift_three']  == NULL) {
                $result2[$i]['planned_shift_three']  = 0;
            }
            if ($result2[$i]['completed_shift_three']  == NULL) {
                $result2[$i]['completed_shift_three']  = 0;
            }

            $total_planned2 = $result2[$i]['planned_shift_one'] + $result2[$i]['planned_shift_two'] + $result2[$i]['planned_shift_three'];
            $result2[$i]['total_planned'] = $total_planned2;

            $total_completed2 = $result2[$i]['completed_shift_one'] + $result2[$i]['completed_shift_two'] + $result2[$i]['completed_shift_three'];
            $result2[$i]['total_completed'] = $total_completed2;
        }

        $data['ensamble'] =   $result2;




        $query3 = $this->db->query("SELECT DISTINCT plants.plant_id as sub_plant_id, plants.plant_name, sites.site_id as sub_site_id,sites.site_name, assets.asset_id AS sub_asset_id, assets.asset_name,
        (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_one,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 1
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_one,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_two,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 2
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_two,
         (
        SELECT SUM(plan_by_hours.planned) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date'AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as planned_shift_three,
        (
        SELECT SUM(plan_by_hours.completed) FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plants.plant_id = sub_plant_id
       AND sites.site_id = sub_site_id
       AND assets.asset_id = sub_asset_id
       AND production_plans.shift_id = 3
       AND plan_by_hours.time BETWEEN '$start_date' AND '$end_date'
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_three
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date' AND plants.plant_id = 8;");

        $result3 = $query3->result_array();

        for ($i = 0; $i < count($result3); $i++) {

            if ($result3[$i]['planned_shift_one']  == NULL) {
                $result3[$i]['planned_shift_one']  = 0;
            }
            if ($result3[$i]['completed_shift_one']  == NULL) {
                $result3[$i]['completed_shift_one']  = 0;
            }

            if ($result3[$i]['planned_shift_two']  == NULL) {
                $result3[$i]['planned_shift_two']  = 0;
            }
            if ($result3[$i]['completed_shift_two']  == NULL) {
                $result3[$i]['completed_shift_two']  = 0;
            }

            if ($result3[$i]['planned_shift_three']  == NULL) {
                $result3[$i]['planned_shift_three']  = 0;
            }
            if ($result3[$i]['completed_shift_three']  == NULL) {
                $result3[$i]['completed_shift_three']  = 0;
            }

            $total_planned3 = $result3[$i]['planned_shift_one'] + $result3[$i]['planned_shift_two'] + $result3[$i]['planned_shift_three'];
            $result3[$i]['total_planned'] = $total_planned3;

            $total_completed3 = $result3[$i]['completed_shift_one'] + $result3[$i]['completed_shift_two'] + $result3[$i]['completed_shift_three'];
            $resul3[$i]['total_completed'] = $total_completed3;
        }

        $data['planta3'] =   $result3;


        $data['title'] = ucfirst($page);
        $this->load->view('templates/header');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }
}
