<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isContractor()) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		} else {
			$this->laod->model('contractor_model', 'con');
			$email = $this->auth->isLoggedIn();
			$con_data = $this->con->getData($email);

			
		}
	}
}