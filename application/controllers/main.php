<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	function index(){
		$this->load->model('auth_model', 'auth');
		
		$data['page_title'] = 'RocReport';
		$data['page_id'] = 0;
		$data['is_logged_in'] = $this->auth->isLoggedIn();
		$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
		$data['is_super_admin'] = $this->auth->isSuperAdmin();
		$data['browser'] = $this->config->item('browser');

		$this->load->view('app/header', $data);
		$this->load->view('app/navbar', $data);
		$this->load->view('main/content.php', $data);
		$this->load->view('app/footer', $data);
	}

	function contact() {
		$this->load->model('auth_model', 'auth');
		$this->load->helper('email');
		
		$data['page_title'] = 'Contact Us | RocReport';
		$data['page_id'] = 6;
		$data['is_logged_in'] = $this->auth->isLoggedIn();
		$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
		$data['is_super_admin'] = $this->auth->isSuperAdmin();
		$data['browser'] = $this->config->item('browser');

		if(!$this->input->get('email') && valid_email($this->input->get('email'))) {
			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);	
			$this->load->view('main/contact.php', $data);
			$this->load->view('app/footer', $data);
		} else {
			$from = $this->input->get('email');
			$text = $this->input->get('text');
			$emails = $this->config->item('email');

			foreach ($emails as $email) {
				send_email($email, 'Rocreport Email from '.$from, $message.' from '.$from);
			}
			header('Location: '.base_url());
		}
		
		
	}
}