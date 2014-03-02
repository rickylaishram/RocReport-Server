<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

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

		var_dump($clientId);
		var_dump($email);
		var_dump($password);

		if($clientId && $password && $email) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($clientId)) {
				$data['status'] = true;
				$data['data'] = array('reason' => 'valid clientid');
				
				$this->load->view('api/response', $data);
			} else {
				$data['status'] = false;
				$data['data'] = array('reason' => 'Invalid clientid');
				
				$this->load->view('api/response', $data);
			}
		}

	}

}