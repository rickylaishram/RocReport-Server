<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function register() {
		$this->load->model('auth_model', 'auth');
		$email = $this->auth->isLoggedIn();

		if(!$email) {
			$name = $this->input->post('name', true);
			$email = $this->input->post('email', true);
			$pass = $this->input->post('pass', true);
			
			if($name && $email && $pass) {
				$this->load->model('user_model', 'user');

				if(!$this->user->exist($email)) {
					$browser = $this->config->item('browser');

					$this->load->model('auth_model', 'auth');

					// Add user
					$salt = $this->auth->generateSalt();
					$hashedpassword = $this->auth->hash($pass, $salt);
					$this->user->add($email, $hashedpassword, $salt, $name);

					// Login
					$token = $this->auth->generateToken($email, $browser['id']);

					$this->session->set_userdata($browser['cookie']['auth'], $token);
					header('Location: '.base_url());
				}
			} else {
				$data['page_title'] = 'Register | RocReport';

				$this->load->view('app/header', $data);
				$this->load->view('auth/register', $data);
				$this->load->view('app/footer', $data);
			}
		} else {
			// Redirect user to main page if logged in
			header('Location: '.base_url());
		}
	}

	function login() {
		$this->load->model('auth_model', 'auth');
		$email = $this->auth->isLoggedIn();

		if(!$email) {
			$email = $this->input->post('email', true);
			$pass = $this->input->post('pass', true);
			
			if($email && $pass) {
				$this->load->model('user_model', 'user');

				if(!$this->user->exist($email)) {
					$this->load->model('auth_model', 'auth');
					$user = $this->user->get($email);
					$browser = $this->config->item('browser');

					if($this->auth->hash($pass, $user->salt) == $user->password) {
						$token = $this->auth->generateToken($email, $browser['id']);

						$this->session->set_userdata($browser['cookie']['auth'], $token);
						header('Location: '.base_url());

					} else {
						$data['page_title'] = 'Register | RocReport';
						$data['error'] = true;

						$this->load->view('app/header', $data);
						$this->load->view('auth/login', $data);
						$this->load->view('app/footer', $data);
					}
				}
			} else {
				$data['page_title'] = 'Register | RocReport';
				$data['error'] = false;

				$this->load->view('app/header', $data);
				$this->load->view('auth/register', $data);
				$this->load->view('app/footer', $data);
			}
		} else {
			// Redirect user to main page if logged in
			header('Location: '.base_url());
		}
	}

}