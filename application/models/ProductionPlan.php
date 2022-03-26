<?php

class ProductionPlan extends CI_Model
{

    protected $table = 'production_plans';
    protected $table_hours = 'plan_by_hours';

    public $plan_id;
    
    //unique
    public $asset_id;
    public $date;

    public $shift_id;
    public $shift_name;

    public $site_id;
    public $site_name;

    public $plant_id;
    public $plant_name;

    public $supervisor_id;

    public $created_at;
    public $updated_at;

    public $plan_by_hours = array();
    
    protected $start_hour = '23:00:00';
    protected $end_hour = '04:00:00';


    public function LoadPlan($asset_id, $date, $shift_id, $start_hour, $end_hour)
    {
        //echo "load plan" . $asset_id . ", " . $date . ", " . $shift_id . ", " . $start_hour . ", " . $end_hour ;
 
        $this->start_hour = $start_hour;
        $this->end_hour = $end_hour;

        
        //check if exists
        $this->db->select('*, shifts.shift_name as shift_name');
        
        $this->db->where('production_plans.asset_id', $asset_id);
        $this->db->where('production_plans.date', $date);
        $this->db->where('production_plans.shift_id', $shift_id);

        $this->db->join('shifts', 'production_plans.shift_id = shifts.shift_id');
        $this->db->from('production_plans');

        $query = $this->db->get();
        $data = $query->result_array();

        if(count($data) == 0 )
        {
            //Create One
            $this->asset_id = $asset_id;
            $this->date = $date;
            $this->shift_id = $shift_id;
            $this->supervisor_id = NULL;
            
            $now = new DateTime();
            $this->created_at = $now->format(DATETIME_FORMAT);
            $this->updated_at = $now->format(DATETIME_FORMAT);
            $data = $this->ReadProperties();
            //echo json_encode($data);

            $this->db->insert($this->table, $data);
            //Save the production plan id
            $this->plan_id = $this->db->insert_id();
            $this->GenerateHours();
        } else
        {
            $row = $data[0];
            $this->LoadProperties($row);
            $this->plan_id = $row['plan_id'];
            $this->LoadHours();
        }

        $data['plan_id'] = $this->plan_id; 
        return $data;
        
    }



    public function LoadProperties($row)
    {
        $this->plan_id = $row['plan_id'];
        $this->asset_id = $row['asset_id'];
        $this->date= $row['date'];
        $this->shift_id= $row['shift_id'];
        $this->shift_name= $row['shift_name'];
        $this->supervisor_id= $row['supervisor_id'];
        $this->created_at= $row['created_at'];
        $this->updated_at= $row['updated_at'];
    }

    public function ReadProperties()
    {
        $row = array();
        //$row['plan_id'] = $this->plan_id;
        $row['asset_id'] = $this->asset_id;
        $row['date']  = $this->date;
        $row['shift_id'] = $this->shift_id;
        $row['shift_name'] = $this->shift_name;
        $row['supervisor_id'] = $this->supervisor_id;
        $row['created_at'] = $this->created_at;
        $row['updated_at'] = $this->updated_at;
        return $row;
    }

    const time_interval_in_minutes = 60;


    public function GenerateHours()
    {
        $interval_in_milliseconds = self::time_interval_in_minutes  * 60 * 1000;

        //echo $interval_in_milliseconds;

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

        //echo "start " . $start_date->format(DATETIME_FORMAT) . " ";
        //echo "end " . $end_date->format(DATETIME_FORMAT) . " ";
        //$plan_by_hours
        for($m=$start_millis; $m < $end_millis ;  $m+=$interval_in_milliseconds )
        {
            $date = new DateTime();
            $date->setTimeStamp($m / 1000);
            
            
            $plan_by_hour['plan_id'] = $this->plan_id;
            $plan_by_hour['time'] = $date->format(DATETIME_FORMAT);
            $plan_by_hour['created_at'] = $this->created_at;
            $plan_by_hour['updated_at'] = $this->created_at;
            $this->db->insert($this->table_hours, $plan_by_hour);

            array_push($this->plan_by_hours, $plan_by_hour); 
            
        }       
    }


    public function LoadHours()
    {
        $this->db->where('plan_id', $this->plan_id);
        $this->db->order_by('time', 'ASC');
        $query = $this->db->get($this->table_hours);
        $this->plan_by_hours = $query->result_array();              
    }

}