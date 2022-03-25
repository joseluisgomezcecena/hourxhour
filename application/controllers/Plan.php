<?php

class Plan extends CI_Controller{
	
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('shift');
		$this->load->model('productionplan');
    }


	public function index(){

		
		$data['title'] = "Plan";
		$this->load->view('templates/header');
		$this->load->view('pages/plan/index', $data);
		$this->load->view('templates/footer');
		
	}


	public function test()
	{
				//$shift = new Shift;
				
				$now = new DateTime();

				$asset_id = 10;
				$shift_id = $this->shift->getIdFromCurrentTime( $now );
				$date = $now->format(DATE_FORMAT);
				$this->shift->Load($shift_id);
				//Cargar Plan
				
				$this->productionplan->LoadPlan($asset_id, $date, $shift_id, $this->shift->shift_start_time, $this->shift->shift_end_time);
				
				echo json_encode($this->productionplan);

	}
}
