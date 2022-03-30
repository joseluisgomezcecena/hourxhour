<?php

class Plan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('shift');
        
        
    }


    public function index()
    {
        
		//necesitamos la fecha de hoy, el shift_id y el asset_id
		$now = new DateTime();

        $data['title'] = "Plan";
		$data['asset_id'] = $asset_id = $this->input->get('asset_id');

		$data['shift_id'] = $this->shift->getIdFromCurrentTime( $now );
		$data['date'] = $date = $now->format(DATE_FORMAT);

   
		$this->load->view('templates/header');
        $this->load->view('pages/plan/index', $data);
        $this->load->view('templates/footer');
    }


	public function api_get_plan()
	{
        $this->load->model('productionplan');
		$asset_id = $this->input->get('asset_id');
		$shift_id = $this->input->get('shift_id');
		$date = $this->input->get('date');

		$this->shift->Load($shift_id);
				//Cargar Plan
		$data = $this->productionplan->LoadPlan($asset_id, $date, $shift_id, $this->shift->shift_start_time, $this->shift->shift_end_time);
		echo json_encode($this->productionplan);
	}


    public function api_get_items()
    {
        //SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number;
        $query = $this->db->query('SELECT item_id, item_number, max( CAST(item_pph AS DECIMAL(10,2)) ) as item_pph, item_run_labor, item_pph FROM plan_hourxhour.items_pph GROUP BY item_number ORDER BY item_number');
        $data['items'] =   $query->result_array();
        echo json_encode($data);
    }


    public function api_get_interruptions()
    {
        $query = $this->db->query('SELECT * FROM interruptions');
        $data['interruptions'] =   $query->result_array();
        echo json_encode($data);
    }


	public function test()
	{
				//$shift = new Shift;
				
	}
    
    public function select_cell()
    {
        //se obtiene el turno en base al DateTime y se carga el modelo del shift
        $shift_id = $this->shift->getIdFromCurrentTime( new DateTime() );
        $plant_id = $this->input->get('plant_id');
        $this->shift->Load( $shift_id);

        $this->load->model('plant');
        $this->plant->Load($plant_id);

        $data['title'] = "Select a Cell for shift: " . $this->shift->shift_name;
        $data['shift'] = $this->shift;
        $data['plant'] =  $this->plant;

        $sql = "SELECT *, (SELECT COUNT(*)  from assets where assets.site_id  = sites.site_id AND assets.asset_active = 1 AND assets.asset_is_pom = 1) as assets_count FROM sites WHERE plant_id = {$plant_id}";
        $query = $this->db->query($sql);
        $data['sites'] =   $query->result_array();
        
        $this->load->view('templates/header');
        $this->load->view('pages/plan/select_cell', $data);
        $this->load->view('templates/footer');
    }

    public function select_measuring_point()
    {
        $data['title'] = "Select a Cell";
        $this->load->view('templates/header');
        $this->load->view('pages/plan/measuring_point', $data);
        $this->load->view('templates/footer');
    }

}
