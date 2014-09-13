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

		if(!$this->auth->isContractor($this->data['user_data']['email'])) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
			exit();
		}

		$this->load->model('contractor_model', 'con');
		$this->contractor_data = $this->con->getData($this->data['user_data']['email']);

		$this->data['is_contractor'] = true;
	}
}