<?php

class Measuring_Point extends CI_Controller{
	public function index(){
		$data['title'] = "Measuring Point";
		$this->load->view('templates/header');
		$this->load->view('pages/plan/measuring_point', $data);
		$this->load->view('templates/footer');

	}
}
