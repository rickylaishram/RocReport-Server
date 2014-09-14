<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends RR_Maincontractor {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		
		$this->data['page_data']['page_title'] = 'Contractor | RocReport';
		$this->data['page_data']['page_id'] = 8;

		$this->load->view('app/header', $this->data);
		$this->load->view('app/navbar', $this->data);
		$this->load->view('contractor/content.php', $this->data);
		$this->load->view('app/footer', $this->data);
	}
}