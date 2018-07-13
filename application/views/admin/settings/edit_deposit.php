<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-2">
    <div class="card">
      <div class="nav flex-column nav-pills" id="user_menu" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true"><?php echo lang('admin user main'); ?></a>
        <a class="nav-link" id="v-pills-logs-tab" data-toggle="pill" href="#v-pills-logs" role="tab" aria-controls="v-pills-logs" aria-selected="true"><?php echo lang('admin deposit limits'); ?></a>
        <a class="nav-link" id="v-pills-billing-tab" data-toggle="pill" href="#v-pills-billing" role="tab" aria-controls="v-pills-billing" aria-selected="true"><?php echo lang('admin deposit availability'); ?></a>
        <a class="nav-link" id="v-pills-verify-tab" data-toggle="pill" href="#v-pills-verify" role="tab" aria-controls="v-pills-verify" aria-selected="true"><?php echo lang('admin deposit connection'); ?></a>
      </div>
    </div>
  </div>
  <div class="col-md-10">
    <div class="row">
      
      <div class="col-md-12">
        <div class="card">
          <div class="card-title">
              <?php echo lang('admin settings edit'); ?> <?php echo $method['name']; ?>
          </div>
          <div class="card-body">
            <?php echo form_open('', array('role'=>'form')); ?>
            <?php // hidden id ?>
            <?php if (isset($method_id)) : ?>
            <?php echo form_hidden('id', $method_id); ?>
            <?php endif; ?>
            <div class="tab-content" id="user_menu">
              <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label><?php echo lang('admin settings name'); ?> </label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'name', 'value'=>set_value('name', (isset($method['name']) ? $method['name'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin settings fix_fee'); ?> </label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'fee_fix', 'value'=>set_value('fee_fix', (isset($method['fee_fix']) ? $method['fee_fix'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin settings fee'); ?>, %</label>
                      <span class="required">*</span>
                      
                      <?php echo form_input(array('name'=>'fee', 'value'=>set_value('fee', (isset($method['fee']) ? $method['fee'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->base_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_base', 'value'=>set_value('ac_debit_base', (isset($method['ac_debit_base']) ? $method['ac_debit_base'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_base', 'value'=>set_value('ac_debit_base', (isset($method['ac_debit_base']) ? $method['ac_debit_base'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_base', 'value'=>set_value('ac_debit_base', (isset($method['ac_debit_base']) ? $method['ac_debit_base'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->extra1_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra1', 'value'=>set_value('ac_debit_extra1', (isset($method['ac_debit_extra1']) ? $method['ac_debit_extra1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra1', 'value'=>set_value('ac_debit_extra1', (isset($method['ac_debit_extra1']) ? $method['ac_debit_extra1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_extra1', 'value'=>set_value('ac_debit_extra1', (isset($method['ac_debit_extra1']) ? $method['ac_debit_extra1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->extra2_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra2', 'value'=>set_value('ac_debit_extra2', (isset($method['ac_debit_extra2']) ? $method['ac_debit_extra2'] : '')), 'class'=>'form-control form-control-sm')); ?>
 
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra2', 'value'=>set_value('ac_debit_extra2', (isset($method['ac_debit_extra2']) ? $method['ac_debit_extra2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_extra2', 'value'=>set_value('ac_debit_extra2', (isset($method['ac_debit_extra2']) ? $method['ac_debit_extra2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->extra3_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra3', 'value'=>set_value('ac_debit_extra3', (isset($method['ac_debit_extra3']) ? $method['ac_debit_extra3'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra3', 'value'=>set_value('ac_debit_extra3', (isset($method['ac_debit_extra3']) ? $method['ac_debit_extra3'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_extra3', 'value'=>set_value('ac_debit_extra3', (isset($method['ac_debit_extra3']) ? $method['ac_debit_extra3'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->extra4_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra4', 'value'=>set_value('ac_debit_extra4', (isset($method['ac_debit_extra4']) ? $method['ac_debit_extra4'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra4', 'value'=>set_value('ac_debit_extra4', (isset($method['ac_debit_extra4']) ? $method['ac_debit_extra4'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_extra4', 'value'=>set_value('ac_debit_extra4', (isset($method['ac_debit_extra4']) ? $method['ac_debit_extra4'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit account_pp'); ?>, <?php echo $this->currencys->display->extra5_code ?></label>
                      <span class="required">*</span>
                      <?if($method['id']=="7"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra5', 'value'=>set_value('ac_debit_extra5', (isset($method['ac_debit_extra5']) ? $method['ac_debit_extra5'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}elseif($method['id']=="8"){?>
                      <?php echo form_textarea(array('name'=>'ac_debit_extra5', 'value'=>set_value('ac_debit_extra5', (isset($method['ac_debit_extra5']) ? $method['ac_debit_extra5'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}else{?>
                      <?php echo form_input(array('name'=>'ac_debit_extra5', 'value'=>set_value('ac_debit_extra5', (isset($method['ac_debit_extra5']) ? $method['ac_debit_extra5'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?}?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-logs" role="tabpanel" aria-labelledby="v-pills-logs-tab">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->base_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_base', 'value'=>set_value('minimum_debit_base', (isset($method['minimum_debit_base']) ? $method['minimum_debit_base'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->base_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_base', 'value'=>set_value('maximum_debit_base', (isset($method['maximum_debit_base']) ? $method['maximum_debit_base'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->extra1_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_extra1', 'value'=>set_value('minimum_debit_extra1', (isset($method['minimum_debit_extra1']) ? $method['minimum_debit_extra1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->extra1_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_extra1', 'value'=>set_value('maximum_debit_extra1', (isset($method['maximum_debit_extra1']) ? $method['maximum_debit_extra1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->extra2_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_extra2', 'value'=>set_value('minimum_debit_extra2', (isset($method['minimum_debit_extra2']) ? $method['minimum_debit_extra2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->extra2_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_extra2', 'value'=>set_value('maximum_debit_extra2', (isset($method['maximum_debit_extra2']) ? $method['maximum_debit_extra2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->extra3_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_extra3', 'value'=>set_value('minimum_debit_extra3', (isset($method['minimum_debit_extra3']) ? $method['minimum_debit_extra3'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->extra3_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_extra3', 'value'=>set_value('maximum_debit_extra3', (isset($method['maximum_debit_extra3']) ? $method['maximum_debit_extra3'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->extra4_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_extra4', 'value'=>set_value('minimum_debit_extra4', (isset($method['minimum_debit_extra4']) ? $method['minimum_debit_extra4'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->extra4_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_extra4', 'value'=>set_value('maximum_debit_extra4', (isset($method['maximum_debit_extra4']) ? $method['maximum_debit_extra4'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal minimum'); ?>, <?php echo $this->currencys->display->extra5_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'minimum_debit_extra5', 'value'=>set_value('minimum_debit_extra5', (isset($method['minimum_debit_extra5']) ? $method['minimum_debit_extra5'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin withdrawal maximum'); ?>, <?php echo $this->currencys->display->extra5_code ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'maximum_debit_extra5', 'value'=>set_value('maximum_debit_extra5', (isset($method['maximum_debit_extra5']) ? $method['maximum_debit_extra5'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user status'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="status">
                        <option value="0" <?if($method['status']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin settings initial'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="start_verify">
                        <option value="0" <?if($method['start_verify']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['start_verify']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin settings standart'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="standart_verify">
                        <option value="0" <?if($method['standart_verify']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['standart_verify']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin settings extended'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="expanded_verify">
                        <option value="0" <?if($method['expanded_verify']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['expanded_verify']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->base_name ?>, <?php echo $this->currencys->display->base_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_base">
                        <option value="0" <?if($method['debit_base']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_base']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->extra1_name ?>, <?php echo $this->currencys->display->extra1_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_extra1">
                        <option value="0" <?if($method['debit_extra1']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_extra1']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->extra2_name ?>, <?php echo $this->currencys->display->extra2_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_extra2">
                        <option value="0" <?if($method['debit_extra2']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_extra2']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->extra3_name ?>, <?php echo $this->currencys->display->extra3_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_extra3">
                        <option value="0" <?if($method['debit_extra3']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_extra3']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->extra4_name ?>, <?php echo $this->currencys->display->extra4_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_extra4">
                        <option value="0" <?if($method['debit_extra4']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_extra4']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo $this->currencys->display->extra5_name ?>, <?php echo $this->currencys->display->extra5_code ?></label>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="debit_extra5">
                        <option value="0" <?if($method['debit_extra5']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($method['debit_extra5']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-verify" role="tabpanel" aria-labelledby="v-pills-verify-tab">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit api_value_1'); ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'api_value1', 'value'=>set_value('api_value1', (isset($method['api_value1']) ? $method['api_value1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?if($method['id']=="1"){?>
                      <small class="form-text text-muted">For PayPal - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="2"){?>
                      <small class="form-text text-muted">For Perfect Money - Alternate Passphrase</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="3"){?>
                      <small class="form-text text-muted">For ADV Cash - SCI name</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="4"){?>
                      <small class="form-text text-muted">For Payeer - Secret key</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="5"){?>
                      <small class="form-text text-muted">For Skrill - Merchant_id</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="6"){?>
                      <small class="form-text text-muted">For PayGol - Secret key</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="7"){?>
                      <small class="form-text text-muted">For SWIFT - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="8"){?>
                      <small class="form-text text-muted">For Local Bank - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="9"){?>
                      <small class="form-text text-muted">For Coinpayments - secret word</small>
                      <?}else{?>
                      <?}?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label><?php echo lang('admin deposit api_value_2'); ?></label>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'api_value2', 'value'=>set_value('api_value2', (isset($method['api_value2']) ? $method['api_value2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                      <?if($method['id']=="1"){?>
                      <small class="form-text text-muted">For PayPal - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="2"){?>
                      <small class="form-text text-muted">For Perfect Money - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="3"){?>
                      <small class="form-text text-muted">For ADV Cash - password SCI</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="4"){?>
                      <small class="form-text text-muted">For Payeer - Key for encryption additional parameters</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="5"){?>
                      <small class="form-text text-muted">For Skrill - Secret word</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="6"){?>
                      <small class="form-text text-muted">For PayGol - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="7"){?>
                      <small class="form-text text-muted">For SWIFT - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="8"){?>
                      <small class="form-text text-muted">For Local Bank - Not used</small>
                      <?}else{?>
                      <?}?>
                      <?if($method['id']=="9"){?>
                      <small class="form-text text-muted">For Coinpayments - Not used</small>
                      <?}else{?>
                      <?}?>
                    </div>
                  </div>
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
    </div>
  </div>