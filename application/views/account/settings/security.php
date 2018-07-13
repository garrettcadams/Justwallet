<div class="row">
  <div class="col-md-4 mb-2">
    <h5><?php echo lang('users security title'); ?></h5>
  </div>
  <div class="col-md-8 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?php echo base_url('account/settings/logs'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-lock icons"></i> <?php echo lang('users settings logs'); ?></a>
      <a href="<?php echo base_url('account/settings/verification'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-user-following icons"></i> <?php echo lang('users settings verify'); ?></a>
      <a href="<?php echo base_url('account/settings/billing'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-wallet icons"></i> <?php echo lang('users settings billing'); ?></a>
      <a href="<?php echo base_url('account/settings/security'); ?>" class="btn btn-outline-secondary btn-sm active"><i class="icon-shield icons"></i> <?php echo lang('users security title'); ?></a>
    </div>
  </div>
</div>
<?php echo form_open(site_url("account/settings/update_security/"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
          <div class="col-md-12">
            <fieldset>
              <div class="plan-card-group">
                 <div class="radio-card">
                    <input type="radio" class="planes-radio" name="method" value="1" id="none" <?if($user['method_login'] == 1){?>checked<?}else{?><?}?>/>
                    <label for="none" id="radio-label1">
                     <div class="row">
                        <div class="col-md-1 mt-3 mb-3 text-center">
                          <img src="<?php echo base_url();?>assets/themes/account/img/icon/no.png" class="win-img">
                        </div>
                         <div class="col-md-8 mt-12px mb-3">
                          <h5 class="mb-0">
                            <?php echo lang('users security 1'); ?>
                          </h5>
                          <small class="text-muted"><?php echo lang('users security 1_info'); ?></small>
                        </div>
                     </div>
                   </label>
                </div>
                <div class="radio-card">
                    <input type="radio" class="planes-radio" name="method" value="2" id="google" <?if($user['method_login'] == 2){?>checked<?}else{?><?}?>/>
                    <label for="google" id="radio-label2">
                     <div class="row">
                        <div class="col-md-1 mt-3 mb-3 text-center">
                          <img src="<?php echo base_url();?>assets/themes/account/img/icon/qr.png" class="win-img">
                        </div>
                        <div class="col-md-8 mt-12px mb-3">
                          <h5 class="mb-0">
                            <?php echo lang('users security 2'); ?>
                          </h5>
                          <small class="text-muted"><?php echo lang('users security 2_info'); ?></small>
                        </div>
                         <div class="col-md-3 mt-settings mb-2 text-right">
                            <?if($user['2fa_login'] == NULL){?><a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" class="btn btn-muted"><i class="icon-settings icons text-muted h4"></i></a><?}else{?><?}?>
                         </div>
                     </div>
                   </label>
                </div>
                <div class="radio-card">
                    <input type="radio" class="planes-radio" name="method" value="3" id="sms" <?if($user['method_login'] == 3){?>checked<?}else{?><?}?>/>
                    <label for="sms" id="radio-label3">
                     <div class="row">
                        <div class="col-md-1 mt-3 mb-3 text-center">
                          <img src="<?php echo base_url();?>assets/themes/account/img/icon/sms.png" class="win-img">
                        </div>
                         <div class="col-md-8 mt-12px mb-3">
                          <h5 class="mb-0">
                            <?php echo lang('users security 3'); ?>
                          </h5>
                          <small class="text-muted"><?php echo lang('users security 3_info'); ?></small>
                        </div>
                     </div>
                   </label>
                </div>
                <div class="radio-card">
                    <input type="radio" class="planes-radio" name="method" value="4" id="email" <?if($user['method_login'] == 4){?>checked<?}else{?><?}?>/>
                    <label for="email" id="radio-label4">
                     <div class="row">
                        <div class="col-md-1 mt-3 mb-3 text-center">
                          <img src="<?php echo base_url();?>assets/themes/account/img/icon/email.png" class="win-img">
                        </div>
                         <div class="col-md-8 mt-12px mb-3">
                          <h5 class="mb-0">
                            <?php echo lang('users security 4'); ?>
                          </h5>
                          <small class="text-muted"><?php echo lang('users security 4_info'); ?></small>
                        </div>
                     </div>
                   </label>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-md-12 text-right mt-2">
             <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
          </div>
        </div>
        <?php echo form_close(); ?> 
      </div>
      <?if($user['2fa_login'] == NULL){?>
      <div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <?php echo form_open(site_url("account/settings/update_2fa/"), array("" => "")) ?>
        <div class="row">
          <div class="col-md-3">
            <img src="<?php echo $qrCodeUrl; ?>" class="w-100">
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label><?php echo lang('users security enter_otp'); ?></label>
              <input type="text" class="form-control" id="code" name="code" placeholder="123456">
            </div>
          </div>
          <input type="hidden" name="secret" value="<?php echo $secret; ?>">
          <div class="col-md-12 text-right mt-2">
             <a id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true" class="btn btn-light"><?php echo lang('users button back'); ?></a>
             <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
          </div>
        </div>
        <?php echo form_close(); ?> 
      </div>
      <?}else{?><?}?>
    </div>
  </div>
</div>