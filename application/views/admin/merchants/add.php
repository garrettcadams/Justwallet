<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open_multipart('', array('role'=>'form')); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
         <?php echo lang('admin shops categories_new'); ?>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
              <li class="nav-item">
              <a class="nav-link <?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>" id="<?php echo $language_key; ?>-tab" data-toggle="tab" href="#<?php echo $language_key; ?>" role="tab" aria-controls="<?php echo $language_key; ?>" aria-selected="true"><?php echo $language_name; ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="tab-content mt-tab" id="myTabContent">
              <?php // has translations ?>

              <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
              <div class="tab-pane fade <?php echo ($language_key == $this->session->language) ? 'show active' : ''; ?>" id="<?php echo $language_key; ?>" role="tabpanel" aria-labelledby="<?php echo $language_key; ?>-tab">
                <?php
                 $field_data['name']  = "name[" . $language_key . "]";
                 $field_data['id']    = "name-" . $language_key;
                 $field_data['class'] = "form-control form-control-sm";
                ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo lang('admin invoices name'); ?></label>
                        <?php echo form_input($field_data); ?>
                    </div>
                  </div>
                  
                  
                  
                </div>

              </div>
              <?php endforeach; ?>
              <div class="row">
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admins trans status'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="status">
                        <option value="0"><?php echo lang('admin template disabled'); ?></option>
                        <option value="1"><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label(lang('admin shops categories_logo'), array('class'=>'control-label')); ?>
                    <input type="file" class="form-control-file" id="logo" name="logo">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer-padding">
        <button type="submit"  class="btn btn-success btn-sm"><?php echo lang('core button save'); ?></button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>