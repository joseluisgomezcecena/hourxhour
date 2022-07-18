<?php

class Assets extends CI_Controller{
	public function index(){

		$data['title'] = "Celdas";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/assets', $data);
		$this->load->view('templates/footer');
	}
}
