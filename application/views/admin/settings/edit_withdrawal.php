<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('admin settings name'); ?> </label>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'name', 'value'=>set_value('name', (isset($method['name']) ? $method['name'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('admin settings terms'); ?> </label>
              <span class="required">*</span>
              <?php echo form_input(array('name'=>'terms', 'value'=>set_value('terms', (isset($method['terms']) ? $method['terms'] : '')), 'class'=>'form-control form-control-sm')); ?>
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
      <div class="card-footer-padding">
        <button type="submit"  class="btn btn-success btn-sm"><?php echo lang('core button save'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>