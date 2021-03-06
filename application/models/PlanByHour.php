<?php

class PlanByHour extends CI_Model
{


    public $plan_by_hour_id;
    public $plan_id;
    public $time;
    public $time_end;
    public $planned;

    public $item;
    public $workorder;


    public $completed;
    public $planned_head_count;


    public $error;
    const NOT_FOUND_PLAN_BY_HOUR_ID = 1;
    const NOT_FOUND_ITEM_ID = 1;

    public function Load($id)
    {
        $this->db->where('plan_by_hour_id', $id);
        $query = $this->db->get('plan_by_hours');

        $data = $query->result_array();
        if (count($data) == 0) {
            $error = self::NOT_FOUND_PLAN_BY_HOUR_ID;
            return $error;
        }

        $plan_by_hour = $data[0];

        $this->plan_by_hour_id = $plan_by_hour['plan_by_hour_id'];
        $this->plan_id = $plan_by_hour['plan_id'];
        $this->time = $plan_by_hour['time'];
        $this->time_end = $plan_by_hour['time_end'];
        $this->planned = $plan_by_hour['planned'];
        $this->item = $plan_by_hour['item'];
        $this->completed = $plan_by_hour['completed'];
        $this->workorder = $plan_by_hour['workorder'];
        $this->planned_head_count = $plan_by_hour['planned_head_count'];

        /*$this->db->where('item_id', $plan_by_hour['item_id']);
        $query = $this->db->get('items_pph');
        $items = $query->result_array();
        if (count($items) == 0) {
            $error = self::NOT_FOUND_ITEM_ID;
            return false;
        }

        $this->item_number = $items[0]['item_number'];
        */

        if ($this->item == null || $this->item == '') {
            $error = self::NOT_FOUND_ITEM_ID;
            return false;
        }

        return true;
    }


    public function IncrementCompleted($value, $reset = false, $capture_type = 0)
    {
        $data['plan_by_hour_id'] = $this->plan_by_hour_id;
        $data['completed_init'] = $this->completed;
        $data['completed_increment'] = $reset ? 0 : $value;
        $data['capture_type'] = $capture_type;

        $current = new DateTime;
        $data['created_at'] =  $current->format(DATETIME_FORMAT);
        $data['updated_at'] = $current->format(DATETIME_FORMAT);

        if ($reset) {
            $this->completed = $value;
        } else {
            $this->completed += $value;
        }
        $data['completed'] = $this->completed;

        //$plan_by_hour_id;
        $this->db->set('completed', $this->completed);
        $this->db->where('plan_by_hour_id', $this->plan_by_hour_id);
        $this->db->update('plan_by_hours'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2

        //insert register production_records
        //plan_by_hour_id, completed_init, completed_increment, completed, created_at, updated_at, capture_type = 0 sensor, 1 table, 2 desktop
        $this->db->set($data);
        $this->db->insert('production_records');
    }
}
