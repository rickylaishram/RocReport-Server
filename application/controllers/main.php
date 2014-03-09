<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	function index(){
		$this->load->view('app/header');
		$this->load->view('app/navbar');
		$this->load->view('app/footer');
	}
}