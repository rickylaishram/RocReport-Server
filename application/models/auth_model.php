<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/*
	* Takes a password and salt and hashes
	* @params string, string
	* @return string hashed value
	*/
	function hash($password, $salt) {
		return hash('sha512',$password.$salt);
	}

	/*
	* Returns a random salt
	*/
	function generateSalt() {
		return md5(time().mt_rand());
	}

	/*
	* Generates token for user and client
	* And saves the it
	* @params string, string email, clientid
	* @return string the token
	*/
	function generateToken($email, $client) {
		$token = md5(time().mt_rand().$email);

		$data = array(
					'client' => $client,
					'token' => $token,
					'email' => $email
				);
		$this->db->insert($this->table['token'], $data);

		return $token;
	}

	/*
	* Gets the user email from tokens and client id
	* @params string, string $clientid, $token
	* @return string the user email; false if do not exist
	*/
	function getEmail($clientid, $token) {
		$query = $this->db->where('token', $token)->where('client', $clientid)->get($this->table['token']);
		if ($query->num_rows() > 0) {
			return $query->row()->email;
		} else {
			return false;
		}
	}
}