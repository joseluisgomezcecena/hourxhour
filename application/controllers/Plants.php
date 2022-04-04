<?php



class Plants extends CI_Controller{
	public function index(){

		$data['title'] = "Plants";

		$data['plants'] = $this->Plant->getAllActive();

		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants/index', $data);
		$this->load->view('templates/footer');
	}

	

	public function api_all()
	{
		$this->load->database();
		echo json_encode($this->db->get('plants')->result_array() );
	}




    public function create(){
        $data['title'] = "Create plant";

		$this->form_validation->set_rules('plant_name', 'Plant Name', 'required');
		$this->form_validation->set_rules('plant_password', 'Plant Password', 'required');


		if(isset($_POST['save_plant']))
		{
			if($this->form_validation->run()===TRUE)
			{
				$this->Plant->save();
			}
		}
		
		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants/create', $data);
		$this->load->view('templates/footer');
    }


	public function edit($id)
	{
		$data['title'] = "Update Plant";
		$data['plant'] = $this->Plant->display_single_plant($id);

		if(empty($data['plant']))
		{
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants/edit', $data);
		$this->load->view('templates/footer');
	}


	public function update()
	{
		$this->Plant->update();
		redirect('plants');
	}

}
