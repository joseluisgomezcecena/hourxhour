<?php

class Plan extends CI_Controller{
	
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('shift');
		$this->load->model('productionplan');
    }


	public function index(){

		//$shift = new Shift;
		$now = new DateTime();

		$asset_id = 10;
		$shif_id = $this->shift->getIdFromCurrentTime( $now );
		$date = $now->format(DATETIME_FORMAT);

		$this->productionplan->date = $now->format(DATETIME_FORMAT);
		$this->productionplan->GenerateHours();
		/*
		$data['title'] = "Plan";
		$this->load->view('templates/header');
		$this->load->view('pages/plan/index', $data);
		$this->load->view('templates/footer');
		*/
	}
}
