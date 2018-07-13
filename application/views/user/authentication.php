<div class="header-st mb-4">
			<div class="container">
				<div class="row">
          <div class="col-md-12">
            <h3>
              <?php echo lang('users security authentication') ?>
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
          <?php echo form_open(site_url("user/start_authentication/"), array("" => "")) ?>
          <div class="form-group">
              <?if($user['method_login'] == 2){?>
              <label for="exampleInputEmail1"><?php echo lang('users security enter_token_otp'); ?></label>
              <?}else{?><?}?>
              <?if($user['method_login'] == 3){?>
              <label for="exampleInputEmail1"><?php echo lang('users security enter_token_sms'); ?></label>
              <?}else{?><?}?>
              <?if($user['method_login'] == 4){?>
              <label for="exampleInputEmail1"><?php echo lang('users security enter_token_email'); ?></label>
              <?}else{?><?}?>
              <?php echo form_input(array('name'=>'code', 'class'=>'form-control', 'type'=>'text')); ?>
              <?if($user['method_login'] != 2){?>
              <small class="form-text text-muted"><a href="<?php echo base_url('user/authentication'); ?>"><?php echo lang('users security enter_token_resend'); ?></a></small>
              <?}else{?><?}?>
            </div>
          <div class="row">
              <div class="col-md-12  text-right">
                <a href="<?php echo base_url('logout'); ?>" class="btn btn-light"><?php echo lang('core button logout'); ?></a>
                <button type="submit" class="btn btn-success"><?php echo lang('users security confirm'); ?></button>
              </div>
            </div>
          <?php echo form_close(); ?> 
        </div>
      </div>
    </div>
  </div>
</div>