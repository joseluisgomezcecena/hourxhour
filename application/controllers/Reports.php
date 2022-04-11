<?php

class Reports extends CI_Controller{
	public function daily_report(){
		$data['title'] = "Daily Report"; 
        $this->load->model('planbyhour');
        $this->load->model('capture');
        $this->load->model('shift');

        //$shift_date = $this->shift->getIdFromCurrentTime(new DateTime);
        //$plan = $this->productionplan->getProductionPlan($this->input->get('asset_id'), $shift_date['shift_id'], $shift_date['date']->format(DATE_FORMAT));

        //$plan_by_hour_id = $this->capture->get_current_hour($plan->plan_id);
        //$this->planbyhour->Load($plan_by_hour_id);
   
		$this->load->view('templates/header');
		$this->load->view('pages/reports/daily_report', $data);
		$this->load->view('templates/footer');
	}
    public function custom_report(){
		$data['title'] = "Custom Report";
		$this->load->view('templates/header');
		$this->load->view('pages/reports/custom_report', $data);
		$this->load->view('templates/footer');
	}
}
