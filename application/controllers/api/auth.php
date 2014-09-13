<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends RR_Api {
	/**
	 * Login a user using email and password
	 */
	public function login() {
		$client = $this->auth_data['client_id'];

		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		var_dump($this->auth_data);
		var_dump($email);
		var_dump($password);

		// Make sure we have all parameters
		if(!$client || !$password || !$email)
			$this->_response_error(1);

		$this->load->model('user_model', 'user');
		
		$user = $this->user->get($email);

		// Make sure user exist
		if(!$user)
			$this->_response_error(4);

		$this->load->model('auth_model', 'auth');

		// Check if password matches
		// If yes create new token and return
		if($this->auth->hash($password, $user->salt) == $user->password) {
			$token = $this->auth->generateToken($email, $client);
			$this->_response_success(array('token'=>$token));
		} else {
			$this->_response_error(5);
		}
	}

	/**
	 * Registers a new user
	 */
	public function register() {
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);
		$name = $this->input->post('name', true);

		if(!$password || !$email || !$name)
			$this->_response_error(1);

		$this->load->model('user_model', 'user');

		// Make sure user do not already exist
		if($this->user->exist($email))
			$this->_response_error(3);

		$this->load->model('auth_model', 'auth');

		$salt = $this->auth->generateSalt();
		$hashedpassword = $this->auth->hash($password, $salt);
		$this->user->add($email, $hashedpassword, $salt, $name);

		$this->_response_success(array());
	}
}