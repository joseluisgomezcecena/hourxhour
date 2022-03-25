<?php

class Shift extends CI_Model {


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
        if(count($data) == 1 )
        {
            $row = $data[0];
            $this->shift_name = $row['shift_name'];
            $this->shift_start_time = $row['shift_start_time'];
            $this->shift_end_time = $row['shift_end_time'];

            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
        }
    }




    public function getIdFromCurrentTime($now)
    {
        $result_id = -1;
        $this->db->select("*, TIMEDIFF(shift_end_time, shift_start_time) as difference");
        $this->db->from('shifts');
        $query = $this->db->get();

        $data = $query->result_array();
    

        //$now = new DateTime();
        $current_millis = $now->format('Uv');
        $parsed_current = date_parse( $now->format(DATETIME_FORMAT) );


        //Organizar los datos para incluir todas las horas de tal manera
        foreach($data as $shift)
        {
            $str_to_search = '-';
            //Si hay una fecha negativa debemos de acomodar las horas de tal manera que se cuenten las que sobrepasan
            //de las 23 horas con 59 minutos
            if (substr($shift['difference'], 0, strlen($str_to_search)) === $str_to_search )
            {
                //create dos nuevos
               $first_item = $shift;
               $first_item['shift_end_time'] = '23:59:59';

                
                $second_item = $shift;
                $second_item['shift_start_time'] = '00:00:00';
                
                array_push($data, $first_item);
                array_push($data, $second_item);

            }
        }

        foreach($data as $shift)
        {       
            //$formato = 'Y-m-d';
            //$fecha = DateTime::createFromFormat($formato, '2009-02-15');
            //echo date(DATE_FORMAT);
            $dt_start = new DateTime();
            $dt_end = new DateTime();
            
            $dt_start->setDate($parsed_current['year'], $parsed_current['month'], $parsed_current['day']);
            $dt_end->setDate($parsed_current['year'], $parsed_current['month'], $parsed_current['day']);

            $parsed_start = date_parse( $shift['shift_start_time'] );
            $dt_start->setTime($parsed_start['hour'], $parsed_start['minute'], $parsed_start['second']);
         
            $parsed_end = date_parse( $shift['shift_end_time'] );
            $dt_end->setTime($parsed_end['hour'], $parsed_end['minute'], $parsed_end['second']);

        
            $start_millis = $dt_start->format('Uv');
            $end_millis = $dt_end->format('Uv');
            
            if ($current_millis >= $start_millis && $current_millis < $end_millis)
            {
                $result_id = $shift['shift_id'];
                break;
            }
        }
        return $result_id; 
    }



}