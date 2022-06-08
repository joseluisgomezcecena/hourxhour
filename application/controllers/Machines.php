<?php

class Machines extends CI_Controller
{

	public function index()
	{


		$data['title'] = "Measuring point";
		//$data['plants'] = $this->Machine_model->get_plants();

		$data['machines'] = $this->Machine_model->display_machines();

		//$data['debug'] = print_r($this->db->last_query());
		//$this->sendMail(93);

		$this->load->view('templates/header');
		$this->load->view('machines/index', $data);
		$this->load->view('templates/footer');
	}


	public function create()
	{
		$data['title'] = "Add output / measuring point";
		$data['plants'] = $this->Machine_model->get_plants();

		$this->form_validation->set_rules('plant_id', 'Plant', 'required');
		$this->form_validation->set_rules('plant_id', 'Plant', 'required');
		$this->form_validation->set_rules('work_center', 'Work Center', 'required');
		$this->form_validation->set_rules('machine_name', 'Machine Name', 'required');


		if (isset($_POST['save_machine'])) {
			if ($this->form_validation->run() === TRUE) {
				$this->Machine_model->create_machine();
				$data['message_title'] = 'Well done!';
				$data['message_description'] = 'Your Machine has been added.';
				$data['message_type'] = 'success';
			} else {
				$data['message_title'] = 'Ups! Something went wrong!';
				$data['message_description'] = 'Please try again';
				$data['message_type'] = 'error';
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

		if (empty($data['machines'])) {
			show_404();
		}

		$this->load->view('templates/header');
		$this->load->view('machines/view', $data);
		$this->load->view('templates/footer');
	}




	public function edit($id)
	{
		$data['title'] = "Update measuring point";
		$data['plants'] = $this->Machine_model->get_plants();
		$data['machine'] = $this->Machine_model->display_single($id);

		$data['sites'] = $this->Machine_model->display_sites_by_plant($data['machine']['plant_id']);

		if (empty($data['machine'])) {
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
		if ($this->Machine_model->delete_machine($id)) {
			redirect('machines');
		} else {
			$data['title'] = "Asset could not be deleted";
			$data['message'] = "You have assets that belongs to a production plan, for this reason you cannot delete the asset.";
			$data['url'] =  base_url() . "machines";
			$this->load->view('pages/errors/includes/header');
			$this->load->view('pages/errors/index', $data);
			$this->load->view('pages/errors/includes/footer');
		}
	}


	/*
	public function sendMail($plan_id)
	{
		$id = $plan_id;

		$recipients = array();
		//getting data for email.
		$query = $this->db->query('SELECT * FROM production_plans 
    LEFT JOIN assets ON production_plans.asset_id = assets.asset_id 
    LEFT JOIN sites ON assets.site_id = sites.site_id 
    LEFT JOIN plants ON sites.plant_id = plants.plant_id 
    LEFT JOIN mail_list ON mail_list.plant_id = plants.plant_id 
	WHERE production_plans.plan_id = $id');

		$result = $query->result_array();

		foreach ($result as $item)
		{
		 	$recipients[] =  $item['email'];
		}

		echo $emails = implode(',', $recipients);




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




			$result = $this->email
				->from('jgomez@martechmedical.com')
				->reply_to('jgomez@martechmedical.com')    // Optional, an account where a human being reads.
				//->to('jgomez@martechmedical.com')
				->to("$emails")
				->subject($subject)
				->message($body)
				->send();

			var_dump($result);
			echo '<br />';
			echo $this->email->print_debugger();
			exit;
	}
	*/





	//Ajax dropdowns
	public function get_sites()
	{
		// POST data
		$postData = $this->input->post();

		// load model
		$this->load->model('Machine_model');

		// get data
		$data = $this->Machine_model->get_sites($postData);
		echo json_encode($data);
	}
}
