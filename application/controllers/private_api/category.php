<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends RR_Papilogin {

	/**
	 * Get all the available categories
	 */
	function fetch() {
		$this->load->model('category_model', 'category');

		$data = $this->category->fetchAll();

		$this->_response_success($data);
	}

}