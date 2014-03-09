<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function register() {
		$this->load-model('auth_model', 'auth');
		$email = $this->auth->isLoggedIn();

		if(!$email) {
			$name = $this->input->post('name', true);
			$email = $this->input->post('email', true);
			$pass = $this->input->post('pass', true);
			
			if($name && $email && $pass) {
				var_dump($_POST);
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