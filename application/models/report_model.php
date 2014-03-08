<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}


	/*
	* Select the nearby reports (diatances in km)
	* @params $latitude, $longitude, $distance, $limit
	* @return array of the nearby reports
	*/

	function selectNearby($latitude, $longitude, $distance, $limit) {
		// Query based on Havebrsine's formula (in meter)
		// Based on https://developers.google.com/maps/articles/phpsqlsearch_v3
		$sql = "SELECT *, ( 6371000 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM ".$this->table['report']." HAVING distance < ? ORDER BY distance LIMIT 0 , ?";

		$query = $this->db->query($sql, array($latitude, $longitude, $latitude, $distance, $limit));

		return $query->result();
	}

	/*
	* Add a new report
	* @params 
	* @return report_id
	*/
	function add($email, $latitude, $longitude, $formatted_address, $country, $admin_level_1, $admin_level_2, $sublocality, $category, $description, $picture) {
		$data = array(
				'formatted_address' => $formatted_address,
				'country' => $country,
				'admin_area_level_1' => $admin_level_1,
				'admin_area_level_2' => $admin_level_2,
				'sublocality' => $sublocality,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'category' => $category,
				'description' => $description,
				'email' => $email,
				'picture' => $picture,
			);
		$this->db->insert($this->table['report'], $data);
	}

	/*
	* Fetch reports by user
	*/
	function fetch_by_user($email) {
		$this->db->where($this->table['report'].'.email', $email);
		$this->db->from($this->table['report']);
		$this->db->join($this->table['update'], $this->table['update'].'.report_id = '.$this->table['report'].'.report_id', 'left');
		$this->db->join($this->table['vote'], $this->table['vote'].'.report_id = '.$this->table['report'].'.report_id', 'left');

		$query = $this->db->get();

		// Return as pure array because result might need to be json encoded
		return $query->result_array();
	}
}