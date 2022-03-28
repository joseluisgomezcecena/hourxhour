<?php

class Reports extends CI_Controller{
	public function daily_report(){
		$data['title'] = "Daily Report";
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
