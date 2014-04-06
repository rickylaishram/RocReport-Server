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
			$data['page_id'] = 2;
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

	function api($method) {
		$this->load->model('auth_model', 'auth');
		$this->load->model('client_model', 'client');
		$id = $this->input->post('id');

		$valid = ($id ? $this->client->isValid($id) : false);
		$rate_limit = ($valid ? $this->client->check_rate_limit($id) : false);

		if($id && $valid && $rate_limit ) {
			if(!$this->auth->isLoggedIn()) {
				$this->output->set_header('Location: '.base_url());
				$this->output->set_status_header('302');
				$this->output->_display();
			} else {
				$email = $this->auth->isLoggedIn();

				switch ($method) {
					case 'fetch_nearby':
						$orderby = 'score';
						$latitude = $this->input->post('latitude', true);	// Required
						$longitude = $this->input->post('longitude', true);	// Required
						$radius = 1000;
						$limit = 100; 
						$offset = 0;

						$this->load->model('report_model', 'report');
						$data = $this->report->selectNearby($email, floatval($latitude), floatval($longitude), intval($radius), intval($offset), intval($limit), $orderby);
						$this->_response_success($data);
						break;
					case 'fetch_mine':
						$this->load->model('report_model', 'report');
						$orderby = "new";
						$data = $this->report->fetch_by_user($email, 100, 0, $orderby);
						$this->_response_success($data);
						break;
					case 'vote':
						$report = $this->input->post('report');
						if($report) {
							$this->load->model('report_model', 'report');
							$this->report->vote($email, $report);
							$this->_response_success(array());
						}
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