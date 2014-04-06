<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	function index() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isLoggedIn()) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		} else {
			$data['page_title'] = 'Reports | RocReport';
			$data['page_id'] = 3;
			$data['is_logged_in'] = $this->auth->isLoggedIn();
			$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
			$data['is_super_admin'] = $this->auth->isSuperAdmin();
			$data['browser'] = $this->config->item('browser');

			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);
			$this->load->view('user/nav.php', $data);
			$this->load->view('user/content.php', $data);
			$this->load->view('app/footer', $data);
		}
	}
}