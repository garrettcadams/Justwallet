<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <?php echo lang('admin template template'); ?> <?php echo $sms_templates['id']; ?>
      </div>
      <div class="card-body">
        <?php echo form_open('', array('role'=>'form')); ?>
          <?php // hidden id ?>
          <?php if (isset($sms_templates_id)) : ?>
          <?php echo form_hidden('id', $sms_templates_id); ?>
          <?php endif; ?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label><?php echo lang('admin template title_message'); ?> </label>
                <span class="required">*</span>
                <?php echo form_input(array('name'=>'title', 'value'=>set_value('title', (isset($sms_templates['title']) ? $sms_templates['title'] : '')), 'class'=>'form-control form-control-sm')); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <label><?php echo lang('admin template status'); ?> </label>
                <span class="required">*</span>
                <select class="form-control form-control-sm" name="status">
                  <option value="0" <?if($sms_templates['status']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                  <option value="1" <?if($sms_templates['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
                <label><?php echo lang('admin template content'); ?></label>
                <span class="required">*</span>
                <textarea class="form-control form-control-sm" name="message" rows="10" id="message" value=""><?php echo $sms_templates['message']; ?></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer-padding">
        <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
      </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>