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

		var_dump($this->auth->isContractor($this->user_data['email']));

		if(!$this->auth->isContractor($this->user_data['email'])) {
			$this->output->set_header('Location: '.base_url());
			$this->output->set_status_header('302');
			$this->output->_display();
		}

		var_dump('hsgdfjhs');

		$this->load->model('contractor_model', 'con');
		$this->contractor_data = $this->con->getData($this->user_data['email']);
	}
}