<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/*
	* Handles register and login
	*/
	function auth($path="") {
		switch ($path) {
			case 'register':
				$this->_register();
				break;
			case 'login':
				$this->_login();
				break;
			default:
				$this->_response_error(6);
				break;
		}
	}





	/*
	* Register new user
	* Private API
	* @params string, string $email, $password
	*/

	function _register() {
		$client = $this->input->post('id', True);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);
		$name = $this->input->post('name', True);

		if($client && $password && $email & $name) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($client)) {
				$this->load->model('user_model', 'user');

				if(!$this->user->exist($email)) {
					$this->load->model('auth_model', 'auth');

					$salt = $this->auth->generateSalt();
					$hashedpassword = $this->auth->hash($password, $salt);
					$this->user->add($email, $hashedpassword, $salt, $name);

					$this->_response_success(array());
				} else {
					$this->_response_error(3);
				}
			} else {
				$this->_response_error(2);
			}
		} else {
			$this->_response_error(1);
		}
	}

	/*
	* Login
	* Private API
	* @params string, string $email, $password
	*/
	function _login() {
		$client = $this->input->post('id', True);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		if($client && $password && $email) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($client)) {
				$this->load->model('user_model', 'user');
				
				if($this->user->exist($email)) {
					$this->load->model('auth_model', 'auth');

					$user = $this->user->get($email);

					if($this->auth->hash($password, $user->salt) == $user->password) {
						$token = $this->auth->generateToken($email, $client);
						$this->_response_success(array('token'=>$token));
					} else {
						$this->_response_error(5);
					}
				} else {
					$this->_response_error(4);
				}
			} else {
				$this->_response_error(2);
			}
		} else {
			$this->_response_error(1);
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

	function _response_error($id) {
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
			default:
				$data['data'] = array('reason' => 'Error');
				break;
		}

		$data['status'] = false;
		$this->load->view('api/response', $data);
	}
}