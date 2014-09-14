<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends RR_Maincontractor {
	
	function index() {
		$this->load->model('auth_model', 'auth');
		$this->load->model('job_model', 'job');
		
		$this->data['page_data']['page_title'] = 'Contractor - Jobs | RocReport';
		$this->data['page_data']['page_id'] = 8;

		$category = $this->input->get('cat', true);
		$latitude = $this->input->get('lat', true);
		$longitude = $this->input->get('lng', true);
		$radius = $this->input->get('rad', true);

		var_dump($category);
		var_dump($latitude);
		var_dump($longitude);
		var_dump($radius);

		//if($category && $latitude && $longitude && $radius)
			$this->data['data']['jobs'] = $this->job->searchNearbyType($category, $latitude, $longitude, $radius);



		$this->load->view('app/header', $this->data);
		$this->load->view('app/navbar', $this->data);
		$this->load->view('contractor/jobs.php', $this->data);
		$this->load->view('app/footer', $this->data);
	}
}