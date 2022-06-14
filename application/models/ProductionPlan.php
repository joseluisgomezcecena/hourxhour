<?php

/*
* Author: Emanuel Jauregui 
* Martech Number: 46716
* 
* Production Plan is a model for a production plan in hour by hour
* To summarize we can say that a production plan has a plan_id, asset_id, date. shift_id, supervisor and all this info is saved in productions_plans
* each production plan has a hour item thant is saved in plan_by_hours table 
*/
class ProductionPlan extends CI_Model
{

    protected $table = 'production_plans';
    protected $table_hours = 'plan_by_hours';

    /* 
    * the next public variables represents the properties of the production plan, all items will be saved in database...and are properties that belong to class
    */
    public $plan_id;

    public $asset_id;
    public $asset_name;

    public $date;

    //public $shift_id;
    //public $shift_name;

    public $site_id;
    public $site_name;

    public $plant_id;
    public $plant_name;

    public $supervisor;

    public $created_at;
    public $updated_at;

    public $hc;

    public $use_multiplier_factor;
    public $multiplier_factor;


    /*
    * the next array is used to control the hours of the plan, each hour is sabed in plan_by_hours table
    */
    public $plan_by_hours = array();


    /*
    * $start_hour and $end_hour are variables that represent the time when tha plan initiate and end hour is the time when the plan finalizes   
    * theses two variables are used only when the the hours are generated, I mean when the production plan and plan by hours are not saved in database storage
    * the starting values are not really important because the LoadPlan function is the generator of the values.
    */


    public function LoadPlan($asset_id, $date)
    {
        //initialize variables
        $this->plan_id = NULL;
        unset($this->plan_by_hours);
        $this->plan_by_hours = array();

        /*
         * This query is created to retrieve a production plan
         * it selects a single item of a production plan based on the asset_id, date, and shift_id
         * also retrieves the asset, site and plant info, the info array is assigned to the $data variable 
         * */

        $select = '*, assets.site_id as site_id, ';
        $select .= 'assets.asset_name as asset_name, assets.asset_id as asset_id, ';
        $select .= 'sites.site_id as site_id, sites.site_name as site_name, ';
        $select .= 'plants.plant_id as plant_id, plants.plant_name as plant_name';

        $this->db->select($select);
        $this->db->where('production_plans.asset_id', $asset_id);
        $this->db->where('production_plans.date', $date);

        $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
        $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
        $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');

        $this->db->from('production_plans');

        $query = $this->db->get();
        $data = $query->result_array();

        $this->asset_id = $asset_id;


        /*
        * This condition allow us to make a condition, if data is not found then we just 
        * fill the production plan with default values to be prepared for a later moment to save all the info with save click button
        *  With the calling of $this->GenerateHours(), we generate the hours that will be saved in plan_by_hours table
        * we are preparing to generate insert in mysql database
        */
        if (count($data) == 0) {

            $select = 'assets.asset_name as asset_name, ';
            $select .= 'sites.site_id as site_id, sites.site_name as site_name, ';
            $select .= 'plants.plant_id as plant_id, plants.plant_name as plant_name ';
            $this->db->select($select);
            $this->db->where('assets.asset_id', $asset_id);
            $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
            $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');
            $this->db->from('assets');
            $queryAssets = $this->db->get();
            $rowAssets = $queryAssets->result_array()[0];

            $this->asset_name = $rowAssets['asset_name']; //foreign

            //site
            $this->site_id =  intval($rowAssets['site_id']);
            $this->site_name = $rowAssets['site_name']; //foreign

            //plant
            $this->plant_id = intval($rowAssets['plant_id']);
            $this->plant_name = $rowAssets['plant_name']; //foreign

            $this->date = $date;
            $this->supervisor = NULL;
            $this->hc = 1;

            $this->use_multiplier_factor = false;
            $this->multiplier_factor = NULL;

            //The shift is not neccessary anymore...
            //Load shift_name with $shift_id
            //$this->db->select('shift_short_name');
            //$this->db->where('shift_id', $shift_id);
            //$this->db->from('shifts');
            //$this->shift_name = $this->db->get()->result_array()[0]['shift_short_name'];

            $this->GenerateHours();
        } else {
            /*
            * If a plan is alread saved we just load the properties and the array of hours 
            * We are preparing to generate updates in mysql database
            */
            $row = $data[0];
            $this->LoadProperties($row);
            //$this->plan_id = $row['plan_id'];
            $this->LoadHours();
        }
    }

