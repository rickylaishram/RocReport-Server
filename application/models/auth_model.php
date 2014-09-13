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

	/*
	* ---------------------------------------------
	* Internal functions (Not to be used with APIs)
	* ---------------------------------------------
	*/

	/* 
	* Checks is user logged in
	* Return false if not; email if logged in
	*/
	function isLoggedIn() {
		$browser = $this->config->item('browser');
		$token = $this->session->userdata($browser['cookie']['auth']);

		if(!$token)
			return false;
		
		$email = $this->getEmail($browser['id'], $token);
		
		if(!$email)
			return false;
		
		return $email;
	}

	/*
	* Check if the user is an admin in the area
	*
	* Heirarchy:
	*	$country
	*	$admin_level_2
	*	$admin_level_1
	*	$locality
	*
	* User who is admin in higher level gains admin rights to lower level
	* 
	* Example:
	* To check if user is an admin in ANY locality under "admin_level_2", "admin_level_1", "country"
	* The function will be called as isAdmin(null, "admin_level_2", "admin_level_1", "country")
	* Likewise for higher levels.
	*/
	function isAdmin($locality, $admin_level_2, $admin_level_1, $country) {
		$email = $this->isLoggedIn();
		if(!$email)
			return false;

		$this->db->select('*');
		if(!is_null($locality)) {
			$this->db->where('locality', $locality);
		}
		if(!is_null($admin_level_2)) {
			$this->db->where('admin_level_2', $admin_level_2);
		}
		if(!is_null($admin_level_1)) {
			$this->db->where('admin_level_1', $admin_level_1);
		}
		if(!is_null($country)) {
			$this->db->where('country', $country);
		}
		$this->db->where('email', $email);
		$count = $this->db->count_all_results($this->table['admin']);

		return ($count == 1) ? true : false;
	}

	function isSuperAdmin() {
		$email = $this->isLoggedIn();
		if(!$email)
			return false;

		$this->db->where('email', $email);
		$count = $this->db->count_all_results($this->table['sadmin']);
		return ($count == 1) ? true : false;
	}

	/**
	 * Check if user is a contractor
	 *
	 * @param string $email The user email
	 * @return boolean True if contractor; false otherwise
	 */
	function isContractor($email) {
		$this->db->where('email', $email);
		$query = $this->db->count_all_results($this->table['contractor']);

		return ($count == 1) ? true : false;
	}
}