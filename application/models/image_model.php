<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	function add($email, $client, $filename) {
		$data = ('email' => $email, 'client' => $client, 'filename' => $filename, 'server'=> json_encode($_SERVER));
		$this->db->insert($this->table['image'], $data);
	}

}