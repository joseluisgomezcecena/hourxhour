<?php

class Posts extends CI_Controller{
	public function index(){

		$data['title'] = "Post List";
		$this->load->view('templates/header');
		$this->load->view('posts/index', $data);
		$this->load->view('templates/footer');
	}
}
