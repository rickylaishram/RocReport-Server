<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/*
	* Add a new user
	* @params string, string, string, string
	*/

	function add($email, $hashedpassword, $salt, $name) {

		$data = array(
				'email' => $email,
				'password' => $hashedpassword,
				'salt' => $salt,
				'verified' => 1,
				'name' => $name
				);
		$this->db->insert($this->table['user'], $data);
	}

	/*
	* Check if user exist
	* @params string email
	* @return boolean true if exist; false otherwise
	*/
	function exist($email) {
		$this->db->where('email', $email)->get($this->table['user']);

		if($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	/*
	* Get a user
	* @params string email
	* @return user object
	*/
	function get($email) {
		$query = $this->db->where('email', $email)->get($this->table['user']);

		if($query->num_rows > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
}