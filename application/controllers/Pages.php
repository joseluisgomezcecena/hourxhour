<?php

class Pages extends CI_Controller
{
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
			show_404();
		}

		if (!$this->session->userdata(IS_LOGGED_IN))
			redirect('http://localhost/authentication/index.php/home/login?from=' . current_url());

		$data['title'] = ucfirst($page);
		$this->load->view('templates/header');
		$this->load->view('pages/' . $page, $data);
		$this->load->view('templates/footer');
	}
}
