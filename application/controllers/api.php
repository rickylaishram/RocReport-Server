<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/*
	* Handles register and login
	*/
	function auth($path="") {
		switch ($path) {
			case 'register':
				$this->_register();
				break;
			case 'login':
				$this->_login();
				break;
			default:
				$this->_response_error(6);
				break;
		}
	}

	/*
	* Handles report add, fetch, etc
	*/
	function report($path="") {
		switch ($path) {
			case 'add':
				$this->_add_report();
				break;
			case 'fetch_mine':
				$this->_reported_by_me();
				break;
			case 'fetch':
				$this->_reported_by_area();
				break;
			default:
				$this->_response_error(6);
				break;
		}
	}

	/*
	* Handles image related stuff
	*/
	function image($path="") {
		switch ($path) {
			case 'add':
				$this->_image_add();
				break;
			
			default:
				# code...
				break;
		}
	}

	/*
	* Strore uploaded image
	* Requires authentication
	*/
	function _image_add(){
		$client = $this->input->post('id', true);			// Required
		$token = $this->input->post('token', true);			// Required

		$this->load->model('auth_model', 'auth');
		$email = $this->auth->getEmail($client, $token);

		if($email) {
			$config['encrypt_name'] = true
			$config['upload_path'] = FCPATH.'static/images/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	= '500';
			$config['max_width']  = '1600';
			$config['max_height']  = '1600';

			$this->load->library('upload', $config);

			$fieldname = 'image';
			if ( ! $this->upload->do_upload($fieldname)){
				//$error = array('error' => $this->upload->display_errors());
				$this->_response_error(10);
			} else {
				$data = array('upload_data' => $this->upload->data());
				$this->_response_success($data);
			}
		} else {
			$this->_response_error(7);
		}
	}

	/*
	* Fetch reports reported by me
	* Requires authentication
	*/
	function _reported_by_me() {
		$client = $this->input->post('id', true);			// Required
		$token = $this->input->post('token', true);			// Required
		$orderby = $this->input->post('orderby', true);

		/* If order by is not set or invalid, default to score */
		if(!$orderby || (($orderby != 'score') && ($orderby != 'new'))) {
			$orderby = 'score';
		}

		$this->load->model('auth_model', 'auth');
		$email = $this->auth->getEmail($client, $token);

		if($email) {
			$this->load->model('report_model', 'report');
			$data = $this->report->fetch_by_user($email, 100, 0, $orderby);
			$this->_response_success($data);
		} else {
			$this->_response_error(7);
		}
	}

	/*
	* Fetch reports by area
	* Does not require authentication
	*/
	function _reported_by_area() {
		$client = $this->input->post('id', true);
		$token = $this->input->post('token', true);
		$areatype = $this->input->post('type', true);	// Required
		$areaname = $this->input->post('name', true);	// Required
		$orderby = $this->input->post('orderby', true);
		$offset = $this->input->post('offest', true);
		$limit = $this->input->post('limit', true);

		/* If order by is not set or invalid, default to score */
		if(!$orderby || (($orderby != 'score') && ($orderby != 'new'))) {
			$orderby = 'score';
		}

		// If offset if not set, set to 0
		if(!$offset || !is_numeric($offset)) {
			$offest = 0;
		}

		// If linit is not set or valid, set to 10
		if(!$limit || !is_numeric($limit)) {
			$limit = 10;
		}

		// If $limit is greather than 100, set to 100
		if($limit > 100) {
			$limit = 100;
		}

		$this->load->model('auth_model', 'auth');
		$email = $this->auth->getEmail($client, $token);
		$areatypes = $this->config->item('area_type');

		if(in_array($areatype, $areatypes)) {
			$this->load->model('report_model', 'report');

			$data = $this->report->fetch_by_area($email, $areatype, $areaname, $offset, $limit, $orderby);

			$this->_response_success($data);
		} else {
			$this->_response_error(9);
		}
		
	}

	/*
	* Add a new update
	* If novote is false, check if there are reports within 100 meters,
	* 	if yes, returns the list to confirm that it is not duplicate
	* If novote is not false, this check is not performed.
	* 	use this after user has confirmed that it is not a duplicate 
	* Requires authentication
	*/
	function _add_report() {
		$client = $this->input->post('id', true);			// Required
		$token = $this->input->post('token', true);			// Required
		$formatted_address = $this->input->post('formatted_address', true);
		$country = $this->input->post('country', true);
		$admin_level_1 = $this->input->post('admin_level_1', true);
		$admin_level_2 = $this->input->post('admin_level_2', true);
		$sublocality = $this->input->post('sublocality', true);
		$latitude = $this->input->post('latitude', true);	// Required
		$longitude = $this->input->post('longitude', true);	// Required
		$category = $this->input->post('category', true);	// Required
		$description = $this->input->post('description', true); // Required
		$picture = $this->input->post('picture', true);		// Required
		$novote = $this->input->post('novote', true);		// Required boolean; if true will not prompt for merge with nearby reports

		if ($client && $token && $latitude && $longitude && $category && $description && $picture & $novote) {
			$this->load->model('client_model', 'client');
			$this->load->model('auth_model', 'auth');
			$this->load->model('report_model', 'report');

			// Change $novote to boolean
			$novote = ($novote === 'true');

			$email = $this->auth->getEmail($client, $token);
			if($email) {
				if(in_array($category, $categories)) {
					$nearby = array();

					// If novote is set to false; check if nearby reports exist
					if(!$novote) {
						$nearby = $this->report->selectNearby(floatval($latitude), floatval($longitude), 100, 5);
					}

					// If nearby reports are found return them
					if(count($nearby) == 0) {
						$this->report->add($email, floatval($latitude), floatval($longitude), $formatted_address, $country, $admin_level_1, $admin_level_2, $sublocality, $category, $description, $picture) ;
					}

					$data = array('nearby' => count($nearby), 'details' => $nearby);
					$this->_response_success($data);
				} else {
					$this->_response_error(8);
				}
			} else {
				$this->_response_error(7);
			}
		} else {
			$this->_response_error(1);
		}

	}

	/*
	* Register new user
	* Private API
	*/

	function _register() {
		$client = $this->input->post('id', true);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);
		$name = $this->input->post('name', true);

		if($client && $password && $email & $name) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($client)) {
				$this->load->model('user_model', 'user');

				if(!$this->user->exist($email)) {
					$this->load->model('auth_model', 'auth');

					$salt = $this->auth->generateSalt();
					$hashedpassword = $this->auth->hash($password, $salt);
					$this->user->add($email, $hashedpassword, $salt, $name);

					$this->_response_success(array());
				} else {
					$this->_response_error(3);
				}
			} else {
				$this->_response_error(2);
			}
		} else {
			$this->_response_error(1);
		}
	}

	/*
	* Login
	* Private API
	*/
	function _login() {
		$client = $this->input->post('id', true);
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		if($client && $password && $email) {
			$this->load->model('client_model', 'client');
			
			if($this->client->isValid($client)) {
				$this->load->model('user_model', 'user');
				
				if($this->user->exist($email)) {
					$this->load->model('auth_model', 'auth');

					$user = $this->user->get($email);

					if($this->auth->hash($password, $user->salt) == $user->password) {
						$token = $this->auth->generateToken($email, $client);
						$this->_response_success(array('token'=>$token));
					} else {
						$this->_response_error(5);
					}
				} else {
					$this->_response_error(4);
				}
			} else {
				$this->_response_error(2);
			}
		} else {
			$this->_response_error(1);
		}
	}

	/*
	* Sends success resonse
	* @params array data to be sent to client
	*/
	function _response_success($vars) {
		$data['status'] = true;
		$data['data'] = $vars;
		$this->load->view('api/response', $data);
	}

	/*
	* Error responses
	*/

	function _response_error($id) {
		switch ($id) {
			case 1:		// Missing parameters
				$data['data'] = array('reason' => 'Missing parameters');
				break;
			case 2:
				$data['data'] = array('reason' => 'Invalid id');
				break;
			case 3:
				$data['data'] = array('reason' => 'User exist');
				break;
			case 4:
				$data['data'] = array('reason' => 'User do not exist');
				break;
			case 5:
				$data['data'] = array('reason' => 'Password and email do not match');
				break;
			case 6:
				$data['data'] = array('reason' => 'Invalid path');
				break;
			case 7:
				$data['data'] = array('reason' => 'Invalid token');
				break;
			case 8:
				$data['data'] = array('reason' => 'Invalid category');
				break;
			case 9:
				$data['data'] = array('reason' => 'Invalid area type');
				break;
			case 10:
				$data['data'] = array('reason' => 'Image upload failed. Check file size.');
				break;
			default:
				$data['data'] = array('reason' => 'Error');
				break;
		}

		$data['status'] = false;
		$this->load->view('api/response', $data);
	}
}
