<?php

class Sites extends CI_Controller{
	public function index(){

		$data['title'] = "Sites";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites', $data);
		$this->load->view('templates/footer');
	}


	public function api_all_by_plant($plant_id)
	{
		$this->load->database();
		$this->db->where('plant_id', $plant_id);
		echo json_encode($this->db->get('sites')->result_array() );
	}

}
