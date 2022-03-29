<?php

class Button_Tablet extends CI_Controller{
	public function index(){
		$data['title'] = "Button Tablet";
		$this->load->view('templates/header_logged_out');
		$this->load->view('pages/plan/button_tablet', $data);
		$this->load->view('templates/footer');
	}
}
