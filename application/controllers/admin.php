<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isLoggedIn() || !$this->auth->isAdmin(null, null, null, null)) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		}
	}

	public function index() {
		echo "Hello";
	}

}