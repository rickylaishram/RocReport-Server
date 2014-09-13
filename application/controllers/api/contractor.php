<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends RR_Apicontractor {

	public function job($method = null) {
		switch ($method) {
			case 'fetch':
				$this->_get_jobs();
				break;
			
			default:
				# code...
				break;
		}
	}

	/*
	 |--------------------------------------------------------------------------
	 | Api Methods
	 |--------------------------------------------------------------------------
	 */

	private function _get_jobs() {
		$type = $this->input->get('type', true);
		$lat = $this->input->get('lat', true);
		$lng = $this->input->get('lng', true);
		$dis = $this->input->get('dist', true);

		if(!$type)
			$this->_response_error(1);

		// If any other parameter is not supplied, use default
		if(!$lat)
			$lat = $this->contractor_data['latitude'];
		if(!$lng)
			$lng = $this->contractor_data['longitude'];
		if(!$dis)
			$dis = $this->contractor_data['radius'];

		$this->load->model('job_model', 'job');
		
		$jobs = $this->job->search_nearby_type($type, $lat, $lng, $dis);

		$this->_response_success();
	}
}