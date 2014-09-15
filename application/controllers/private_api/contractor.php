<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends RR_Papilogin {

	protected $contractor_data = null;

	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model', 'auth');

		if(!$this->auth->isContractor($this->user_data->email)) {
			$this->_response_error(13);
		}

		$this->load->model('contractor_model', 'con');
		$this->contractor_data = $this->con->getData($this->user_data->email);
	}

	public function job($method = null) {
		switch ($method) {
			case 'fetch':
				$this->_get_jobs();
				break;
			case 'bid':
				$this->_bid_job();
				break;
			default:
				# code...
				break;
		}
	}

	public function bid($method = null) {
		switch ($method) {
			case 'fetch':
				$this->_big_fetch();
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

	/**
	 * Get nearby jobs of some category
	 */
	private function _get_jobs() {
		$type = $this->input->get('type', true);
		$lat = $this->input->get('lat', true);
		$lng = $this->input->get('lng', true);
		$dis = $this->input->get('dist', true); 	// Distance input in km

		if(!$type)
			$this->_response_error(1);

		// If any other parameter is not supplied, use default
		if(!$lat)
			$lat = $this->contractor_data->latitude;
		if(!$lng)
			$lng = $this->contractor_data->longitude;
		if(!$dis)
			$dis = $this->contractor_data->radius;

		$this->load->model('job_model', 'job');
		
		$jobs = $this->job->searchNearbyType($type, $lat, $lng, $dis);

		$this->_response_success($jobs);
	}

	/**
	 * Add a bid for a job
	 */
	private function _bid_job() {
		$job_id = $this->input->post('id', true);
		$amount = $this->input->post('amount', true);		// in USD
		$duration = $this->input->post('duration', true); 	// in days

		if(!$job_id || !$amount || !$duration)
			$this->_response_error(1);

		$this->load->model('job_model', 'job');
		$this->job->addBid($job_id, $amount, $duration, $this->user_data->email);

		$this->_response_success(array());
	}

	/**
	 * Fetch my bids
	 */
	private function _big_fetch() {
		$this->load->model('job_model', 'job');
		$email = $this->user_data->email;
		$bids = $this->job->getBids($email);

		$this->_response_success($bids);
	}
}