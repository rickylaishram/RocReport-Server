<?php

require(APPPATH.'core/RR_Mainlogin.php');

/**
 * Contractor API controller
 */
class RR_Maincontractor extends RR_Mainlogin {
	
	protected $contractor_data = null;

	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model', 'auth');

		if(!$this->auth->isContractor($this->user_data['email'])) {
			$this->_response_error(13);
		}

		$this->load->model('contractor_model', 'con');
		var_dump($this->user_data);
		$this->contractor_data = $this->con->getData($this->user_data['email']);
	}
}