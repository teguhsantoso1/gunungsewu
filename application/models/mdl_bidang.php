<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_bidang extends CI_Model {
	var $tbl_name = 'bidang';
	function __construct(){
		parent::__construct();
	}
	function dropdown(){
		$data[''] = '';
		$result = $this->db->get($this->tbl_name)->result();
		foreach($result as $r){
			$data[$r->id] = $r->name;
		}	
		return $data;
	}
}
