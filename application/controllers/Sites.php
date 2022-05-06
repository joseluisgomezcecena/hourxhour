<?php

class Sites extends CI_Controller
{
	public function index()
	{

		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Sites";

		$data['sites'] = $this->Site->getAll();

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/index', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{

		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Sites";

		$data['plants'] = $this->Plant->getAllActive();

		$this->form_validation->set_rules('site_name', 'Site Name', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');


		if (isset($_POST['save_site'])) {
			if ($this->form_validation->run() === TRUE) {
				$this->Site->create();
			}
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/create', $data);
		$this->load->view('templates/footer');
	}




	public function edit($id)
	{
		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Update Site";
		$data['site'] = $this->Site->getSingle($id);
		$data['plants'] = $this->Plant->getAllActive();

		if (empty($data['site'])) {
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/edit', $data);
		$this->load->view('templates/footer');
	}


	public function confirm_delete($id)
	{
		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Update Site";
		$data['site'] = $this->Site->getSingle($id);
		$data['plants'] = $this->Plant->getAllActive();

		if (empty($data['site'])) {
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/delete', $data);
		$this->load->view('templates/footer');
	}

	public function delete()
	{
		$site_id = $this->input->post('id');
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('assets');

		if ($query->num_rows() > 0) {
			$data['title'] = "Site could not be deleted";
			$data['message'] = "You have assets in this site  and cannot be deleted.";
			$data['url'] =  base_url() . "sites";
			$this->load->view('pages/errors/includes/header');
			$this->load->view('pages/errors/index', $data);
			$this->load->view('pages/errors/includes/footer');
			return;
		}

		$this->db->where('site_id', $site_id);
		$this->db->delete('sites');

		redirect('sites');
	}



	public function update()
	{
		$this->Site->update();
		redirect('sites');
	}



	public function api_all_by_plant($plant_id)
	{
		$this->load->database();
		$this->db->where('plant_id', $plant_id);
		echo json_encode($this->db->get('sites')->result_array());
	}
}
