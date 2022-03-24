<?php

class Manual_Capture extends CI_Controller{
	public function index(){
		$data['title'] = "Manual Capture";
		$this->load->view('templates/header');
		$this->load->view('pages/plan/manual_capture', $data);
		$this->load->view('templates/footer');
	}
}
