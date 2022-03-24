<?php

include_once('application/models/Plant.php');

class TestsController extends CI_Controller{
	
    public function index(){

		/*$data['title'] = "Sites";
		$this->load->view('templates/header');
		$this->load->view('pages/andon/sites', $data);
		$this->load->view('templates/footer');*/
	
    }


    public function plant_show()
    {
      $plant = new Plant(1);
      
      echo $plant->plant_name;
      echo json_encode($plant); 
    }

    public function plant_create()
    {
        $plant = new Plant;
        $plant->plant_name = "Planta 3";
        $plant->plant_use_password = 1; 
        $plant->plant_password = "planta3";
        $plant->plant_active = 1;
        $plant->Save();

        echo json_encode($plant);
    }

    public function plant_update()
    {
        $plant = new Plant(1);
        $plant->plant_name = "Planta Update 1";
        $plant->Save();

        echo json_encode($plant);
    }


    public function plant_delete()
    {
        $plant = new Plant(1);
        $plant->plant_name = "Planta Update 1";
        $plant->Save();

        echo json_encode($plant);
    }

    public function test_angular()
    {
      $data['title'] = "Assets";
      $this->load->view('templates/header');
      $this->load->view('pages/andon/angular', $data);
      $this->load->view('templates/footer');
    }

}
