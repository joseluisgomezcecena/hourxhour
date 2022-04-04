<?php

class PlanByHour extends CI_Model
{

    
    public $plan_by_hour_id;
    public $plan_id;
    public $time;
    public $time_end;
    public $planned;

    public $item_id;

    //foreign
    public $item_number;
    public $completed;
    

    public $error;
    const NOT_FOUND_PLAN_BY_HOUR_ID = 1;
    const NOT_FOUND_ITEM_ID = 1;

    public function Load($id)
    {
        $this->db->where('plan_by_hour_id', $id );
        $query = $this->db->get('plan_by_hours');

        $data = $query->result();

        if(count($data) == 0)
        {
            $error = self::NOT_FOUND_PLAN_BY_HOUR_ID;
            return false;
        }

        $plan_by_hour = $data[0]; 

        $this->plan_by_hour_id = $plan_by_hour->plan_by_hour_id;
        $this->plan_id = $plan_by_hour->plan_id;
        $this->time = $plan_by_hour->time;
        $this->time_end = $plan_by_hour->time_end;
        $this->planned = $plan_by_hour->planned;
        $this->item_id = $plan_by_hour->item_id;
        $this->completed = $plan_by_hour->completed;

        $this->db->where('item_id', $plan_by_hour->item_id );
        $query = $this->db->get('items_pph');
        $items = $query->result();
        if(count($items) == 0 )
        {
            $error = self::NOT_FOUND_ITEM_ID;
            return false;
        }

        $this->item_number = $items[0]->item_number;
        return true;
    }

}