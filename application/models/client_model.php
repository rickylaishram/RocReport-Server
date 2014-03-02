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
		$query = $this->db->where($clientid)
							->get($this->table->client);
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}