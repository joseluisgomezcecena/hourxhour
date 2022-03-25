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
        $title = "";
        $message = "";
        $icon = "";

        $data['message'] =
            <<<DELEMETER
            <script>
            Swal.fire(
            '{$title}',
            '{$message}',
            '{$icon}')
            </script>
    DELEMETER;
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
