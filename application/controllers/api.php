<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/*
	* Register new user
	* Private API
	* @params string, string $email, $password
	* @return boolean, true is succesful; false otherwise
	*/

	function register() {
		$client = $this->input->post('id', True);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		if($client && $password && $email) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($client)) {
				$this->_response_success(array());
			} else {
				$this->_response_error_invalid_id();
			}
		} else {
			$this->_response_error_missing_parameters();
		}

	}

	/*
	* Sends success resonse
	* @params array data to be sent to client
	*/
	function _response_success($vars) {
		$data['status'] = true;
		$data['data'] = $vars;
		$this->load->view('api/response', $data);
	}

	/*
	* Error responses
	*/

	function _response_error_missing_parameters() {
		$data['status'] = false;
		$data['data'] = array('reason' => 'Missing parameters');
		$this->load->view('api/response', $data);
	}

	function _response_error_invalid_id() {
		$data['status'] = false;
		$data['data'] = array('reason' => 'Invalid id');
		$this->load->view('api/response', $data);
	}

}