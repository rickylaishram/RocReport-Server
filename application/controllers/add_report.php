<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_report extends CI_Controller {

	function index() {
		$this->load->model('auth_model', 'auth');
		if(!$this->auth->isLoggedIn()) {
			$this->output->set_header('Location: '.base_url()."auth/login?next=add_report");
			$this->output->set_status_header('302');
			$this->output->_display();
		} else {
			$this->load->model('admin_model', 'admin');

			$data['page_title'] = 'Add a report | RocReport';
			$data['page_id'] = 6;
			$data['is_logged_in'] = $this->auth->isLoggedIn();
			$data['is_admin'] = $this->auth->isAdmin(null, null, null, null);
			$data['is_super_admin'] = $this->auth->isSuperAdmin();
			$data['browser'] = $this->config->item('browser');
			$data['all_reports'] = $this->admin->get_reports($data['is_logged_in']);

			$this->load->view('app/header', $data);
			$this->load->view('app/navbar', $data);
			//$this->load->view('admin/nav.php', $data);
			$this->load->view('add/content.php', $data);
			$this->load->view('app/footer', $data);
		}
	}

	function api($method) {

		$this->load->model('auth_model', 'auth');
		$this->load->model('client_model', 'client');
		$id = $this->input->post('id');
		if (!$id) $id = $this->input->get('id');

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
					case 'add':
						$client = $this->input->post('id', true);			// Required
						$formatted_address = $this->input->post('formatted_address', true);
						$country = $this->input->post('country', true);
						$admin_level_1 = $this->input->post('admin_level_1', true);
						$admin_level_2 = $this->input->post('admin_level_2', true);
						$locality = $this->input->post('locality', true);
						$latitude = $this->input->post('latitude', true);	// Required
						$longitude = $this->input->post('longitude', true);	// Required
						$category = $this->input->post('category', true);	// Required
						$description = $this->input->post('description', true); // Required
						$picture = $this->input->post('picture', true);		// Required
						$novote = $this->input->post('novote', true);		// Required boolean; if true will not prompt for merge with nearby reports

						if ($client && $latitude && $longitude && $category && $description && $picture & $novote) {
							$this->load->model('client_model', 'client');
							$this->load->model('auth_model', 'auth');
							$this->load->model('report_model', 'report');
							$this->load->model('category_model', 'category');

							// Change $novote to boolean
							$novote = (strtolower($novote) === 'true');
							if($email) {

								//$categories = $this->config->item('category');
								//$category = strtolower($category);
								$category = $this->category->checkIdValid($category);

								if($category) {
									$nearby = array();

									// If novote is set to false; check if nearby reports exist
									if(!$novote) {
										$nearby = $this->report->selectNearby($email, floatval($latitude), floatval($longitude), 100, 0, 5, "new");
									}

									// If nearby reports are found return them
									if(count($nearby) == 0) {
										$this->report->add($email, floatval($latitude), floatval($longitude), $formatted_address, $country, $admin_level_1, $admin_level_2, $locality, $category, $description, $picture) ;
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
						break;
					case 'image':
						$client = $this->input->get('id', true);			// Required
						if($email && $client) {

							@require(FCPATH.'application/libraries/Uploader.php');

							$upload_dir = FCPATH.'static/images/';
							$valid_extensions = array('gif', 'png', 'jpeg', 'jpg');

							$Upload = new FileUpload('image');
							$ext = $Upload->getExtension(); // Get the extension of the uploaded file
							$Upload->newFileName = md5($email).time().'.'.$ext;
							$result = $Upload->handleUpload($upload_dir, $valid_extensions);

							if (!$result) {
							    echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));   
							} else {
								$this->load->model('image_model', 'image');
								//echo $email;
								//echo $client;
								//echo $Upload->getFileName();
								$this->image->add($email, $client, $Upload->getFileName());
							    echo json_encode(array('success' => true, 'file' => base_url().'static/images/'.$Upload->getFileName()));
							}
							
						} else {
							$this->_response_error(7);
						}						
						break;
					case 'imageprogress':
						if (isset($_REQUEST['progresskey'])) 
						  $status = apc_fetch('upload_'.$_REQUEST['progresskey']);
						else 
						  exit(json_encode(array('success' => false)));

						$pct = 0;
						$size = 0;

						if (is_array($status)) {
						  if (array_key_exists('total', $status) && array_key_exists('current', $status)) {
						    if ($status['total'] > 0) {
						      $pct = round( ( $status['current'] / $status['total']) * 100 );
						      $size = round($status['total'] / 1024);
						    }
						  }
						}

						echo json_encode(array('success' => true, 'pct' => $pct, 'size' => $size));
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
			case 11:
				$data['data'] = array('reason' => 'Invalid Client');
				break;
			case 12:
				$data['data'] = array('reason' => 'Rate limit exceeded');
				break;
			default:
				$data['data'] = array('reason' => 'Error');
				break;
		}

		$data['status'] = false;
		$this->load->view('api/response', $data);
	}	

}
