<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-4">
    <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo lang('admins trans amount'); ?></strong></div>
            <span class="icons"><?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $transactions['amount']; ?> 
              <?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            
            </div>
          </div>
       </div>
  </div>
  <div class="col-md-4">
     <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo lang('admins trans fee'); ?></strong></div>
            <span class="icons"><?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $transactions['fee']; ?> 
              <?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            
            </div>
          </div>
       </div>
  </div>
  <div class="col-md-4">
    <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo lang('admins trans sum'); ?></strong></div>
            <span class="icons"><?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $transactions['sum']; ?> 
              <?if($transactions['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transactions['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            
            </div>
          </div>
       </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-8">
            <?php echo lang('admins trans id'); ?> <?php echo $transactions['id']; ?>, 
            <?if($transactions['type'] == 1){?>
              <?php echo lang('admins trans deposit'); ?>
            <?}else{?>
            <?}?>
            <?if($transactions['type'] == 2){?>
              <?php echo lang('admins trans withdrawal'); ?>
            <?}else{?>
            <?}?>
            <?if($transactions['type'] == 3){?>
              <?php echo lang('admins trans transfer'); ?>
            <?}else{?>
            <?}?>
            <?if($transactions['type'] == 4){?>
              <?php echo lang('admins trans exchange'); ?>
            <?}else{?>
            <?}?>
            <?if($transactions['type'] == 5){?>
              <?php echo lang('admins trans external'); ?>
            <?}else{?>
            <?}?>
          </div>
          <div class="col-md-4 -text-right">
            <?if($transactions['status'] == 1){?>
              <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
            <?}else{?>
            <?}?>
            <?if($transactions['status'] == 2){?>
              <span class="badge badge-success"> <?php echo lang('users trans success'); ?> </span>
            <?}else{?>
            <?}?>
            <?if($transactions['status'] == 3){?>
              <span class="badge badge-default"> <?php echo lang('users trans refund'); ?> </span>
            <?}else{?>
            <?}?>
            <?if($transactions['status'] == 4){?>
              <span class="badge badge-danger"> <?php echo lang('users trans dispute'); ?> </span>
            <?}else{?>
            <?}?>
            <?if($transactions['status'] == 5){?>
              <span class="badge badge-warning"> <?php echo lang('users trans blocked'); ?> </span>
            <?}else{?>
            <?}?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open('', array('role'=>'form')); ?>

        <?php // hidden id ?>
        <?php if (isset($transactions_id)) : ?>
          <?php echo form_hidden('id', $transactions_id); ?>
        <?php endif; ?>
        <?if($transactions['protect'] != "none" && $transactions['status'] == 1){?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo lang('admin new info_ptotect'); ?> <strong><?php echo $transactions['protect_attempts']; ?></strong>
          <button type="button" class="close button-close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true"><i class="icon-close Icon"></i></span>
					</button>
        </div>
        <?}else{?>
        <?}?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans sender'), 'sender', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'sender', 'value'=>set_value('sender', (isset($transactions['sender']) ? $transactions['sender'] : '')), 'class'=>'form-control form-control-sm')); ?>
							<?if($transactions['payer_fee'] == "0"){?>
							<small class="form-text text-muted"><?php echo lang('admin security payeer_fee'); ?></small>
							<?}else{?>
							<?}?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans receiver'), 'receiver', array('class'=>'control-label')); ?>
              <span class="required"> <?if($transactions['type'] == 5){?>
              <?php echo lang('admins pay sci'); ?> <a href="<?php echo base_url();?>admin/merchants/edit_merchant/<?php echo $merchant['id']; ?>" target="_blank"><?php echo $merchant['name']; ?></a>
							<?}else{?>
							<?}?>
							</span>
              <?php echo form_input(array('name'=>'receiver', 'value'=>set_value('receiver', (isset($transactions['receiver']) ? $transactions['receiver'] : '')), 'class'=>'form-control form-control-sm')); ?>
							<?if($transactions['payer_fee'] == "1"){?>
							<small class="form-text text-muted"><?php echo lang('admin security payeer_fee'); ?></small>
							<?}else{?>
							<?}?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin events date'), 'time', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'time', 'value'=>set_value('time', (isset($transactions['time']) ? $transactions['time'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin events ip'), 'time', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'ip_address', 'value'=>set_value('ip_address', (isset($transactions['ip_address']) ? $transactions['ip_address'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin new code_ptotection'), 'protect', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'protect', 'value'=>set_value('protect', (isset($transactions['protect']) ? $transactions['protect'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin new label_transaction'), 'time', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'label', 'value'=>set_value('label', (isset($transactions['label']) ? $transactions['label'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans comment'), 'user_comment', array('class'=>'control-label')); ?>
              <?php echo form_textarea(array('name'=>'user_comment', 'value'=>set_value('user_comment', (isset($transactions['user_comment']) ? $transactions['user_comment'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans admins_comment'), 'admin_comment', array('class'=>'control-label')); ?>
              <?php echo form_textarea(array('name'=>'admin_comment', 'value'=>set_value('admin_comment', (isset($transactions['admin_comment']) ? $transactions['admin_comment'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer-padding">
					<div class="btn-group dropup">
					<button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo lang('admin col actions'); ?>
					</button>
					<div class="dropdown-menu">
						<?if($transactions['status'] == "1" && $transactions['type'] == "1"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/ok_deposit/<?php echo $transactions['id'] ?>"><?php echo lang('admin verify confirm'); ?></a>
						<?}else{?>
						<?}?>
						<?if($transactions['status'] == "1" && $transactions['type'] == "2"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/ok_withdrawal/<?php echo $transactions['id'] ?>"><?php echo lang('admin verify confirm'); ?></a>
						<?}else{?>
						<?}?>
						<?if($transactions['status'] == "1" && $transactions['type'] == "2"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/no_withdrawal/<?php echo $transactions['id'] ?>"><?php echo lang('admin verify reject'); ?></a>
						<?}else{?>
						<?}?>
						<?if($transactions['status'] != "5"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/on_hold/<?php echo $transactions['id'] ?>"><?php echo lang('admin security on-hold'); ?></a>
						<?}else{?>
						<?}?>
						<?if($transactions['status'] == "5"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/re_hold/<?php echo $transactions['id'] ?>"><?php echo lang('admin security del-hold'); ?></a>
						<?}else{?>
						<?}?>
						<?if($transactions['status'] != "3"){?>
						<a class="dropdown-item" href="<?php echo base_url();?>admin/transactions/refund/<?php echo $transactions['id'] ?>"><?php echo lang('admins trans refund'); ?></a>
						<?}else{?>
						<?}?>
					</div>
				</div>
        <button type="submit"  class="btn btn-success btn-sm"><?php echo lang('core button save'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>