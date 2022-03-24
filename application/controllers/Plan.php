<?php

class Plan extends CI_Controller{
	public function index(){

		$data['title'] = "Plan";
		$this->load->view('templates/header');
		$this->load->view('pages/plan/index', $data);
		$this->load->view('templates/footer');
	}
}
