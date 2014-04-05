<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function index() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isLoggedIn() || !$this->auth->isAdmin(null, null, null, null)) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		} else {
			$this->load->model('admin_model', 'admin');

			$data['page_title'] = 'Admin | RocReport';
			$data['page_id'] = 3;
			$data['is_logged_in'] = $this->auth->isLoggedIn();
			$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
			$data['is_super_admin'] = $this->auth->isSuperAdmin();
			$data['browser'] = $this->config->item('browser');
			$data['all_reports'] = $this->admin->get_reports($data['is_logged_in']);

			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);
			$this->load->view('admin/nav.php', $data);
			$this->load->view('admin/content.php', $data);
			$this->load->view('app/footer', $data);
		}
	}

}