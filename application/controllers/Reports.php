<?php

class Reports extends CI_Controller{
	public function index(){
		$data['title'] = "Reports";
		$this->load->view('templates/header');
		$this->load->view('pages/reports/daily_report', $data);
		$this->load->view('templates/footer');
	}
}
