<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends RR_Maincontractor {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		
		$this->data['page_data']['page_title'] = 'Contractor - Jobs | RocReport';
		$this->data['page_data']['page_id'] = 8;

		$this->load->view('app/header', $this->data);
		$this->load->view('app/navbar', $this->data);
		$this->load->view('contract/job.php', $this->data);
		$this->load->view('app/footer', $this->data);
	}
}