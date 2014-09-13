<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends RR_Maincontractor {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isContractor()) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		} else {
			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);
			$this->load->view('contract/job.php', $data);
			$this->load->view('app/footer', $data);
		}
	}
}