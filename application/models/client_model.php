<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/*
	* Check if valid client id
	* @params string $clientid
	* @return boolean true if valid; false otherwise
	*/
	function isValid($clientid) {
		$query = $this->db->where('id',$clientid)->get($this->table['client']);
		
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function log_request($clientid, $method, $ip) {
		$data = array(
				'client_id' => $clientid,
				'time' => time(),
				'method' => $method,
				'ip' => $ip
			);
		$this->db->insert($this->table['api_request'], $data);
	}

	function check_rate_limit($clientid) {
		// Get the rate limit allowed for the client
		$this->db->where('id', $clientid);
		$query = $this->db->get($this->table['client']);

		$rate = $query->row()->rate_limit;

		// Null means unlimited
		if(is_null($rate)) {
			return true;
		} else {
			$this->db->where('client_id', $clientid);
			$this->db->where('time > ', (time() - 3600)); // API requests from the last 60 min
			$query = $this->db->get($this->table['api_request']);

			if($query->num_rows() < $rate) {
				return true;
			} else {
				return false;
			}
		}
	}
}