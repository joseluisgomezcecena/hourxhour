<?php

class Andon extends CI_Controller{
	public function index(){

		$data['title'] = "Andon";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/index', $data);
		$this->load->view('templates/footer');
	}
}
