<?php

class Machines extends CI_Controller{
	public function index(){

		$data['title'] = "Machines";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/machines', $data);
		$this->load->view('templates/footer');
	}
}
