<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contractor_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/**
	 * Fetch the contractor data
	 */
	function getData($email) {
		$this->db->where('email', $email);
		$query = $this->db->get($this->table['contractor']);

		return $query->row_array();
	}

}