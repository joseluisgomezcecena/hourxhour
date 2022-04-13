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

		/*
		$this->load->library('email');

		$subject = 'This is a test';
		$message = '
			<p>This message has been sent for testing purposes.</p>';

			// Get full html:
					$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
				<title>' . html_escape($subject) . '</title>
				<style type="text/css">
					body {
						font-family: Arial, Verdana, Helvetica, sans-serif;
						font-size: 16px;
					}
				</style>
			</head>
			<body>
			' . $message . '
			</body>
			</html>';
			// Also, for getting full html you may use the following internal method:
			//$body = $this->email->full_html($subject, $message);

			// Attaching the logo first.

			// The last additional parameter is set to true in order
			// the image (logo) to appear inline, within the message text:
					//$this->email->attach($file_logo, 'inline', null, '', true);
					//$cid_logo = $this->email->get_attachment_cid($file_logo);
					//$body = str_replace('cid:logo_src', 'cid:'.$cid_logo, $body);
			// End attaching the logo.

			$result = $this->email
				->from('jgomez@martechmedical.com')
				->reply_to('jgomez@martechmedical.com')    // Optional, an account where a human being reads.
				->to('jgomez@martechmedical.com')
				->subject($subject)
				->message($body)
				->send();

			var_dump($result);
			echo '<br />';
			echo $this->email->print_debugger();

			exit;
		*/

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
