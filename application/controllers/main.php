<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	function index(){
		$this->load->model('auth_model', 'auth');
		
		$data['page_title'] = 'RocReport';
		$data['loggedin'] = $this->auth->isLoggedIn();

		$this->load->view('app/header', $data);
		$this->load->view('app/navbar', $data);
		$this->load->view('main/content.php', $data);
		$this->load->view('app/footer', $data);
	}
}