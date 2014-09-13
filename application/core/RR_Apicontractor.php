<?php

require(APPPATH.'core/RR_Apilogin.php');

/**
 * Contractor API controller
 */
class RR_Apicontractor extends RR_Apilogin {
	
	protected $contractor_data = null;

	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model', 'auth');

		if(!$this->auth->isContractor($this->user_data['email'])) {
			$this->_response_error(13);
		}

		$this->load->model('contractor_model', 'con');
		$this->contractor_data = $this->con->getData($this->user_data['email']);
	}
}