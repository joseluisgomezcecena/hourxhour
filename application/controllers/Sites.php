<?php

class Sites extends CI_Controller{
	public function index(){

		$data['title'] = "Sites";

		$data['sites'] = $this->Site->getAll();

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/index', $data);
		$this->load->view('templates/footer');
	}

    public function create(){

		$data['title'] = "Sites";

		$data['plants'] = $this->Plant->getAllActive();

		$this->form_validation->set_rules('site_name', 'Site Name', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');


		if(isset($_POST['save_site']))
		{
			if($this->form_validation->run()===TRUE)
			{
				$this->Site->create();
			}
		}



		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/create', $data);
		$this->load->view('templates/footer');
	}




	public function edit($id)
	{
		$data['title'] = "Update Site";
		$data['site'] = $this->Site->getSingle($id);
		$data['plants'] = $this->Plant->getAllActive();


		if(empty($data['site']))
		{
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/edit', $data);
		$this->load->view('templates/footer');
	}


	public function api_all_by_plant($plant_id)
	{
		$this->load->database();
		$this->db->where('plant_id', $plant_id);
		echo json_encode($this->db->get('sites')->result_array() );
	}

}
