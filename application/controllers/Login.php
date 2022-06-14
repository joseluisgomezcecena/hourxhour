<?php

class Login extends CI_Controller
{


	public function index()
	{
		$data['title'] = "Login";
		$this->load->view('pages/login/includes/header');
		$this->load->view('pages/login/index', $data);
		$this->load->view('pages/login/includes/footer');
	}



	public function verify_login()
	{
		$level_value = $this->input->get('user_level_value');
		if ($level_value == 0) {

			$data['title'] = "Information";
			$data['message'] = "You have no level permission for access.";
			$data['url'] = SERVER_PATH_URL . "hourxhour/";

			$this->load->view('pages/errors/includes/header');
			$this->load->view('pages/errors/index', $data);
			$this->load->view('pages/errors/includes/footer');
		} else {
			$this->session->set_userdata(IS_LOGGED_IN, TRUE);
			$this->session->set_userdata(EMAIL, $this->input->get('user_email'));
			$this->session->set_userdata(NAME, $this->input->get('user_name'));
			$this->session->set_userdata(LASTNAME, $this->input->get('user_lastname'));
			$this->session->set_userdata(MARTECH_NUMBER, $this->input->get('user_martech_number'));
			$this->session->set_userdata(LEVEL_NAME, $this->input->get('user_level_name'));
			$this->session->set_userdata(LEVEL_VALUE, $this->input->get('user_level_value'));
			redirect($this->input->get('from'));
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('/');
	}
}
