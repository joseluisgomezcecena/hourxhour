<?php

class Measuring_Point extends CI_Controller
{




	public function index()
	{

		$this->load->model('shift');


		$shift_date = $this->shift->getIdFromCurrentTime(new DateTime());

		$plant_id  = $this->input->get('plant_id');
		$site_id  =   $this->input->get('site_id');

		$data['title'] = "Measuring Point";
		$data['plant_id'] = $plant_id;
		$data['site_id'] = $site_id;

		//SELECT production_plans.asset_id, production_plans.site_id, production_plans.asset_name, (SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '2015-02-03 08:00:00' AND shift_id = 5)
		// as plan_id FROM assets WHERE assets.asset_active=1 AND assets.site_id = 8

		$sql = "SELECT assets.asset_id, assets.site_id, assets.asset_name, ";
		$sql .= "(SELECT plan_id FROM production_plans WHERE production_plans.asset_id = assets.asset_id AND production_plans.date = '{$shift_date['date']->format(DATE_FORMAT)}' AND shift_id = {$shift_date['shift_id']}) as plan_id FROM assets ";
		$sql .= "WHERE assets.asset_active=1 AND assets.site_id = {$site_id} AND assets.asset_is_pom = 1";


		$query = $this->db->query($sql);
		$data['production_plans'] =   $query->result_array();

		//echo json_encode($data);

		$this->load->view('templates/header');
		$this->load->view('pages/plan/measuring_point', $data);
		$this->load->view('templates/footer');
	}
}
