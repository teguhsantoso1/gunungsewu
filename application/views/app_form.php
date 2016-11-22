<?=$this->session->flashdata('alert')?>
<?=validation_errors()?>
<?=form_open($action)?>
<section class="content-header breadcrumb">
	Form Code : <?=form_input(array('name'=>'code','type'=>'number','maxlength'=>'10','autocomplete'=>'off','autofocus'=>'autofocus','value'=>set_value('code',(isset($row->code)?$row->code:""))))?>
	<ol class="breadcrumb">
	  <li class="active"><?=$heading?></li>
	  <li>User Entry : <b><?=$this->lib_general->get_username(isset($row->user_create)?$row->user_create:$this->session->userdata('user_login'))?></b></li>
	</ol>
</section>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				PERTANYAAN
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="pull-left question">
						<?php for($i=1;$i<=9;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=10;$i<=18;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=19;$i<=27;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=28;$i<=36;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=37;$i<=46;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=47;$i<=56;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
					<div class="pull-left question">
						<?php for($i=57;$i<=63;$i++){?>
						<div class="form-group">
							<label class="label label-default"><?=$i?></label><?=form_dropdown('q'.$i,dropnum(6),set_value('q'.$i,(isset($quesioner[$i-1])?$quesioner[$i-1]:"")))?>
						</div>	
						<?php }?>
					</div>	
				</div>	
			</div>
		</div>		
	</div>	
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				KOMENTAR
			</div>
			<div class="panel-body">
				<div class="form-group">
					<?=form_label('1. Apa yang paling Anda sukai dalam bekerja di perusahaan ini? Pilihlah bidang yang paling sesuai dan uraikan pendapat atau pandangan Anda')?>
					<p>Jawab : <?=form_dropdown('bidang_1',$this->mdl_bidang->dropdown(),set_value('bidang_1',(isset($row->bidang_1)?$row->bidang_1:"")))?></p>
					<?=form_textarea(array('name'=>'bidang_1_ket','rows'=>'4','class'=>'form-control input-sm','autocomplete'=>'off','value'=>set_value('bidang_1_ket',(isset($row->bidang_1_ket)?$row->bidang_1_ket:""))))?>
				</div><hr>
				<div class="form-group">
					<?=form_label('2. Adakah hal-hal yang menurut anda perlu ditingkatkan di perusahaan ini? Pilihlah bidang yang sesuai dan uraikan pendapat anda')?>
					<p>Jawab : <?=form_dropdown('bidang_2',$this->mdl_bidang->dropdown(),set_value('bidang_2',(isset($row->bidang_2)?$row->bidang_2:"")))?></p>
					<?=form_textarea(array('name'=>'bidang_2_ket','rows'=>'4','class'=>'form-control input-sm','autocomplete'=>'off','value'=>set_value('bidang_2_ket',(isset($row->bidang_2_ket)?$row->bidang_2_ket:""))))?>
				</div>
			</div>
		</div>
	</div>	
</div>	
<div class="panel panel-default">
	<div class="panel-footer">
		<?php if($this->session->userdata('user_level')<>3){?>
		<?=form_checkbox('audit','Y',set_value('audit',(isset($row->audit) && $row->audit=='Y'?$row->audit:'')))?> Audit
		<?php }?>
		<button class="btn btn-primary btn-sm" type="submit" onclick="return confirm('You sure')"><span class="glyphicon glyphicon-save"></span> Save</button>
	</div>	
</div>	
<?=form_close()?>
