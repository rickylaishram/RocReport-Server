<?php

require(APPPATH.'core/RR_Api.php');

/**
 * APIs that require user to be logged in should extend this class
 */
class RR_Apilogin extends RR_Api {

	protected $user_data = array();

	public function __construct(){
		parent::__construct();
		
		$client = $this->input->get_request_header('Auth-id', true);
		$token = $this->input->get_request_header('Auth-token', true);
		
		if(!$client || !$token)
			$this->_response_error(1);

		$this->load->model('auth_model', 'auth');

		$email = $this->auth->getEmail($client, $token);

		if(!$email)
			$this->_response_error(14);

		$this->load->model('user_model', 'user');
		$this->user_data = $this->user->get($email);
	}
}