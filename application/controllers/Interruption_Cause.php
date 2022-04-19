<?php
class Interruption_Cause extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Interruption Cause";
        $this->load->view('templates/header');
        $this->load->view('pages/interruption_cause/index', $data);
        $this->load->view('templates/footer');
    }
}
