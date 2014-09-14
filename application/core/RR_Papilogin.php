<?php

require(APPPATH.'core/RR_Apilogin.php');

/**
 * APIs that require user to be logged in should extend this class
 */
class RR_Papilogin extends RR_Apilogin {

	protected $user_data = array();

	public function __construct(){
		parent::__construct();

		$this->load->model('auth_model', 'auth');
		$nonce = $this->input->get_request_header('Auth-nonce', true);
		
		if(!$nonce || !$this->auth->checkNonce($nonce, $this->user_data->email)){
			$this->_response_error(14);
		}
	}
}