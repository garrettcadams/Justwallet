<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="header-st mb-4">
			<div class="container">
				<div class="row">
          <div class="col-md-12">
            <h3>
              <?php echo lang('core button sign_in') ?>
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
        <?php echo form_open('', array('class'=>'')); ?>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo lang('core button username_email'); ?></label>
            <?php echo form_input(array('name'=>'username', 'id'=>'username', 'class'=>'form-control', 'placeholder'=>lang('core button enter_username'), 'maxlength'=>256)); ?>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"><?php echo lang('core button password'); ?></label>
            <?php echo form_password(array('name'=>'password', 'id'=>'password', 'class'=>'form-control', 'placeholder'=>lang('core button enter_password'), 'maxlength'=>72, 'autocomplete'=>'off')); ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="g-recaptcha" data-sitekey="<?php echo $this->settings->google_site_key; ?>"></div>
            </div>
            <div class="col-md-6">
              <a href="<?php echo base_url('user/forgot'); ?>"><?php echo lang('core button forgot'); ?></a></br>
              <a href="<?php echo base_url('user/register'); ?>"><?php echo lang('core button create'); ?></a>
            </div>

            <div class="col-md-6 text-right">
              <button type="submit" class="btn btn-success"><?php echo lang('core button login'); ?></button>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
</div>
