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
		$this->load->view('templates/header');
		$this->load->view('pages/andon/plants/create', $data);
		$this->load->view('templates/footer');
    }
}
