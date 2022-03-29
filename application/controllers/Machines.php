<?php

class Machines extends CI_Controller{

	public function index(){

		$data['title'] = "Machines";
		//$data['plants'] = $this->Machine_model->get_plants();

		$data['machines'] = $this->Machine_model->display_machines();

		//$data['debug'] = print_r($this->db->last_query());

		$this->load->view('templates/header');
		$this->load->view('machines/index', $data);
		$this->load->view('templates/footer');
	}



	public function create()
	{
		$data['title'] = "Add Machine or Asset";
		$data['plants'] = $this->Machine_model->get_plants();

		$this->form_validation->set_rules('plant_id', 'Plant', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');
		$this->form_validation->set_rules('work_center', 'Work Center', 'required');
		$this->form_validation->set_rules('machine_name', 'Machine Name', 'required');


		if( isset($_POST['save_machine']))
		{

			if($this->form_validation->run()===TRUE)
			{
				$this->Machine_model->create_machine();
				//debug
				//print_r($this->db->last_query());
			}

		}


		$this->load->view('templates/header');
		$this->load->view('machines/create', $data);
		$this->load->view('templates/footer');
	}


	public function view($id)
	{
		$data['machines'] = $this->Machine_model->display_single($id);

		$data['title'] = "Machine Details";

		if(empty($data['machines']))
		{
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('machines/view', $data);
		$this->load->view('templates/footer');
	}




	public function edit($id)
	{
		$data['title'] = "Update Asset";
		$data['plants'] = $this->Machine_model->get_plants();
		$data['machine'] = $this->Machine_model->display_single($id);

		if(empty($data['machine']))
		{
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('machines/edit', $data);
		$this->load->view('templates/footer');
	}



	public function update()
	{
		$this->Machine_model->update_machine();
		redirect('machines');
	}



	public function delete($id)
	{
		$this->Machine_model->delete_machine($id);
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
