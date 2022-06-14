<?php

class Shift extends CI_Model
{


    protected $table = 'shifts';

    public $shift_id;
    public $shift_name;
    public $shift_start_time;
    public $shift_end_time;

    public $created_at;
    public $updated_at;

    public function __construct()
    {
    }

    public function Load($id)
    {
        $this->shift_id = $id;

        $this->db->where('shift_id', $this->shift_id);
        $query = $this->db->get($this->table);
        $data = $query->result_array();
        if (count($data) == 1) {
            $row = $data[0];
            $this->shift_name = $row['shift_name'];
            $this->shift_start_time = $row['shift_start_time'];
            $this->shift_end_time = $row['shift_end_time'];

            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
        }
    }



    /*
        Author: Emanuel Jauregui
        Esta formula esta hecha para regresar la fecha y el shift_id en la que comienza el turno,
        solo es para tomar en cuenta las fechas (dias mes año), no sirve para la hora actual
        solo regresa el id del turno de la hora actual y como resultado regresa un array con el shift_id y con la fecha en la que el turno comienza
        no debe de utilizarse para los datos del tiempo.
    */
    public function getIdFromCurrentTime($now)
    {

        $result['shift_id'] = -1;
        $result['date'] = $now;

        $this->db->select("*, TIMEDIFF(shift_end_time, shift_start_time) as difference");
        $this->db->from('shifts');
        $query = $this->db->get();

        $data = $query->result_array();


        //$now = new DateTime();
        $current_millis = $now->format('Uv');
        $parsed_current = date_parse($now->format(DATETIME_FORMAT));


        //Organizar los datos para incluir todas las horas de tal manera
        foreach ($data as $shift) {
            //$shift['date'] = $now;

            $str_to_search = '-';
            //Si hay una fecha negativa debemos de acomodar las horas de tal manera que se cuenten las que sobrepasan
            //de las 23 horas con 59 minutos
            if (substr($shift['difference'], 0, strlen($str_to_search)) === $str_to_search) {
                //create dos nuevos
                $first_item = $shift;
                $first_item['shift_end_time'] = '23:59:59';

                $second_item = $shift;
                $second_item['shift_start_time'] = '00:00:00';

                array_push($data, $first_item);
                array_push($data, $second_item);
            }
        }

        foreach ($data as $shift) {
            //$formato = 'Y-m-d';
            //$fecha = DateTime::createFromFormat($formato, '2009-02-15');
            //echo date(DATE_FORMAT);
            $dt_start = new DateTime();
            $dt_end = new DateTime();

            $dt_start->setDate($parsed_current['year'], $parsed_current['month'], $parsed_current['day']);
            $dt_end->setDate($parsed_current['year'], $parsed_current['month'], $parsed_current['day']);

            $parsed_start = date_parse($shift['shift_start_time']);
            $dt_start->setTime($parsed_start['hour'], $parsed_start['minute'], $parsed_start['second']);

            $parsed_end = date_parse($shift['shift_end_time']);
            $dt_end->setTime($parsed_end['hour'], $parsed_end['minute'], $parsed_end['second']);


            $start_millis = $dt_start->format('Uv');
            $end_millis = $dt_end->format('Uv');

            /*Esta condicion es para mencionar que a pesar de que el turno es de las 0 horas a la hora en la que empieza el 1er turno
            se debe de restar un dia, ya que el turno en realidad comenzo el dia anterior (es decir se trata del turno tercero.)
            */

            if ($current_millis >= $start_millis && $current_millis < $end_millis) {
                $result['shift_id'] = $shift['shift_id'];

                if ($shift['shift_start_time'] == '00:00:00')
                    $result['date'] = $now->modify("-1 day");

                break;
            }
        }

        return $result;
    }


    public function all()
    {
        $query = $this->db->get('shifts');
        return $query->result();
    }


    /*
    * Author: Emanuel Jauregui
    * Date: 04/05/2022
    * El proposito de esta funcion es traer un arreglo con los turnos y con el dia
    */
    /*public function get_shifts_with_date()
    {
        $current = new DateTime();

        //$this->db->select('*, IF( shift_start_time < shift_end_time, HOUR(timediff(shift_end_time, shift_start_time)),  (24 + HOUR(shift_end_time)) - HOUR(shift_start_time) )  as diff');
        //$this->db->from('shifts');

        $query = $this->db->get('shifts');
        $shifts = $query->result_array();

        for ($i = 0; $i < count($shifts); $i++) {
            $shifts[$i]['date'] = $current;
        }

        $hour = $current->format(TIME_FORMAT);

        //$compare = new DateTime();
        $compare = $shifts[0]['shift_start_time'];

        if (strcmp($hour, $compare) < 0) {
            $shift_removed = array_pop($shifts);
            $date_removed = new DateTime();
            $shift_removed['date'] = $date_removed->modify("-1 day");
            array_unshift($shifts, $shift_removed);
        }

        return $shifts;
    }*/
}