    /*
    *  LoadProperis as the name suggests
    * is a function that fill the properties variables of the class with
    * a production plan from database
    */
    public function LoadProperties($row)
    {
        $this->plan_id = intval($row['plan_id']);

        $this->asset_id = intval($row['asset_id']);
        $this->asset_name = $row['asset_name']; //foreign

        //site
        $this->site_id =  intval($row['site_id']);
        $this->site_name = $row['site_name']; //foreign

        //plant
        $this->plant_id = intval($row['plant_id']);
        $this->plant_name = $row['plant_name']; //foreign

        $this->date = $row['date'];

        $this->hc = intval($row['hc']);

        $this->supervisor = $row['supervisor'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];

        $this->use_multiplier_factor = intval($row['use_multiplier_factor']);
        $this->multiplier_factor = intval($row['multiplier_factor']);
    }



    /*
    * is the reverse function of LoadProperties
    * ReadProperties just generate an array based on the class properties 
    * for practicity is not used because all the save functions are located in the Plan controlled with the api_save_plan() function
    */
    public function ReadProperties()
    {
        $row = array();
        $row['plan_id'] = intval($this->plan_id);
        $row['asset_id'] = intval($this->asset_id);
        $row['date']  = $this->date;
        $row['shift_id'] = intval($this->shift_id);
        $row['supervisor'] = intval($this->supervisor);
        $row['created_at'] = $this->created_at;
        $row['updated_at'] = $this->updated_at;
        $row['hc'] = intval($this->hc);
        $row['use_multiplier_factor'] = intval($this->use_multiplier_factor);
        $row['multiplier_factor'] = intval($this->multiplier_factor);
        return $row;
    }





    const time_interval_in_minutes = 60;

    /*
    * GenerateHours is a function that creates all the plan_by_hours items of a production plan. 
    * const time_interval_in_minutes = 60; gives us the minutes of separation for each item
    * for example if we set interval to 30 minutes, then we generate a plan_by_hour for 7:00, 7:30, 8:00, 8:30... and so on.
    * the counting of the time start at start_time of the plan based in the info of the current shift
    *
    * it gives milliseconds from datetime (Shortest version of string variant (32-bit compatibile):)
    * $milliseconds = date_create()->format('Uv');
    * P1D is one day of interval
    */

    public function GenerateHours()
    {
        //Create 24 hours of each day...
        //El turno comienza a las 6 de la mañANA
        $start_date = date_create($this->date);
        $start_date = $start_date->setTime(6, 0, 0);

        $end_date = date_create($this->date);
        $end_date = $end_date->setTime(7, 0, 0);

        for ($h = 0; $h < 24; $h++) {

            $plan_by_hour['time'] = $start_date->format(DATETIME_FORMAT);
            $plan_by_hour['time_end'] = $end_date->format(DATETIME_FORMAT);
            $plan_by_hour['created_at'] = $this->created_at;
            $plan_by_hour['updated_at'] = $this->created_at;
            array_push($this->plan_by_hours, $plan_by_hour);

            $start_date->modify("+1 hour");
            $end_date->modify("+1 hour");
        }
    }


    /*
    * When a plan is saved in database then we can load the plan_by_hours items, this can be done with LoadHours
    * is is just a query for retrieve the items of the production plan including items_pph and interruptions
    */
    public function LoadHours()
    {
        $query = $this->db->query('SELECT plan_by_hours.*, items_pph.item_number, interruptions.interruption_name from plan_by_hours LEFT JOIN items_pph ON plan_by_hours.item_id = items_pph.item_id LEFT JOIN interruptions ON plan_by_hours.interruption_id = interruptions.interruption_id WHERE plan_id = ' . $this->plan_id . " ORDER BY time ASC");
        $this->plan_by_hours = $query->result_array();
    }


    /* 
    *  getProductionPlan retrieves prodution plan based on asset_id, shift_id, and date,
    * these three elements are unique in productions_plans table and it makes easy to get current running plan based on current time.
    */
    public function getProductionPlan($asset_id, $date)
    {
        $this->db->select('production_plans.*, assets.asset_name, sites.site_name, plants.plant_name');
        $this->db->from('production_plans');

        $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
        $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
        $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');

        $this->db->where('production_plans.asset_id', $asset_id);
        $this->db->where('production_plans.date', $date);
        $query = $this->db->get();
        $result = $query->result();

        if (count($result) > 0) {
            return $result[0];
        } else {
            return NULL;
        }
    }


    /*
    * getProductionPlanById  brings the plan info based on the id 
    * is used when we need to make an update based on the id, when the production plan is already saved on database.
    * used only in manual capture
    */
    public function getProductionPlanById($plan_id)
    {
        $this->db->select('production_plans.*, assets.asset_name, sites.site_name, plants.plant_name');
        $this->db->from('production_plans');

        $this->db->join('assets', 'production_plans.asset_id = assets.asset_id', 'inner');
        $this->db->join('sites', 'assets.site_id = sites.site_id', 'inner');
        $this->db->join('plants', 'sites.plant_id = plants.plant_id', 'inner');

        $this->db->where('plan_id', $plan_id);

        $query = $this->db->get();
        $result = $query->result();

        if (count($result) > 0) {
            return $result[0];
        } else {
            return NULL;
        }
    }
}
