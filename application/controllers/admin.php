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

	function api($method) {
		$this->load->model('auth_model', 'auth');
		$this->load->model('client_model', 'client');
		$id = $this->input->post('id');

		$valid = ($id ? $this->client->isValid($id) : false);
		$rate_limit = ($valid ? $this->client->check_rate_limit($id) : false);

		if($id && $valid && $rate_limit ) {
			if(!$this->auth->isLoggedIn() || !$this->auth->isAdmin(null, null, null, null)) {
				$this->output->set_header('Location: '.base_url());
				$this->output->set_status_header('302');
				$this->output->_display();
			} else {
				$this->load->model('admin_model', 'admin');
				$email = $this->auth->isLoggedIn();

				switch ($method) {
					case 'get_reports':
						$data = $this->admin->get_reports($email);
						$this->_response_success($data);
						break;
					case 'get_reports_closed':
						$data = $this->admin->get_reports_closed($email);
						$this->_response_success($data);
						break;
					default:
						# code...
						break;
				}
			}
		}
	}

	function _response_success($vars) {
		$data['status'] = true;
		$data['data'] = $vars;
		$this->load->view('api/response', $data);
	}

}