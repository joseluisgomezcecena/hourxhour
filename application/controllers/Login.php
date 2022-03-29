<?php

class Login extends CI_Controller{
	public function index(){
		$data['title'] = "Login";
		$this->load->view('pages/login/includes/header');
		$this->load->view('pages/login/index', $data);
		$this->load->view('pages/login/includes/footer'); 
	}
}
