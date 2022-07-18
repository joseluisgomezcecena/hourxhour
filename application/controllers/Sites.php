<?php

class Sites extends CI_Controller
{
	public function index()
	{

		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Celdas";

		$data['sites'] = $this->Site->getAll();

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/index', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{

		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$site_name = $this->input->post('site_name');

		$data['title'] = "Celdas";
		$data['plants'] = $this->Plant->getAllActive();

		$this->form_validation->set_rules('site_name', 'Site Name', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');

		if (isset($_POST['save_site'])) {
			if ($this->form_validation->run() === TRUE) {

				//first check if if site has already the same site_name
				$this->db->where('site_name', $site_name);
				$query = $this->db->get('sites');
				if ($query->num_rows() > 0) {
					$data['message_title'] = 'Información del hora por hora';
					$data['message_description'] = 'La Celda' . $site_name . ' ya existe. El nombre de la celda no puede ser reemplazado.';
					$data['message_type'] = 'error';
				} else {
					//this can be created...
					$this->Site->create();
					$data['message_title'] = 'Informacion del hora por hora';
					$data['message_description'] = 'La celda ' . $site_name . ' ha sido agregada al sistema';
					$data['message_type'] = 'success';
				}
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

		$data['title'] = "Actualizar Celda";
		$data['site'] = $this->Site->getSingle($id);
		$data['plants'] = $this->Plant->getAllActive();

		if (empty($data['site'])) {
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/edit', $data);
		$this->load->view('templates/footer');
	}


	public function update()
	{
		$site_name = $this->input->post('site_name');
		$id = $this->input->post('id');
		$this->form_validation->set_rules('site_name', 'Site Name', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');

		if ($this->form_validation->run() === TRUE) {

			//first check if if site has already the same site_name
			$this->db->where('site_name', $site_name);
			$query = $this->db->get('sites');
			if ($query->num_rows() > 0) {
				$data['message_title'] = 'Información de hora por hora';
				$data['message_description'] = 'La celdas ' . $site_name . ' ya existen. El nombre de la celda no puede ser reemplazado';
				$data['message_type'] = 'error';
			} else {
				//this can be modified...
				$this->Site->update();
				$data['message_title'] = 'Información del hora por hora';
				$data['message_description'] = 'La celda ' . $site_name . ' ha sido actualizada';
				$data['message_type'] = 'success';
			}
		} else {
			$data['message_title'] = 'información del hora por hora';
			$data['message_description'] = 'No se proporciono el nombre de la celda o la planta';
			$data['message_type'] = 'error';
		}

		$data['title'] = "Update Site";
		$data['site'] = $this->Site->getSingle($id);
		$data['plants'] = $this->Plant->getAllActive();

		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/edit', $data);
		$this->load->view('templates/footer');
	}


	public function confirm_delete($id)
	{
		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect(LOGIN_URL);

		$data['title'] = "Actualizar Celda";
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
			$data['message_title'] = 'Información del hora por hora';
			$data['message_description'] = 'La celda no puede ser eliminada porque ya tiene un punto de medición';
			$data['message_type'] = 'error';
		} else {

			$this->db->where('site_id', $site_id);
			$this->db->delete('sites');

			$data['message_title'] = 'Información del hora por hora';
			$data['message_description'] = 'La celda se eliminó correctamente';
			$data['message_type'] = 'success';
		}

		$data['title'] = "Actualizar Celda";
		$data['site'] = $this->Site->getSingle($site_id);
		$data['plants'] = $this->Plant->getAllActive();
		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites/delete', $data);
		$this->load->view('templates/footer');
	}







	public function api_all_by_plant($plant_id)
	{
		$this->load->database();
		$this->db->where('plant_id', $plant_id);
		echo json_encode($this->db->get('sites')->result_array());
	}
}
