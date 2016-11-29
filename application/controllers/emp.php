<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('mdl_emp');
	}
	function get_name()
	{	
		$empid = $this->input->post('empid');
		if ($empid) {
			echo $this->mdl_emp->get_name($empid);			
		}else{
			echo "";
		}
	}	
}