<?php

class Machine_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}


	public function get_plants()
	{
		$query = $this->db->get('plants');
		return $query->result_array();
	}


	public function get_sites($postData)
	{
		$response = array();

		$this->db->select('site_id,site_name');
		$this->db->where('plant_id', $postData['plant_id']);
		$q = $this->db->get('sites');
		$response = $q->result_array();

		return $response;
	}

	public function display_machines()
	{
		//$query = $this->db->get("assets");
		$this->db->select ( '*' );
		$this->db->from ( 'assets' );
		$this->db->join ( 'sites', 'sites.site_id = assets.site_id' , 'left' );
		$this->db->join ( 'plants', 'plants.plant_id = sites.plant_id' , 'left' );
		$query = $this->db->get();
		return $query->result_array();
	}



	public function display_single($id)
	{
		$query = $this->db->get_where("assets", array('asset_id' => $id));
		return $query->result_array();
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
			'site_id'=> $this->input->post('site_id'),
			'asset_name'=> $this->input->post('machine_name'),
			'asset_control_number'=> $this->input->post('machine_control_number'),
			'asset_work_center'=> $this->input->post('work_center'),
			'asset_active'=> 1,
			'asset_is_machine'=>$machine,
			'asset_is_station'=>$station,
			'asset_is_pom'=> $pom
		);

		return $this->db->insert('assets', $data);

	}


	public function delete_machine($id)
	{
		$this->db->where('asset_id', $id);
		$this->db->delete('assets');
		return true;
	}


}
