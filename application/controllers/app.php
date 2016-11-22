<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('mdl_app');
		$this->load->model('mdl_bidang');
	}
	function index(){
		$offset = $this->lib_general->value_get('offset',0);
		$limit = $this->lib_general->value_get('limit',10);

		$data['title'] = APP_NAME.' - List';
		$data['action'] = site_url('app/search'.$this->_filter());
		$data['export'] = ($this->session->userdata('user_level')<>'3'?anchor('app/export'.$this->_filter(),'Export',array('class'=>'btn btn-primary btn-sm')):"");
		$this->table->set_template(tbl_tmp());
		
		$head_data = array(
			'code'=>'Code'
			,'quesioner'=>'Quesioner'
			,'bidang_1_name'=>'Bidang 1'
			,'bidang_1_ket'=>'Bidang 1 Ket'
			,'bidang_2_name'=>'Bidang 2'
			,'bidang_2_ket'=>'Bidang 2 Ket'
			,'fullname'=>'User Entry'
			,'audit'=>'Audit'
		);
		$heading[] = 'No';
		foreach($head_data as $r => $value){
			$heading[] = anchor('app'.$this->_filter(array('order_column'=>$r,'order_type'=>$this->lib_general->order_type($r))),$value." ".$this->lib_general->order_icon($r));
		}		
		$heading[] = 'Action';
		$this->table->set_heading($heading);
		$result = $this->mdl_app->get()->result();
		$i=1+$offset;
		foreach($result as $r){
			$this->table->add_row(
				$i++
				,$r->code
				,str_replace(',', ' ', $r->quesioner)
				,$r->bidang_1_name	
				,$r->bidang_1_ket
				,$r->bidang_2_name	
				,$r->bidang_2_ket
				,$r->fullname
				,$r->audit
				,anchor('app/edit/'.$r->id.$this->_filter(),'<span class="glyphicon glyphicon-edit"></span> Edit')
			);
		}
		$data['table'] = $this->table->generate();
		$total = $this->mdl_app->count_all();
		
		$config = pag_tmp();
		$config['base_url'] = site_url("app".$this->_filter());
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$data['total'] = 'Showing '.($offset+1).' to '.($offset+$limit).' of '.number_format($total).' entries';
		$this->lib_general->display('app',$data);
	}	
	function _set_rules(){
		$this->form_validation->set_rules('code','Form Code','trim|required|callback__check_double');
		for($i=1;$i<=63;$i++){
			$this->form_validation->set_rules('q'.$i,'Q-'.$i,'trim');
		}
		$this->form_validation->set_rules('com_1','Comment 1','trim|callback__check_blank');
		$this->form_validation->set_rules('com_2','Comment 2','trim');
		$this->form_validation->set_rules('dem_1','Demographic 1','trim');
		$this->form_validation->set_rules('dem_2','Demographic 2','trim');
		$this->form_validation->set_rules('dem_3','Demographic 3','trim');
		$this->form_validation->set_rules('dem_4','Demographic 4','trim');
		$this->form_validation->set_rules('dem_5','Demographic 5','trim');
		$this->form_validation->set_rules('dem_6','Demographic 6','trim');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}
	function _check_double(){
		$code = $this->input->post('code');
		$result = $this->mdl_app->check_double($code);
		if($this->uri->segment(2)=='add'){
			if($result->num_rows()>0){
				$this->form_validation->set_message('_check_double', 'Form code sudah terdaftar');
				return false;
			}else{
				return true;
			}
		}else if($this->uri->segment(2)=='edit'){
			if($result->num_rows()>0 && $result->row()->id <> $this->uri->segment(3)){
				$this->form_validation->set_message('_check_double', 'Form code sudah terdaftar');
				return false;
			}else{
				return true;
			}
		}
	}	
	function _check_blank(){
		for($i=1;$i<=63;$i++){
			if ($this->input->post('q'.$i)<>''){
				return true;	
			}
		}		
		$data = array('bidang_1','bidang_1_ket','bidang_2','bidang_2_ket');
		foreach($data as $r){
			if ($this->input->post($r)<>''){
				return true;	
			}			
		}
		$this->form_validation->set_message('_check_blank', 'Formulir Kosong Bro!!!');
		return false;
	}
	function _field(){
		$quesioner = '';
		for($i=1;$i<=63;$i++){
			$quesioner .= $this->input->post('q'.$i).',';
		}
		$data = array(
			'code'=>$this->input->post('code')
			,'quesioner'=>$quesioner
			,'bidang_1'=>$this->input->post('bidang_1')
			,'bidang_1_ket'=>$this->input->post('bidang_1_ket')
			,'bidang_2'=>$this->input->post('bidang_2')
			,'bidang_2_ket'=>$this->input->post('bidang_2_ket')
			,'audit'=>$this->input->post('audit')
			,'salah'=>$this->input->post('salah')
		);
		return $data;		
	}
	function add(){
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$data['title'] = APP_NAME.' - Entry';
			$data['heading'] = 'Entry';
			$data['action'] = 'app/add/';
			$this->lib_general->display('app_form',$data);
		}else{
			$data = $this->_field();
			$data['user_create']=$this->session->userdata('user_login');
			$data['date_create']=date('Y-m-d H:i:s');
			$this->mdl_app->add($data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">Entry Success</div>');
			redirect('app/add'.'?code='.($this->input->post('code')+1));
		}
	}
	function edit($id){
		$this->_check_edit($id);
		$this->_set_rules();
		if($this->form_validation->run()===false){
			$data['title'] = APP_NAME.' - Update';
			$data['heading'] = 'Update';
			$data['action'] = 'app/edit/'.$id;
			$data['row'] = $this->mdl_app->get_from_field('id',$id)->row();
			$data['quesioner'] = explode(',',$data['row']->quesioner);
			$this->lib_general->display('app_form',$data);
		}else{
			$data = $this->_field();
			$data['user_update']=$this->session->userdata('user_login');
			$data['date_update']=date('Y-m-d H:i:s');
			$this->mdl_app->edit($id,$data);
			$this->session->set_flashdata('alert','<div class="alert alert-success">Update Success</div>');
			redirect('app/edit/'.$id);
		}
	}
	function _check_edit($id){
		$app = $this->mdl_app->get_from_field('id',$id)->row();	
		if($this->session->userdata('user_level')==3){
			if($app->user_create<>$this->session->userdata('user_login')){
				redirect('app');
			}
		}
	}
	function search(){
		$data = array(
			'search'=>$this->input->post('search')
			,'limit'=>$this->input->post('limit')
			,'de'=>$this->input->post('de')
			,'date_from'=>$this->input->post('date_from')
			,'date_to'=>$this->input->post('date_to')
		);
		redirect('app'.$this->_filter($data));
	}
	function _filter($add = array()){
		$str = '?avenger=1';
		$data = array('order_column'=>0,'order_type'=>0,'limit'=>0,'offset'=>0,'search'=>0,'de'=>0,'date_from'=>0,'date_to'=>0);
		$result = array_diff_key($data,$add);
		foreach($result as $r => $val){			
			if($this->input->get($r)<>''){
				$str .="&$r=".$this->input->get($r);
			}
		}
		if($add<>''){
			foreach($add as $r => $val){
				$str .="&$r=".$val;
			}
		}
		return $str;
	}	
	function export(){
		$country = $this->input->get('country');
		ini_set('memory_limit','-1'); 

		$order_column = ($this->input->get('order_column')<>''?$this->input->get('order_column'):'id');
		$order_type = ($this->input->get('order_type')<>''?$this->input->get('order_type'):'asc');
		
		require_once "../assets/phpexcel/PHPExcel.php";
		$excel = new PHPExcel();
		
		$excel->setActiveSheetIndex(0);
		$active_sheet = $excel->getActiveSheet();
		$active_sheet->setTitle('App List');		
		$active_sheet->getStyle("A1:BO1")->getFont()->setBold(true);

		$active_sheet->setCellValue('A1', 'responseid');
		$active_sheet->setCellValue('B1', 'respid');
		$active_sheet->setCellValue('C1', 'Date of entry');
		$active_sheet->setCellValue('D1', 'Q1');
		$active_sheet->setCellValue('E1', 'Q2');
		$active_sheet->setCellValue('F1', 'Q3');
		$active_sheet->setCellValue('G1', 'Q4');
		$active_sheet->setCellValue('H1', 'Q5');
		$active_sheet->setCellValue('I1', 'Q6');
		$active_sheet->setCellValue('J1', 'Q7');
		$active_sheet->setCellValue('K1', 'Q8');
		$active_sheet->setCellValue('L1', 'Q9');
		$active_sheet->setCellValue('M1', 'Q10');
		$active_sheet->setCellValue('N1', 'Q11');
		$active_sheet->setCellValue('O1', 'Q12');
		$active_sheet->setCellValue('P1', 'Q13');
		$active_sheet->setCellValue('Q1', 'Q14');
		$active_sheet->setCellValue('R1', 'Q15');
		$active_sheet->setCellValue('S1', 'Q16');
		$active_sheet->setCellValue('T1', 'Q17');
		$active_sheet->setCellValue('U1', 'Q18');
		$active_sheet->setCellValue('V1', 'Q19');
		$active_sheet->setCellValue('W1', 'Q20');
		$active_sheet->setCellValue('X1', 'Q21');
		$active_sheet->setCellValue('Y1', 'Q22');
		$active_sheet->setCellValue('Z1', 'Q23');
		$active_sheet->setCellValue('AA1', 'Q24');
		$active_sheet->setCellValue('AB1', 'Q25');
		$active_sheet->setCellValue('AC1', 'Q26');
		$active_sheet->setCellValue('AD1', 'Q27');
		$active_sheet->setCellValue('AE1', 'Q28');
		$active_sheet->setCellValue('AF1', 'Q29');
		$active_sheet->setCellValue('AG1', 'Q30');
		$active_sheet->setCellValue('AH1', 'Q31');
		$active_sheet->setCellValue('AI1', 'Q32');
		$active_sheet->setCellValue('AJ1', 'Q33');
		$active_sheet->setCellValue('AK1', 'Q34');
		$active_sheet->setCellValue('AL1', 'Q35');
		$active_sheet->setCellValue('AM1', 'Q36');
		$active_sheet->setCellValue('AN1', 'Q37');
		$active_sheet->setCellValue('AO1', 'Q38');
		$active_sheet->setCellValue('AP1', 'Q39');
		$active_sheet->setCellValue('AQ1', 'Q40');
		$active_sheet->setCellValue('AR1', 'Q41');
		$active_sheet->setCellValue('AS1', 'Q42');
		$active_sheet->setCellValue('AT1', 'Q43');
		$active_sheet->setCellValue('AU1', 'Q44');
		$active_sheet->setCellValue('AV1', 'Q45');
		$active_sheet->setCellValue('AW1', 'Q46');
		$active_sheet->setCellValue('AX1', 'Q47');
		$active_sheet->setCellValue('AY1', 'Q48');
		$active_sheet->setCellValue('AZ1', 'Q49');
		$active_sheet->setCellValue('BA1', 'Q50');
		$active_sheet->setCellValue('BB1', 'Q51');
		$active_sheet->setCellValue('BC1', 'Q52');
		$active_sheet->setCellValue('BD1', 'Q53');
		$active_sheet->setCellValue('BE1', 'Q54');
		$active_sheet->setCellValue('BF1', 'Q55');
		$active_sheet->setCellValue('BG1', 'Q56');
		$active_sheet->setCellValue('BH1', 'Q57');
		$active_sheet->setCellValue('BI1', 'Q58');
		$active_sheet->setCellValue('BJ1', 'Q59');
		$active_sheet->setCellValue('BK1', 'Q60');		
		$active_sheet->setCellValue('BL1', 'Q61');
		$active_sheet->setCellValue('BM1', 'Q62');
		$active_sheet->setCellValue('BN1', 'Q63');
		$active_sheet->setCellValue('BO1', 'Bidang 1');
		$active_sheet->setCellValue('BP1', 'Bidang 1 Ket');
		$active_sheet->setCellValue('BQ1', 'Bidang 2');
		$active_sheet->setCellValue('BR1', 'Bidang 2 Ket');
		$active_sheet->setCellValue('BS1', 'Audit');
		$active_sheet->setCellValue('BT1', 'Salah');
		$active_sheet->setCellValue('BU1', 'User Entry');
		$active_sheet->setCellValue('BV1', 'Date Entry');
		$result = $this->mdl_app->export()->result();
		$i=2;
		foreach($result as $r){
			$quesioner = explode(',',$r->quesioner);
			$active_sheet->setCellValue('A'.$i, $r->code);
			$active_sheet->setCellValue('B'.$i, '');
			$active_sheet->setCellValue('C'.$i, PHPExcel_Shared_Date::PHPToExcel(date_to_excel($r->date_create)));
			$active_sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode('dd/mm/yyyy');		   			
			$active_sheet->setCellValue('D'.$i, $quesioner[1-1]);
			$active_sheet->setCellValue('E'.$i, $quesioner[2-1]);
			$active_sheet->setCellValue('F'.$i, $quesioner[3-1]);
			$active_sheet->setCellValue('G'.$i, $quesioner[4-1]);
			$active_sheet->setCellValue('H'.$i, $quesioner[5-1]);
			$active_sheet->setCellValue('I'.$i, $quesioner[6-1]);
			$active_sheet->setCellValue('J'.$i, $quesioner[7-1]);
			$active_sheet->setCellValue('K'.$i, $quesioner[8-1]);
			$active_sheet->setCellValue('L'.$i, $quesioner[9-1]);
			$active_sheet->setCellValue('M'.$i, $quesioner[10-1]);
			$active_sheet->setCellValue('N'.$i, $quesioner[11-1]);
			$active_sheet->setCellValue('O'.$i, $quesioner[12-1]);
			$active_sheet->setCellValue('P'.$i, $quesioner[13-1]);
			$active_sheet->setCellValue('Q'.$i, $quesioner[14-1]);
			$active_sheet->setCellValue('R'.$i, $quesioner[15-1]);
			$active_sheet->setCellValue('S'.$i, $quesioner[16-1]);
			$active_sheet->setCellValue('T'.$i, $quesioner[17-1]);
			$active_sheet->setCellValue('U'.$i, $quesioner[18-1]);
			$active_sheet->setCellValue('V'.$i, $quesioner[19-1]);
			$active_sheet->setCellValue('W'.$i, $quesioner[20-1]);
			$active_sheet->setCellValue('X'.$i, $quesioner[21-1]);
			$active_sheet->setCellValue('Y'.$i, $quesioner[22-1]);
			$active_sheet->setCellValue('Z'.$i, $quesioner[23-1]);
			$active_sheet->setCellValue('AA'.$i, $quesioner[24-1]);
			$active_sheet->setCellValue('AB'.$i, $quesioner[25-1]);
			$active_sheet->setCellValue('AC'.$i, $quesioner[26-1]);
			$active_sheet->setCellValue('AD'.$i, $quesioner[27-1]);
			$active_sheet->setCellValue('AE'.$i, $quesioner[28-1]);
			$active_sheet->setCellValue('AF'.$i, $quesioner[29-1]);
			$active_sheet->setCellValue('AG'.$i, $quesioner[30-1]);
			$active_sheet->setCellValue('AH'.$i, $quesioner[31-1]);
			$active_sheet->setCellValue('AI'.$i, $quesioner[32-1]);
			$active_sheet->setCellValue('AJ'.$i, $quesioner[33-1]);
			$active_sheet->setCellValue('AK'.$i, $quesioner[34-1]);
			$active_sheet->setCellValue('AL'.$i, $quesioner[35-1]);
			$active_sheet->setCellValue('AM'.$i, $quesioner[36-1]);
			$active_sheet->setCellValue('AN'.$i, $quesioner[37-1]);
			$active_sheet->setCellValue('AO'.$i, $quesioner[38-1]);
			$active_sheet->setCellValue('AP'.$i, $quesioner[39-1]);
			$active_sheet->setCellValue('AQ'.$i, $quesioner[40-1]);
			$active_sheet->setCellValue('AR'.$i, $quesioner[41-1]);
			$active_sheet->setCellValue('AS'.$i, $quesioner[42-1]);
			$active_sheet->setCellValue('AT'.$i, $quesioner[43-1]);
			$active_sheet->setCellValue('AU'.$i, $quesioner[44-1]);
			$active_sheet->setCellValue('AV'.$i, $quesioner[45-1]);
			$active_sheet->setCellValue('AW'.$i, $quesioner[46-1]);
			$active_sheet->setCellValue('AX'.$i, $quesioner[47-1]);
			$active_sheet->setCellValue('AY'.$i, $quesioner[48-1]);
			$active_sheet->setCellValue('AZ'.$i, $quesioner[49-1]);
			$active_sheet->setCellValue('BA'.$i, $quesioner[50-1]);
			$active_sheet->setCellValue('BB'.$i, $quesioner[51-1]);
			$active_sheet->setCellValue('BC'.$i, $quesioner[52-1]);
			$active_sheet->setCellValue('BD'.$i, $quesioner[53-1]);
			$active_sheet->setCellValue('BE'.$i, $quesioner[54-1]);
			$active_sheet->setCellValue('BF'.$i, $quesioner[55-1]);
			$active_sheet->setCellValue('BG'.$i, $quesioner[56-1]);
			$active_sheet->setCellValue('BH'.$i, $quesioner[57-1]);
			$active_sheet->setCellValue('BI'.$i, $quesioner[58-1]);
			$active_sheet->setCellValue('BJ'.$i, $quesioner[59-1]);
			$active_sheet->setCellValue('BK'.$i, $quesioner[60-1]);
			$active_sheet->setCellValue('BL'.$i, $quesioner[61-1]);
			$active_sheet->setCellValue('BM'.$i, $quesioner[62-1]);
			$active_sheet->setCellValue('BN'.$i, $quesioner[63-1]);
			$active_sheet->setCellValue('BO'.$i, $r->bidang_1_name);
			$active_sheet->setCellValue('BP'.$i, $r->bidang_1_ket);
			$active_sheet->setCellValue('BQ'.$i, $r->bidang_2_name);
			$active_sheet->setCellValue('BR'.$i, $r->bidang_2_ket);
			$active_sheet->setCellValue('BS'.$i, $r->audit);
			$active_sheet->setCellValue('BT'.$i, $r->salah);
			$active_sheet->setCellValue('BU'.$i, $r->fullname);
			$active_sheet->setCellValue('BV'.$i, PHPExcel_Shared_Date::PHPToExcel(date_to_excel($r->date_create)));
			$active_sheet->getStyle('BV'.$i)->getNumberFormat()->setFormatCode('dd/mm/yyyy');		   
			$i++;
		}

		$filename='LIST_APP_'.date('Ymd_His').'.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
							 
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');  
		$objWriter->save('php://output');
	}	
}