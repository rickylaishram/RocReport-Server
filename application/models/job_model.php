<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends CI_Model {

	function __construct() {
		$this->table = $this->config->item('table');
	}

	/**
	 * Select the nearby reports (diatances in km) by type
	 *
	 * @param $type String The job category
	 * @param $latitude Double The latitude
	 * @param $longitude Double The longitude
	 * @param $distance Integer The radius
	 * @return Array The nearby jobs
	 */
	function searchNearbyType($type, $latitude, $longitude, $distance) {
		// Convert distance from km to meters
		$distance = 1000*$distance;

		// Query based on Havebrsine's formula (in meter)
		// Based on https://developers.google.com/maps/articles/phpsqlsearch_v3
		$sql = "SELECT longitude, latitude, report_id, description, added_at, formatted_address, picture, closed, category, ( 6371000 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM ".$this->table['report']." HAVING distance < ? AND closed = 0 AND category = ? ORDER BY added_at DESC";

		$query = $this->db->query($sql, array($latitude, $longitude, $latitude, $distance, $type));

		return $query->result_array();
	}

	/**
	 * Add a bid for a job
	 * @param $id String The job id
	 * @param $amount Integer The amount bidding for (in USD)
	 * @param $duration Integer The estimated duration to complete job (in days)
	 * @param $email String The email of the bidding user
	 */
	function addBid($id, $amount, $duration, $email) {
		$data = array(
				'report_id' => $id,
				'email' => $email,
				'amount' => $amount,
				'duration' => $duration,
			);
		$this->db->insert($this->table['bid'], $data);
	}

	function getBids($email) {
		$this->db->select('*');
		$this->db->from($this->table['bid']);
		$this->db->where($this->table['bid'].'.email', $email);
		$this->db->join($this->table['report'], $this->table['report'].'.report_id = '.$this->table['bid'].'.report_id');
		$query = $this->db->get();

		return $query->row();
	}

}