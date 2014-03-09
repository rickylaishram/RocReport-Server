<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function register() {
		$this->load-model('auth_model', 'auth');
		$email = $this->auth->isLoggedIn();

		if($email) {
			if(!isset($_POST)) {
				$data['page_name'] = 'Register | RocReport'

				$this->load->view('app/header', $data);
				$this->load->view('auth/register', $data);
				$this->load->view('app/footer', $data);
			} else {

			}
		} else {
			header('Location: '.base_url());
		}
		
	}

}