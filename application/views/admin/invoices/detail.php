<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-4">
    <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo lang('admins trans amount'); ?></strong></div>
            <span class="icons"><?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $invoice['amount']; ?> 
              <?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
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
            <span class="icons"><?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $invoice['fee']; ?> 
              <?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
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
            <span class="icons"> <?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
            </span>
            <div class="result">
              <?php echo $invoice['total']; ?> 
              <?if($invoice['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($invoice['currency']=='debit_extra5'){?>
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
            <?php echo lang('admin invoices invoice'); ?> <?php echo $invoice['id']; ?>
          </div>
          <div class="col-md-4 -text-right">
            <?if($invoice['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($invoice['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($invoice['status']==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('admin invoices declined'); ?> </span>
                                <?}else{?>
                                <?}?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open('', array('role'=>'form')); ?>

        <?php // hidden id ?>
        <?php if (isset($invoice_id)) : ?>
          <?php echo form_hidden('id', $invoice_id); ?>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans sender'), 'sender', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'sender', 'value'=>set_value('sender', (isset($invoice['sender']) ? $invoice['sender'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admins trans receiver'), 'receiver', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'receiver', 'value'=>set_value('receiver', (isset($invoice['receiver']) ? $invoice['receiver'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin events date'), 'date', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'date', 'value'=>set_value('date', (isset($invoice['date']) ? $invoice['date'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <?php echo form_label(lang('admin invoices label'), 'code', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'code', 'value'=>set_value('code', (isset($invoice['code']) ? $invoice['code'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <?php echo form_label(lang('admin invoices name'), 'name', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'name', 'value'=>set_value('name', (isset($invoice['name']) ? $invoice['name'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <?php echo form_label(lang('admin invoices description'), 'info', array('class'=>'control-label')); ?>
              <span class="required">*</span>
              <?php echo form_textarea(array('name'=>'info', 'value'=>set_value('info', (isset($invoice['info']) ? $invoice['info'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          
        </div>
      </div>
      <div class="card-footer-padding">
        <button type="submit"  class="btn btn-success btn-sm"><?php echo lang('core button save'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>