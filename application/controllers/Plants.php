<?php

include_once('application/models/Plant.php');

class Plants extends CI_Controller{
	public function index(){

		$data['title'] = "Plants";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants', $data);
		$this->load->view('templates/footer');
	}


	public function api_all()
	{
		$this->load->database();
		echo json_encode($this->db->get('plants')->result_array() );
	}
}
