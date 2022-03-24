<?php

class Sites extends CI_Controller{
	public function index(){

		$data['title'] = "Sites";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites', $data);
		$this->load->view('templates/footer');
	}
}
