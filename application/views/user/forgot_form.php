<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="header-st mb-4">
			<div class="container">
				<div class="row">
          <div class="col-md-12">
            <h3>
              <?php echo lang('core button forgot') ?>
            </h3>
          </div>
        </div>
  </div>
</div>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body">
          <?php echo form_open('', array('role'=>'form')); ?>
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('core button email'); ?></label>
              <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'placeholder'=>lang('core core button enter_email'), 'class'=>'form-control', 'type'=>'email')); ?>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="g-recaptcha" data-sitekey="<?php echo $this->settings->google_site_key; ?>"></div>
              </div>
              <div class="col-md-6">
                <a href="<?php echo base_url('login'); ?>"><?php echo lang('core button back_login'); ?></a></br>
              </div>
              <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-success"><?php echo lang('users button reset_password'); ?></button>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
