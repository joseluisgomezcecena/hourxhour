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
        $now = DateTime::createFromFormat(DATETIME_FORMAT, '2022-03-25 10:00:00');

        $asset_id = 10;
        $shif_id = $this->shift->getIdFromCurrentTime($now);
        $date = $now->format(DATE_FORMAT);

        //echo $now->format(DATE_FORMAT);

        $this->productionplan->date = $now->format(DATETIME_FORMAT);
        $this->productionplan->GenerateHours();
    }
}
