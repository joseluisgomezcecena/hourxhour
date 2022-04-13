<?php
class Output_VS_Plan extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Output vs plan";
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/output_vs_plan/index', $data);
        $this->load->view('templates/footer');
    }
}
