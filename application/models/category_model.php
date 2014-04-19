<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/*
	* Check if a specified category id is valid
	* 	returns the category name
	* 	false otherwise
	*/
	function checkIdValid($id) {
		$this->db->where('cat_id', (int)$id);
		$query = $this->db->get($this->table['category']);

		if($query->num_rows() > 0) {
			return $query->row()->cat_name;
		} else {
			return false;
		}
	}

}