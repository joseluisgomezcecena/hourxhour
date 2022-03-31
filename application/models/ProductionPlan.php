<?php

class ProductionPlan extends CI_Model
{

    protected $table = 'production_plans';
    protected $table_hours = 'plan_by_hours';

    public $plan_id;
    
    public $asset_id;
    public $asset_name;

    public $date;
    public $date_end;

    public $shift_id;
    public $shift_name;

    public $site_id;
    public $site_name;

    public $plant_id;
    public $plant_name;

    public $supervisor_id;

    public $created_at;
    public $updated_at;

    public $hc;

    public $plan_by_hours = array();
    
    protected $start_hour = '23:00:00';
    protected $end_hour = '04:00:00';


    public function LoadPlan($asset_id, $date, $shift_id, $start_hour, $end_hour)
    {
        //echo "load plan" . $asset_id . ", " . $date . ", " . $shift_id . ", " . $start_hour . ", " . $end_hour ;
 
        $this->start_hour = $start_hour;
        $this->end_hour = $end_hour;

        
        $select = '*, shifts.shift_name as shift_name, assets.site_id as site_id, ';
        $select .= 'assets.asset_name as asset_name, assets.asset_id as asset_id, ';
        $select .= 'sites.site_id as site_id, sites.site_name as site_name, ';
        $select .= 'plants.plant_id as plant_id, plants.plant_name as plant_name';

        //check if exists
        $this->db->select( $select);
        //

        $this->db->where('production_plans.asset_id', $asset_id);
        $this->db->where('production_plans.date', $date);
        $this->db->where('production_plans.shift_id', $shift_id);

        $this->db->join('shifts', 'production_plans.shift_id = shifts.shift_id', 'inner');
        $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
        $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
        $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');

        $this->db->from('production_plans');

        $query = $this->db->get();    
        $data = $query->result_array();
      
        $this->asset_id = $asset_id;

        if(count($data) == 0 )
        {
            //echo "debug 01" . $this->db->last_query();;

            $select = 'assets.asset_name as asset_name, ';
            $select .= 'sites.site_id as site_id, sites.site_name as site_name, ';
            $select .= 'plants.plant_id as plant_id, plants.plant_name as plant_name ';
            $this->db->select( $select);        
            $this->db->where('assets.asset_id', $asset_id);
            $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
            $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');
            $this->db->from('assets');
            $queryAssets = $this->db->get();    
            $rowAssets = $queryAssets->result_array()[0];

            $this->asset_name = $rowAssets['asset_name'];//foreign
    
            //site
            $this->site_id =  intval( $rowAssets['site_id'] );
            $this->site_name = $rowAssets['site_name'];//foreign
    
            //plant
            $this->plant_id = intval($rowAssets['plant_id'] );
            $this->plant_name = $rowAssets['plant_name'];//foreign

            $this->date = $date;
            $this->shift_id = $shift_id;
            $this->supervisor_id = NULL;
            $this->hc = 1;
            
            //$now = new DateTime();
            //$this->created_at = $now->format(DATETIME_FORMAT);
            //$this->updated_at = $now->format(DATETIME_FORMAT);
            //$data = $this->ReadProperties();
            //echo json_encode($data);

            //$this->db->insert($this->table, $data);
            //Save the production plan id
            //$this->plan_id = $this->db->insert_id();

            $this->GenerateHours();
        } else
        {
            //echo "debug 02";

            $row = $data[0];
            $this->LoadProperties($row);
            //$this->plan_id = $row['plan_id'];
            $this->LoadHours();
        }

        //echo json_encode($this);
        
    }



    public function LoadProperties($row)
    {
        $this->plan_id = intval( $row['plan_id'] );

        $this->asset_id = intval( $row['asset_id'] );
        $this->asset_name = $row['asset_name'];//foreign

        //site
        $this->site_id =  intval( $row['site_id'] );
        $this->site_name = $row['site_name'];//foreign

        //plant
        $this->plant_id = intval($row['plant_id'] );
        $this->plant_name = $row['plant_name'];//foreign

        $this->date= $row['date'];

        $this->shift_id= intval($row['shift_id']);
        $this->shift_name= $row['shift_name'];//foreign

        $this->hc= intval($row['hc']) ;

        $this->supervisor_id= intval( $row['supervisor_id'] );
        $this->created_at= $row['created_at'];
        $this->updated_at= $row['updated_at'];
    }

    public function ReadProperties()
    {
        $row = array();
        $row['plan_id'] = intval($this->plan_id);
        $row['asset_id'] = intval($this->asset_id);
        $row['date']  = $this->date;
        $row['shift_id'] = intval($this->shift_id);
        $row['supervisor_id'] = intval($this->supervisor_id);
        $row['created_at'] = $this->created_at;
        $row['updated_at'] = $this->updated_at;
        $row['hc'] = intval($this->hc);
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
            
            $date_end = new DateTime();
            $date_end->setTimeStamp( ($m + $interval_in_milliseconds ) / 1000);
            
            //$plan_by_hour['plan_id'] = $this->plan_id;
            
            $plan_by_hour['time'] = $date->format(DATETIME_FORMAT);
            $plan_by_hour['time_end'] = $date_end->format(DATETIME_FORMAT);

            $plan_by_hour['created_at'] = $this->created_at;
            $plan_by_hour['updated_at'] = $this->created_at;
            //$this->db->insert($this->table_hours, $plan_by_hour);

            array_push($this->plan_by_hours, $plan_by_hour); 
            
        }       
    }


    public function LoadHours()
    {
        //$this->db->where('plan_id', $this->plan_id);
        //$this->db->order_by('time', 'ASC');
        //$this->table_hours

        $query = $this->db->query('SELECT * from plan_by_hours WHERE plan_id = ' . $this->plan_id . " ORDER BY time ASC");
        $this->plan_by_hours = $query->result_array();   
        
        //echo json_encode($this->plan_by_hours);
    }

}