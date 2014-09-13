<?php

/**
 * Main login class
 *
 * @version 1.0
 * @package ci_controller
 */
class RR_Mainlogin extends CI_Controller {
	
	protected $user_data = array();

	public function __construct(){
		parent::__construct();

		$this->load->model('auth_model', 'auth');
		$email = $this->auth->isLoggedIn();

		if(!$email) {
			$this->output->set_header('Location: '.base_url()."auth/login?next=add_report");
			$this->output->set_status_header('302');
			$this->output->_display();

			exit();
		}
		$this->load->model('user_model', 'user');
		$this->user_data = $this->user->get($email);
	}

}