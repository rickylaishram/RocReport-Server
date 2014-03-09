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
					$cookie = array(
								'name'   => $browser['cookie']['auth'],
								'value'  => $token,
								'expire' => '86500',
								'secure' => TRUE
							);

					$this->input->set_cookie($cookie);

					header('Location: '.base_url());
				}
			} else {
				$data['page_name'] = 'Register | RocReport';

				$this->load->view('app/header', $data);
				$this->load->view('auth/register', $data);
				$this->load->view('app/footer', $data);
			}
		} else {
			var_dump($email);
		}
		
	}

}