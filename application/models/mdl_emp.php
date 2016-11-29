<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_emp extends CI_Model {

	var $tbl_name = 'emp';

	function get_name($empid)
	{
		$this->db->where('empid',$empid);
		$this->db->limit(1);
		$query = $this->db->get($this->tbl_name);
		if($query->num_rows()>0){
			$data = $query->row()->empname;
		}else{
			$data = '';
		}
		return $data;
	}
}
