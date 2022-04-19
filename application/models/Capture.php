<?php
class Capture extends CI_Model
{

    public $production_plan_id;


    /*
    * Author: Emanuel Jauregui
    * Date: 04/04/2022
    * Por medio de esta funcion vamos a obtener la hora de plan basados en el timepo actual
    */
    public function get_current_hour($plan_id, $datetime)
    {
        //regresar tambien el item_number

        $this->production_plan_id = $plan_id;
        if (!isset($datetime)) {
            $datetime = new DateTime();
        }
        //Hour minutes seconds, microseconds
        $datetime->setTime($datetime->format("H"), 0, 0, 0);

        $end = clone $datetime;
        $end->add(new DateInterval('PT60M'));

        $this->db->select('plan_by_hour_id');
        $this->db->where('plan_id', $plan_id);
        $this->db->where('time',   $datetime->format(DATETIME_FORMAT));
        $this->db->where('time_end', $end->format(DATETIME_FORMAT));
        $query = $this->db->get('plan_by_hours');
        return $query->result_array()[0]['plan_by_hour_id'];
    }
}
