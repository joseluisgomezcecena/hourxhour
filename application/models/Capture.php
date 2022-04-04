<?php
class Capture extends CI_Model {

    public $production_plan_id;


    /*
    * Author: Emanuel Jauregui
    * Date: 04/04/2022
    * Por medio de esta funcion vamos a obtener la hora basados en el timepo actual
    */
    public function get_current_hour($plan_id)
    {
        $this->production_plan_id = $plan_id;

        $start = new DateTime();
        //Hour minutes seconds, microseconds
        $start->setTime( $start->format("H"),0,0,0);

        $end = clone $start;
        $end->add(new DateInterval('PT60M'));
        
        $this->db->where('plan_id', $plan_id);
        $this->db->where('time',   $start->format(DATETIME_FORMAT));
        $this->db->where('time_end', $end->format(DATETIME_FORMAT));
        $query = $this->db->get('plan_by_hours'); 
        return $query->result_array();
    }


}