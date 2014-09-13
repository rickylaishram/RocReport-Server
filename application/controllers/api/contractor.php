<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends RR_Api_Contractor {

	public function jobs($method = null) {
		switch ($methods) {
			case 'fetch':
				$types = $this->input->get()
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

	private function getJobs() {
		$this->load->model('job_model', 'job');
		$this->load->model('contractor_model', 'con');
	}
}