<?php

class Trigger extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Trigger";
        $this->load->view('templates/header_logged_out');
        $this->load->view('pages/andon/trigger/index', $data);
        $this->load->view('templates/footer');
    }
}
