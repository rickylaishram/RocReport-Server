<?php

/**
 * Main login class
 *
 * @version 1.0
 * @package ci_controller
 */
class RR_Mainlogin extends CI_Controller {
	
	protected $data = array(
			'is_logged_in' 	=> false,
			'is_admin' 		=> false,
			'is_super_admin'=> false,
			'is_contractor'	=> false,
		);

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
		$this->data['user_data'] = $this->user->get($email);

		$this->data['is_logged_in'] = true;
		$this->data['is_admin'] = false; // Always false for now
		$this->data['is_super_admin'] = $this->auth->isSuperAdmin($this->data['user_data']->email);

		// Set the tokens, ids etc for JS
		$browser = $this->config->item('browser');
		$this->data['auth']['id'] = $this->session->userdata($browser['cookie']['auth']);
		$this->data['auth']['token'] = $browser['id'];
		$this->data['auth']['nonce'] = $this->auth->generateNonce($this->data['user_data']->email);
	}

}