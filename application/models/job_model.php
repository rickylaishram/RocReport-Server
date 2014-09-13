<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/*
	* Select the nearby reports (diatances in km)
	* @params $latitude, $longitude, $distance, $limit
	* @return array of the nearby reports
	*/
	function search_nearby_type($type, $latitude, $longitude, $distance) {
		
		// Convert distance from km to meters
		$distance = 1000*$distance;

		// Query based on Havebrsine's formula (in meter)
		// Based on https://developers.google.com/maps/articles/phpsqlsearch_v3
		$sql = "SELECT longitude, latitude, report_id, description, added_at, formatted_address, picture, closed, category, ( 6371000 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM ".$this->table['report']." HAVING distance < ? AND closed = 0 AND category = ? ORDER BY added_at DESC";

		$query = $this->db->query($sql, array($latitude, $longitude, $latitude, $distance, $type));

		return $query->result();
	}

}