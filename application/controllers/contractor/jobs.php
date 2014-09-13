<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends RR_Maincontractor {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		
		$this->load->view('app/header', $data);
		$this->load->view('app/navbar', $data);
		$this->load->view('contract/job.php', $data);
		$this->load->view('app/footer', $data);
	}
}