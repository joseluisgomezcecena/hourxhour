<?php

class Plants extends CI_Controller{
	public function index(){

		$data['title'] = "Plants";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants', $data);
		$this->load->view('templates/footer');
	}
}
