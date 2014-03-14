<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	function index(){
		$this->load->model('auth_model', 'auth');
		
		$data['page_title'] = 'RocReport';
		$data['is_logged_in'] = $this->auth->isLoggedIn();
		$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
		$data['is_super_admin'] = $this->isSuperAdmin();

		$this->load->view('app/header', $data);
		$this->load->view('app/navbar', $data);
		$this->load->view('main/content.php', $data);
		$this->load->view('app/footer', $data);
	}
}