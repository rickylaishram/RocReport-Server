<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class API extends CI_Controller {

	function __construct() {
		
	}

	/*
	* Register new user
	* Private API
	* @params string, string $email, $password
	* @return boolean, true is succesful; false otherwise
	*/

	function register() {
		$clientId = $this->input->get_request_header('Client-Id', True);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		$this->load->model('client_model', 'client');
		var_dump($this->model->isValid($clientId));

	}

}