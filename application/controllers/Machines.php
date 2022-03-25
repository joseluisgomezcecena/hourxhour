<?php

class Machines extends CI_Controller{
	public function index(){

		$data['title'] = "Machines";
		//$data['plants'] = $this->Machine_model->get_plants();

		$data['machines'] = $this->Machine_model->display_machines();

		$this->load->view('templates/header');
		$this->load->view('machines/index', $data);
		$this->load->view('templates/footer');
	}



	public function create()
	{
		$data['title'] = "Add Machine or Asset";
		$data['plants'] = $this->Machine_model->get_plants();

		if( isset($_POST['save_machine']))
		{
			$this->Machine_model->create_machine();

			//debug
			//print_r($this->db->last_query());

		}


		$this->load->view('templates/header');
		$this->load->view('machines/create', $data);
		$this->load->view('templates/footer');
	}










	//Ajax dropdowns
	public function get_sites(){
		// POST data
		$postData = $this->input->post();

		// load model
		$this->load->model('Machine_model');

		// get data
		$data = $this->Machine_model->get_sites($postData);
		echo json_encode($data);
	}

}
