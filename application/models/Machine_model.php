<?php

class Machine_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_plants()
	{
		$query = $this->db->get('plant');
		return $query->result_array();
	}

	public function get_sites($postData)
	{
		$response = array();


		$this->db->select('site_id,site_name');
		$this->db->where('plant_id', $postData['plant_id']);
		$q = $this->db->get('site');
		$response = $q->result_array();

		return $response;

	}

	public function display_machines()
	{
		$query = $this->db->query("SELECT * FROM assets");
		return $query->result();
	}

	public function create_machine()
	{
		if($this->input->post('machine_station') == '1')
		{
			$machine = 1;
			$station = 0;
		}
		else
		{
			$machine = 0;
			$station = 1;
		}

		$pom = $this->input->post('pom') == '1' ? 1 : 0;

		$data = array(
			'asset_site'=> $this->input->post('site_id'),
			'asset_name'=> $this->input->post('machine_name'),
			'asset_control_number'=> $this->input->post('machine_control_number'),
			'asset_work_center'=> $this->input->post('work_center'),
			'asset_active'=> 1,
			'machine'=>$machine,
			'station'=>$station,
			'pom'=> $pom
		);

		return $this->db->insert('assets', $data);


	}

}
