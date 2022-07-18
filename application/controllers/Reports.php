<?php

class Reports extends CI_Controller
{
    public function daily_report()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);


        $this->db->select('shift_start_time, shift_end_time');
        $this->db->from('shifts');
        $result_array = $this->db->get()->result_array();

        $start_date_one = date(DATE_FORMAT) . ' ' . $result_array[0]['shift_start_time'];
        $end_date_one = date(DATE_FORMAT) . ' ' . $result_array[0]['shift_end_time'];

        $start_date_two = date(DATE_FORMAT) . ' ' . $result_array[1]['shift_start_time'];
        $end_date_two = date(DATE_FORMAT) . ' ' . $result_array[1]['shift_end_time'];

        $start_date_three = date(DATE_FORMAT) . ' ' . $result_array[2]['shift_start_time'];
        $next_day = new DateTime();
        $next_day->modify('+1 day');
        $end_date_three = $next_day->format(DATE_FORMAT) . ' ' . $result_array[2]['shift_end_time'];


        $start_date = $start_date_one;
        $end_date = $end_date_three;

        $data['title'] = "Reporte Diario";
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
       AND (plan_by_hours.time >= '$start_date_one' AND plan_by_hours.time < '$end_date_one')
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
       AND (plan_by_hours.time >= '$start_date_one' AND plan_by_hours.time < '$end_date_one')
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
       AND (plan_by_hours.time >= '$start_date_two' AND plan_by_hours.time < '$end_date_two')
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
       AND (plan_by_hours.time >= '$start_date_two' AND plan_by_hours.time < '$end_date_two')
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
       AND (plan_by_hours.time >= '$start_date_three' AND plan_by_hours.time < '$end_date_three')
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
       AND (plan_by_hours.time >= '$start_date_three' AND plan_by_hours.time < '$end_date_three')
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_three
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE (plan_by_hours.time >= '$start_date' AND plan_by_hours.time < '$end_date');");

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

        $data['daily_report'] =   $result;
        $this->load->view('templates/header');
        $this->load->view('pages/reports/daily_report', $data);
        $this->load->view('templates/footer');
    }



    public function custom_report()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $start_date = $this->input->get('start_date');
        $end_date  =   $this->input->get('end_date');

        if ($start_date == null) {
            $start_date = new DateTime();
        } else {
            $start_date = new DateTime($start_date);
        }

        if ($end_date == null) {
            $end_date = new DateTime();
        } else {
            $end_date = new DateTime($end_date);
        }
        $end_date = $end_date->modify('+1 day');

        $this->db->select('shift_start_time, shift_end_time');
        $this->db->from('shifts');
        $result_array = $this->db->get()->result_array();

        $start_time_one = $result_array[0]['shift_start_time'];
        $end_time_one = $result_array[0]['shift_end_time'];

        $start_time_two = $result_array[1]['shift_start_time'];
        $end_time_two = $result_array[1]['shift_end_time'];

        $start_time_three_first = $result_array[2]['shift_start_time'];
        $end_time_three_first = '24:00:00';

        $start_time_three_second = '00:00:00';
        $end_time_three_second = $result_array[2]['shift_end_time'];

        $start_date = $start_date->format(DATE_FORMAT) . ' ' . $start_time_one;
        $end_date = $end_date->format(DATE_FORMAT)  . ' ' . $end_time_three_second;



        $data['title'] = "Reporte Personalizado";
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
       AND (HOUR(plan_by_hours.time) >=  '$start_time_one' AND HOUR(plan_by_hours.time) < '$end_time_one')
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
       AND (HOUR(plan_by_hours.time) >=  '$start_time_one' AND HOUR(plan_by_hours.time) < '$end_time_one')
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
       
       AND (HOUR(plan_by_hours.time) >=  '$start_time_two' AND HOUR(plan_by_hours.time) < '$end_time_two')
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
       
       AND (HOUR(plan_by_hours.time) >=  '$start_time_two' AND HOUR(plan_by_hours.time) < '$end_time_two')
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
       
       AND (   (HOUR(plan_by_hours.time) >=  '$start_time_three_first' AND HOUR(plan_by_hours.time) < '$end_time_three_first') OR (HOUR(plan_by_hours.time) >=  '$start_time_three_second' AND HOUR(plan_by_hours.time) < '$end_time_three_second') )
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
       
       AND (   (HOUR(plan_by_hours.time) >=  '$start_time_three_first' AND HOUR(plan_by_hours.time) < '$end_time_three_first') OR (HOUR(plan_by_hours.time) >=  '$start_time_three_second' AND HOUR(plan_by_hours.time) < '$end_time_three_second') )
       GROUP BY plants.plant_id,  sites.site_id, assets.asset_id
        ) as completed_shift_three
       FROM plan_hourxhour.plan_by_hours
       INNER JOIN plan_hourxhour.production_plans ON plan_hourxhour.plan_by_hours.plan_id = plan_hourxhour.production_plans.plan_id
       INNER JOIN assets ON production_plans.asset_id = assets.asset_id
       INNER JOIN sites ON assets.site_id = sites.site_id
       INNER JOIN plants ON sites.plant_id = plants.plant_id
       WHERE (plan_by_hours.time >= '$start_date' AND plan_by_hours.time < '$end_date');");

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

        $data['custom_report'] =   $result;
        $this->load->view('templates/header');
        $this->load->view('pages/reports/custom_report', $data);
        $this->load->view('templates/footer');
    }



    public function detail_report()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $this->load->model('shift');
        //necesitamos la fecha de hoy, el shift_id y el asset_id
        $now = new DateTime();

        $data['title'] = "Detalle de hora por hora";
        //$data['asset_id'] =  $this->input->get('asset_id');
        //$shift_date = $this->shift->getIdFromCurrentTime($now);
        //$data['date'] = $date = $shift_date['date']->format(DATE_FORMAT);

        $this->load->view('templates/header');
        $this->load->view('pages/reports/detail_report', $data);
        $this->load->view('templates/footer');
    }




    public function import_tempus_reports()
    {
        $data['title'] = 'Importar reporte Tempus';
        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_tempus', $data);
        $this->load->view('templates/footer');
    }
    public function import_tempus_reports_post()
    {
        if (isset($_POST["Import"])) {
            $dia_de_la_semana = 2;
            $horas_extra_de_la_semana = 2;
            $columna_supervisor = 0;
            $date = $_POST['date'];

            switch (date('w', strtotime($_POST['date']))) {
                case 1: // Martes -> Nos dara reporte de Lunes
                    $dia_de_la_semana = 2;
                    $horas_extra_de_la_semana = 17;
                    echo '1';
                    break;
                case 2: // Miercoles -> Nos dara reporte de Martes
                    $dia_de_la_semana = 4;
                    $horas_extra_de_la_semana = 18;
                    echo '2';
                    break;
                case 3: // Jueves -> Nos dara reporte de Miercoles
                    $dia_de_la_semana = 6;
                    $horas_extra_de_la_semana = 19;
                    echo '3';
                    break;
                case 4: // Viernes -> Nos dara reporte de Jueves
                    $dia_de_la_semana = 8;
                    $horas_extra_de_la_semana = 20;
                    echo '4';
                    break;
                case 5: // Sabado -> Nos dara reporte de Viernes
                    $dia_de_la_semana = 10;
                    $horas_extra_de_la_semana = 21;
                    echo '5';
                    break;
                case 6: // Domingo -> Nos dara reporte de Sabado
                    $dia_de_la_semana = 12;
                    $horas_extra_de_la_semana = 22;
                    echo '6';
                    break;
                case 7: // Lunes -> Nos dara reporte de Domingo
                    $dia_de_la_semana = 14;
                    $horas_extra_de_la_semana = 23;
                    echo '7';
                    break;
                default:
                    $dia_de_la_semana = 2;
                    $horas_extra_de_la_semana = 17;
                    echo '8';
                    break;
            }

            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                    $extra_hours = $getData[$horas_extra_de_la_semana];
                    $hours = $getData[$dia_de_la_semana];
                    $supervisor = $getData[25];
                    $employee_number = $getData[0];
                    $employee_name = $getData[1];

                    $sql = "INSERT into hours_tempus (employee_number,employee_name,hours,extra_hour,supervisor,posted) 
                           values ('" . $employee_number . "','" . $employee_name . "','" . $hours . "','" . $extra_hours . "','" . $supervisor . "','" . $date . "')";
                    if (!$this->db->simple_query($sql)) {
                        echo 'ocurrio un error en ' . $sql;
                    }
                }
                fclose($file);
            }
        }

        $data['extra_hours'] = $extra_hours;
        $data['employee_number'] = $employee_number;
        $data['employee_name'] = $employee_name;
        $data['supervisor'] = $supervisor;
        $data['date'] = $date;
        $data['hours'] = $hours;
        $data['title'] = 'Importar reporte Tempus';
        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_tempus', $data);
        $this->load->view('templates/footer');
    }

    public function getCleanString($csv, $column_index)
    {
        return trim($this->db->escape_str($csv[$column_index]));
    }

    public function std_hours()
    {
        $data['title'] = 'Importar reporte de horas estandar';
        $data['items_by_minutes'] = $this->db->get('hours_std_xa')->result_array();

        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_std', $data);
        $this->load->view('templates/footer');
    }

    //Code for save csv...
    public function import_std_hours()
    {

        if (count($_FILES['file']['name']) > 0) {

            $this->db->truncate('hours_std_xa');

            for ($file_index = 0; $file_index < count($_FILES['file']['name']); $file_index++) {

                $file = $_FILES["file"]["tmp_name"][$file_index];
                $file_open = fopen($file, "r");

                $current_row = 0;


                //Not located
                $column_item = 0;
                $column_description   = 0;
                $column_planner       = 0;
                $column_whs           = 0;
                $column_posted        = 0;
                $column_txn           = 0;
                $column_order         = 0;
                $column_quantity      = 0;
                $column_posted_time   = 0;


                //code igniter we need to fill out and array of the insert
                $insert_array = array();

                //Este array va a ser para ... 
                $items_array = array();

                while (($csv = fgetcsv($file_open, 5000, ",")) !== false) {

                    //Si es la primer Row entonces vamos a detectar en que columna esta cada una de acuerdo al texto del header
                    //De la columna....


                    if ($current_row == 0) {

                        //in the first row get the columns index...
                        for ($c = 0; $c < count($csv); $c++) {

                            $str = trim($this->db->escape_str($csv[$c]));
                            //Remove the bom....if any
                            if (substr($str, 0, 3) == "\xef\xbb\xbf") {
                                $str = substr($str, 3);
                            }

                            switch ($str) {
                                case "Item": {
                                        $column_item = $c;
                                    }
                                    break;
                                case "Description": {
                                        $column_description = $c;
                                    }
                                    break;
                                case "Planner": {
                                        $column_planner = $c;
                                    }
                                    break;
                                case "Whs": {
                                        $column_whs = $c;
                                    }
                                    break;
                                case "Posted": {
                                        $column_posted = $c;
                                    }
                                    break;
                                case "Txn": {
                                        $column_txn = $c;
                                    }
                                    break;
                                case "Order": {
                                        $column_order = $c;
                                    }
                                    break;
                                case "Quantity": {
                                        $column_quantity = $c;
                                    }
                                    break;
                                case "Posted time": {
                                        $column_posted_time = $c;
                                    }
                                    break;

                                default: {
                                        //echo 'default: ' . $str;
                                    }
                                    break;
                            }
                        }
                    } else {
                        //This is a entire item...
                        $item          = $this->getCleanString($csv, $column_item);
                        $description   = $this->getCleanString($csv, $column_description);
                        $planner       = $this->getCleanString($csv, $column_planner);
                        $whs           = $this->getCleanString($csv, $column_whs);
                        $posted         = $this->getCleanString($csv, $column_posted);
                        $txn           = $this->getCleanString($csv, $column_txn);
                        $order         = $this->getCleanString($csv, $column_order);
                        $quantity      = $this->getCleanString($csv, $column_quantity);
                        $posted_time         = $this->getCleanString($csv, $column_posted_time);



                        if ($item != "" && str_replace("_", "", $item) != "") {

                            $posted = date("Y/m/d", strtotime($posted));
                            $insert_row = array(
                                'item' => $item,
                                'description' => $description,
                                'planner' => $planner,
                                'whs' => $whs,
                                'posted' =>  $posted,
                                'txn' =>  $txn,
                                'order_number' =>  $order,
                                'quantity' =>  $quantity,
                                'posted_time' =>  $posted_time,
                            );

                            //only will set the values of 
                            if (!array_key_exists($item, $items_array)) {
                                $items_array[$item]['posted_time'] = $posted_time;
                                $items_array[$item]['info'] = null;
                            }

                            //inserta un elemento al array
                            $insert_array[] = $insert_row;
                        }
                    }

                    $current_row++;
                } //end of while, all rows are executed

                $items = array_keys($items_array);
                $str_items = implode("', '", $items);

                $sql =  "SELECT routing_identifier, IF( tbc ='2 = Hours / 100 units', ROUND( (SUM(run_labor) * 60) / 100 , 2) , ROUND( SUM(run_labor_mins), 2)) as run_labor_mins_per_item,
                ROUND( SUM(setup_hours) * 60, 2) as setup_mins FROM plan_hourxhour.routing_operations WHERE routing_identifier IN ('$str_items')
                GROUP BY routing_identifier";
                $run_labor_info = $this->db->query($sql)->result_array();

                //echo json_encode($items_array);

                foreach ($run_labor_info as $run_labor_item) {
                    $items_array[$run_labor_item['routing_identifier']]['info'] = $run_labor_item;
                }


                //foreach ($insert_array as $row) {
                for ($r = 0; $r < count($insert_array); $r++) {
                    $found_item = $items_array[$insert_array[$r]['item']];
                    $insert_array[$r]['run_labor_mins_per_item'] = $found_item['info']['run_labor_mins_per_item'];

                    //only give one setup
                    if ($insert_array[$r]['posted_time'] ==  $found_item['posted_time']) {
                        //only set one setup_mins
                        $insert_array[$r]['setup_mins'] = $found_item['info']['setup_mins'];
                    } else {
                        $insert_array[$r]['setup_mins'] = null;
                    }
                }

                $this->db->insert_batch('hours_std_xa', $insert_array);
                //proceed to insert
                //echo json_encode($insert_array);
            }
        }


        //Go to another controller
        redirect('reports/std_hours');
    }
}
