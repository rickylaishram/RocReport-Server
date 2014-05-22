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
		$data['page_id'] = 7;
		$data['is_logged_in'] = $this->auth->isLoggedIn();
		$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
		$data['is_super_admin'] = $this->auth->isSuperAdmin();
		$data['browser'] = $this->config->item('browser');

		if($this->input->post('email') && valid_email($this->input->post('email'))) {
			$from = $this->input->get('email');
			$message = $this->input->get('message');
			$emails = $this->config->item('email');

			foreach ($emails as $email) {
				$this->email->from('mailman@rocreport.org', 'RocReport Mailman');
				$this->email->to($email); 

				$this->email->subject('Contact Us - '.$from);
				$this->email->message($message);

				$this->email->send();
			}

			var_dump($from);
			var_dump($message);

			//header('Location: '.base_url());
		} else {
			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);	
			$this->load->view('main/contact.php', $data);
			$this->load->view('app/footer', $data);
		}
		
		
	}
}