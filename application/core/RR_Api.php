<?php

/**
 * API controller class
 *
 * @version 1.0
 * @package ci_controller
 */
class RR_Api extends CI_Controller {
	
	protected $auth_data = array( 'client_id' => null, 'client_token' => null);

	/**
	 * The constructor
	 *
	 * Check rate limit.
	 */
	public function __construct(){
		parent::__construct();
		
		$this->load->model('client_model', 'client');
		
		$id = $this->input->get_request_header('Auth-id', true);

		$valid = ($id ? $this->client->isValid($id) : false);
		$rate_limit = ($valid ? $this->client->check_rate_limit($id) : false);

		if($id && $valid && $rate_limit ) {
			$auth['client_id'] = $id;
			$this->client->log_request($id, uri_string(), $_SERVER['REMOTE_ADDR']);
		} else if (!$id || !$valid){
			$this->_response_error(11);
		} else if (!$rate_limit) {
			$this->_response_error(12);
		} else {
			$this->_response_error(9999);
		}
	}

	/**
	 * Sends success resonse
	 * @param array data to be sent to client
	 */
	protected function _response_success($vars) {
		$data['status'] = true;
		$data['data'] = $vars;
		$this->load->view('api/response', $data);
	}

	/**
	 * Returns an error
	 * Stops execution after output
	 *
	 * @param int $id The error id
	 */
	protected function _response_error($id) {
		switch ($id) {
			case 1:		// Missing parameters
				$data['data'] = array('reason' => 'Missing parameters');
				break;
			case 2:
				$data['data'] = array('reason' => 'Invalid id');
				break;
			case 3:
				$data['data'] = array('reason' => 'User exist');
				break;
			case 4:
				$data['data'] = array('reason' => 'User do not exist');
				break;
			case 5:
				$data['data'] = array('reason' => 'Password and email do not match');
				break;
			case 6:
				$data['data'] = array('reason' => 'Invalid path');
				break;
			case 7:
				$data['data'] = array('reason' => 'Invalid token');
				break;
			case 8:
				$data['data'] = array('reason' => 'Invalid category');
				break;
			case 9:
				$data['data'] = array('reason' => 'Invalid area type');
				break;
			case 10:
				$data['data'] = array('reason' => 'Image upload failed. Check file size.');
				break;
			case 11:
				$data['data'] = array('reason' => 'Invalid Client');
				break;
			case 12:
				$data['data'] = array('reason' => 'Rate limit exceeded');
				break;
			case 13:
				$data['data'] = array('reason' => 'Not a contractor');
				break;
			default:
				$data['data'] = array('reason' => 'Error');
				break;
		}

		$data['status'] = false;
		$this->load->view('api/response', $data);
		$this->output->_display();
		exit();
	}
}

/**
 * APIs that require user to be logged in should extend this class
 */
class RR_Apilogin extends RR_Api {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model', 'client');

		$email = $this->auth->getEmail($client, $token);
	}
}


/**
 * Contractor API controller
 */
class RR_Apicontractor extends RR_Apilogin {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isContractor()) {
			$this->_response_error(13);
		}
	}
}