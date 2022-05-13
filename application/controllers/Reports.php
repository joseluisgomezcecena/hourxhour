<?php

class Reports extends CI_Controller
{
    public function daily_report()
    {
        if (!$this->session->userdata(IS_LOGGED_IN))
            redirect(LOGIN_URL);

        $start_date = date(DATE_FORMAT) . ' 0:00:00';
        $end_date = date(DATE_FORMAT) . ' 23:59:59';

        $data['title'] = "Daily Report";
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
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date';");

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

        if (!isset($start_date)) {
            $start_date = date(DATE_FORMAT) . ' 0:00:00';
        }
        if (!isset($end_date)) {
            $end_date = date(DATE_FORMAT) . ' 23:59:59';
        }

        $data['title'] = "Custom Report";
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
       WHERE plan_by_hours.time BETWEEN '$start_date' AND '$end_date';");

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
    public function import_tempus_reports()
    {
        $data['title'] = 'Import Tempus Report';
        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_tempus', $data);
        $this->load->view('templates/footer');
    }
    public function import_tempus_reports_post()
    {
        $date = date('Y/m/d', strtotime($_POST['date']));
        $columna = 2;
        $columna_supervisor = 0;

        switch(date('w', strtotime($_POST['date']))) 
        {
            case 1: // Martes -> Nos dara reporte de Lunes
                $columna = 2;
                echo '1';
                break;
            case 2: // Miercoles -> Nos dara reporte de Martes
                $columna = 4;
                echo '2';
                break;
            case 3: // Jueves -> Nos dara reporte de Miercoles
                $columna = 6;
                echo '3';
                break;
            case 4: // Viernes -> Nos dara reporte de Jueves
                $columna = 8;
                echo '4';
                break;
            case 5: // Sabado -> Nos dara reporte de Viernes
                $columna = 10;
                echo '5';
                break;
            case 6: // Domingo -> Nos dara reporte de Sabado
                $columna = 12;
                echo '6';
                break;
            case 7: // Lunes -> Nos dara reporte de Domingo
                $columna = 14;
                echo '7';
                break;
            default:
                $columna = 2;
                echo '8';
                break;
        } 
        $count = 1;
        $file = $_FILES["file"]["tmp_name"];
        if($file != "")
        {
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
            $column_class         = 0;

            while (($csv = fgetcsv($file_open, 5000, ",")) !== false) {
                echo 'entre';
            }
        }
    }

    public function getCleanString($csv, $column_index)
    {
        return trim($this->db->escape_str($csv[$column_index]));
    }

    public function std_hours()
    {
        $data['title'] = 'Import Standard Hours Report';
        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_std', $data);
        $this->load->view('templates/footer');
    }

    //Code for save csv...
    public function import_std_hours()
    {
        //echo json_encode($_FILES['file']);
        //echo json_encode($this->db->conn_id);

        //if (true) return;

        if (count($_FILES['file']['name']) > 0) {

            for ($file_index = 0; $file_index < count($_FILES['file']['name']); $file_index++) {

                $file = $_FILES["file"]["tmp_name"][$file_index];
                $file_open = fopen($file, "r");

                $current_row = 0;


                //Not located
                $column_item = 0;
                $column_description   = 0;
                $column_planner       = 0;
                $column_whs           = 0;
                $column_posted           = 0;
                $column_txn           = 0;
                $column_order         = 0;
                $column_quantity      = 0;
                $column_posted_time         = 0;


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
                                        echo 'default: ' . $str;
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
                        $txn           = $this->getCleanString($csv, $column_txn);
                        $order         = $this->getCleanString($csv, $column_order);
                        $quantity      = $this->getCleanString($csv, $column_quantity);
                        $class         = $this->getCleanString($csv, $column_posted_time);
                        $posted         = $this->getCleanString($csv, $column_posted);


                        if ($item != "" && str_replace("_", "", $item) != "") {
                            //We read all the data with this condition,...item must have value and also it will not be taked in count the ___________line or void line.
                            $posted = date("Y/m/d", strtotime($posted));

                            //En este punto debemos consultar items_php
                            $this->db->select('item_run_labor, item_setup_hours');
                            $this->db->from('items_pph');
                            $this->db->where('item_number', $item);

                            $labor_array = $this->db->get()->result_array();

                            $run_labor = 0;
                            $yield = 1;
                            $setup = 0;

                            if (count($labor_array) > 0) {

                                foreach ($labor_array as $row_labor) {
                                    $run_labor += $row_labor['item_run_labor'];
                                    //$yield *= $row_labor['cur_yield'] != 0 ? $row_labor['cur_yield'] : 1;
                                    $setup += $row_labor['item_setup_hours'];
                                }
                            }

                            //Se va a insertar o actualizar el item...
                            $this->db->select('*');
                            $this->db->from('hours_std_xa');
                            $this->db->where('order_number', $order);
                            $this->db->where('posted', $posted);

                            $data = array();

                            if ($this->db->get()->num_rows == 0) {
                                //$query = "INSERT INTO `horas_std_xa`(`item`,`description`, `planner`, `whs`, `posted`, `txn`, `order_number`, `quantity`, `class`, rates, yield, setup, std_hours) 
                                //VALUES('$item','$description','$planner','$whs','$posted','$txn','$order','$quantity','$class', '$run_labor','$yield','$setup',' $std_hours');"; 
                            } else {
                                //$query = "UPDATE horas_std_xa SET `quantity` = `quantity` + $quantity, rates = '$run_labor', yield = '$yield', setup = '$setup', std_hours = '$std_hours', `posted` = '$posted'
                                //WHERE item = '$item' AND order_number = '$order' AND posted = '$posted'";
                            }
                        }
                    }



                    $current_row++;
                }
            }
        }

        /*
        $data['title'] = 'Import Standard Hours Report';
        $this->load->view('templates/header');
        $this->load->view('pages/reports/import_reports/import_hrs_std', $data);
        $this->load->view('templates/footer');
        */
    }


    public function getCleanString($csv, $column_index)
    {
        return trim($this->db->escape_str($csv[$column_index]));
    }
}
