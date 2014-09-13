<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor extends RR_Apicontractor {

	public function jobs($method = null) {
		switch ($methods) {
			case 'fetch':
				$this->getJobs();
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
		var_dump('Hello');
	}
}