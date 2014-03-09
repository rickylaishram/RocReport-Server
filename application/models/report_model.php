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
	function fetch_by_user($email, $limit, $offset) {
		$this->db->where('email', $email);
		$this->db->order_by('score', 'DESC');
		$query = $this->db->get($this->table['report'], $limit, $offset);
		$result = array();

		foreach ($query->result_array() as $report) {
			$report['vote_count'] = $this->get_num_votes($report['report_id']);
			$report['inform_count'] = $this->get_num_inform($report['report_id']);
			$report['update'] = $this->last_update($report['report_id']);
			$report['hasVotes'] = $this->hasVoted($report['report_id'], $email);
			$report['inInform'] = $this->inInform($report['report_id'], $email);

			$result[] = $report;
		}

		return $result;
	}

	/*
	* Fetch all reports by sublocality
	* always ordered by rank
	*/
	function fetch_by_sublocality($email, $name, $offset, $limit) {
		$this->db->where('sublocality', $name);
		$this->db->order_by('score', 'DESC');
		$query = $this->db->get($this->table['report'], $limit, $offset);

		$result = array();

		foreach ($query->result_array() as $report) {
			$report['vote_count'] = $this->get_num_votes($report['report_id']);
			$report['inform_count'] = $this->get_num_inform($report['report_id']);
			$report['update'] = $this->last_update($report['report_id']);
			$report['hasVotes'] = $this->hasVoted($report['report_id'], $email);
			$report['inInform'] = $this->inInform($report['report_id'], $email);

			$result[] = $report;
		}

		return $result;
	}

	/*
	* Fetch all reports by sublocality
	* always ordered by rank
	*/
	function fetch_by_area_level_1($email, $name, $offset, $limit) {
		$this->db->where('admin_area_level_1', $name);
		$this->db->order_by('score', 'DESC');
		$query = $this->db->get($this->table['report'], $limit, $offset);

		$result = array();

		foreach ($query->result_array() as $report) {
			$report['vote_count'] = $this->get_num_votes($report['report_id']);
			$report['inform_count'] = $this->get_num_inform($report['report_id']);
			$report['update'] = $this->last_update($report['report_id']);
			$report['hasVotes'] = $this->hasVoted($report['report_id'], $email);
			$report['inInform'] = $this->inInform($report['report_id'], $email);

			$result[] = $report;
		}

		return $result;
	}

	/*
	* Fetch all reports by sublocality
	* always ordered by rank
	*/
	function fetch_by_area_level_2($email, $name, $offset, $limit) {
		$this->db->where('admin_area_level_2', $name);
		$this->db->order_by('score', 'DESC');
		$query = $this->db->get($this->table['report'], $limit, $offset);

		$result = array();

		foreach ($query->result_array() as $report) {
			$report['vote_count'] = $this->get_num_votes($report['report_id']);
			$report['inform_count'] = $this->get_num_inform($report['report_id']);
			$report['update'] = $this->last_update($report['report_id']);
			$report['hasVotes'] = $this->hasVoted($report['report_id'], $email);
			$report['inInform'] = $this->inInform($report['report_id'], $email);

			$result[] = $report;
		}

		return $result;
	}

	/*
	* Fetch all reports by country
	* always ordered by rank
	*/
	function fetch_by_country($email, $name, $offset, $limit) {
		$this->db->where('country', $name);
		$this->db->order_by('score', 'DESC');
		$query = $this->db->get($this->table['report'], $limit, $offset);

		$result = array();

		foreach ($query->result_array() as $report) {
			$report['vote_count'] = $this->get_num_votes($report['report_id']);
			$report['inform_count'] = $this->get_num_inform($report['report_id']);
			$report['update'] = $this->last_update($report['report_id']);
			$report['hasVotes'] = $this->hasVoted($report['report_id'], $email);
			$report['inInform'] = $this->inInform($report['report_id'], $email);

			$result[] = $report;
		}

		return $result;
	}

	/*
	* Returns the number of votes for a report
	*/
	function get_num_votes($report_id) {
		$this->db->where('report_id', $report_id);
		$num = $this->db->count_all_results($this->table['vote']);
		return $num;
	}

	/*
	* Return the number of informs for a report
	*/
	function get_num_inform($report_id) {
		$this->db->where('report_id', $report_id);
		$num = $this->db->count_all_results($this->table['inform']);
		return $num;
	}

	/*
	* Return the latest update for the report
	*/
	function last_update($report_id) {
		$this->db->where('report_id', $report_id);
		$this->db->order_by('updated_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get($this->table['update']);

		return $query->row();
	}

	/*
	* Return true if user has voted
	*/
	function hasVoted($report_id, $email) {
		$this->db->where('report_id', $report_id);
		$this->db->where('email', $email);
		$num = $this->db->count_all_results($this->table['vote']);

		return ($num > 0);
	}

	/*
	* Return true if user is in inform
	*/
	function inInform($report_id, $email) {
		$this->db->where('report_id', $report_id);
		$this->db->where('email', $email);
		$num = $this->db->count_all_results($this->table['inform']);

		return ($num > 0);
	}
}