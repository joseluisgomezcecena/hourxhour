<?php

class ProductionPlan extends CI_Model
{

    protected $table = 'production_plans';

    public $plan_id;
    
    //unique
    public $asset_id;
    public $date;
    public $shift_id;

    public $supervisor_id;

    public $create_at;
    public $updated_at;

    public $plan_by_hours = array();
    
    protected $start_hour = '23:00:00';
    protected $end_hour = '04:00:00';


    public function LoadPlan($asset_id, $date, $shift_id, $start_hour, $end_hour)
    {
        $this->start_hour = $start_hour;
        $this->end_hour = $end_hour;

        
        //check if exists
        $this->db->where('asset_id', $asset_id);
        $this->db->where('date', $date);
        $this->db->where('shift_id', $shift_id);
        $query = $this->db->get($this->table);
        $data = $query->result_array();

        if(count($data) == 0 )
        {
            //Create One
            $this->asset_id = $asset_id;
            $this->date = $date;
            $this->shift_id = $shift_id;

            $this->supervisor_id = NULL;
            $now = new DateTime(DATETIME_FORMAT);
            $this->created_at = $now;
            $this->updated_at = $now;

            $this->db->insert($this->table, $data);
            //Save the production plan id
            $this->plan_id = $this->db->insert_id();
            $this->GenerateHours();
        } else
        {
            $row = $data[0];
            $this->LoadProperties($row);
        }

        return ReadProperties();
        
    }



    public function LoadProperties($row)
    {
        $this->plan_id = $row['plan_id'];
        $this->$asset_id = $row['asset_id'];
        $this->$date= $row['date'];
        $this->$shift_id= $row['shift_id'];
        $this->$supervisor_id= $row['supervisor_id'];
        $this->$create_at= $row['create_at'];
        $this->$udated_at= $row['udated_at'];
    }

    public function ReadProperties()
    {
        $row = array();
        $row['plan_id'] = $this->plan_id;
        $row['asset_id'] = $this->$asset_id;
        $row['date']  = $this->$date;
        $row['shift_id'] = $this->$shift_id;
        $row['supervisor_id'] = $this->$supervisor_id;
        $row['create_at'] = $this->$create_at;
        $row['udated_at'] = $this->$udated_at;
        return $row;
    }

    const time_interval_in_minutes = 60;


    public function GenerateHours()
    {
        $interval_in_milliseconds = self::time_interval_in_minutes  * 60 * 1000;

        echo $interval_in_milliseconds;

        $start_date = date_create($this->date);
        $parsed_start = date_parse( $this->start_hour );
        $start_date->setTime($parsed_start['hour'], $parsed_start['minute'], $parsed_start['second']);
      
        $end_date = date_create($this->date);
        $parsed_end = date_parse( $this->end_hour );
        $end_date->setTime($parsed_end['hour'], $parsed_end['minute'], $parsed_end['second']);

        $start_millis = $start_date->format('Uv');
        $end_millis = $end_date->format('Uv');

        if( ($end_millis - $start_millis) < 0)
        {
            $end_date->add(new DateInterval('P1D'));
            $end_millis = $end_date->format('Uv');
        }



    }

}