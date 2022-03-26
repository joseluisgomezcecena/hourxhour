<?php

class Plan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('shift');
        $this->load->model('productionplan');
    }


    public function index()
    {
		//necesitamos la fecha de hoy, el shift_id y el asset_id
		$now = new DateTime();

        $data['title'] = "Plan";
		$data['asset_id'] = 10;
		$data['shift_id'] = $this->shift->getIdFromCurrentTime( $now );
		$data['date'] = $date = $now->format(DATE_FORMAT);;

		$this->load->view('templates/header');
        $this->load->view('pages/plan/index', $data);
        $this->load->view('templates/footer');
    }


	public function api_get_plan()
	{
		$asset_id = $this->input->get('asset_id');
		$shift_id = $this->input->get('shift_id');
		$date = $this->input->get('date');

		$this->shift->Load($shift_id);
				//Cargar Plan
		$data = $this->productionplan->LoadPlan($asset_id, $date, $shift_id, $this->shift->shift_start_time, $this->shift->shift_end_time);
		echo json_encode($this->productionplan);
	}


	public function test()
	{
				//$shift = new Shift;
				
	}
    
    public function select_cell()
    {
        $data['title'] = "Selección de celda";
        $this->load->view('templates/header');
        $this->load->view('pages/plan/select_cell', $data);
        $this->load->view('templates/footer');
    }

    public function select_measuring_point()
    {
        $data['title'] = "Selección de celda";
        $this->load->view('templates/header');
        $this->load->view('pages/plan/measuring_point', $data);
        $this->load->view('templates/footer');
    }

}
