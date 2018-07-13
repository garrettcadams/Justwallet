<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open_multipart('', array('role'=>'form')); ?>
            <?php // hidden id ?>
            <?php if (isset($category_id)) : ?>
              <?php echo form_hidden('id', $category_id); ?>
            <?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
         <?php echo lang('admin shops categories_edit'); ?> <?php echo $category['id']; ?>
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
              <?php
                $category['name'] = (@unserialize($category['name']) !== FALSE) ? unserialize($category['name']) : $category['name'];
                if ( ! is_array($category['name']))
                {
                    $old_value = $category['name'];
                    $category['name'] = array();
                    foreach ($this->session->languages as $language_key=>$language_name)
                    {
                        $category['name'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                    }
                }
              ?>
              <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
              <div class="tab-pane fade <?php echo ($language_key == $this->session->language) ? 'show active' : ''; ?>" id="<?php echo $language_key; ?>" role="tabpanel" aria-labelledby="<?php echo $language_key; ?>-tab">
                <?php
                 $field_data['name']  = "name[" . $language_key . "]";
                 $field_data['id']    = "name-" . $language_key;
                 $field_data['class'] = "form-control form-control-sm";
                 $field_data['value'] = (@$category['name'][$language_key]) ? $category['name'][$language_key] : "";
              
                 $editor = "name-" . $language_key;
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
                      <?php echo form_label(lang('admin events code'), 'code', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'code', 'value'=>set_value('code', (isset($category['code']) ? $category['code'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admins trans status'), array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <select class="form-control form-control-sm" name="status">
                        <option value="0" <?if($category['status']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($category['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                <div class="col-md-2">
                  <div class="card card-search">
                    <img class="img-responsive" src="<?php echo base_url();?>upload/logo/<?php echo $category['img']; ?>">
                  </div>
                </div>
                <div class="col-md-10">
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