<div class="row">
  <div class="col-md-4 mb-2">
    <h5><?php echo lang('users settings verify'); ?></h5>
  </div>
  <div class="col-md-8 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?php echo base_url('account/settings/logs'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-lock icons"></i> <?php echo lang('users settings logs'); ?></a>
      <a href="<?php echo base_url('account/settings/verification'); ?>" class="btn btn-outline-secondary btn-sm  active"><i class="icon-user-following icons"></i> <?php echo lang('users settings verify'); ?></a>
      <a href="<?php echo base_url('account/settings/billing'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-wallet icons"></i> <?php echo lang('users settings billing'); ?></a>
      <a href="<?php echo base_url('account/settings/security'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-shield icons"></i> <?php echo lang('users security title'); ?></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-10">
        <h6 <?php if ($user['verify_status'] != 0) : ?>class="text-muted"<?php endif; ?>><?php echo lang('users settings standart_ver'); ?></h6>
        <?php if ($user['verify_status'] == 0) : ?>
        <p><?php echo lang('users settings standart_desc'); ?></p>
        <?php endif; ?>
        <?php if ($user['verify_status'] != 0) : ?>
        <p class="text-muted"><?php echo lang('users settings ok_status'); ?></p>
        <?php endif; ?>
      </div>
      <div class="col-md-2">
        <?php if ($user['verify_status'] != 0) : ?>
        <h1 class="text-success mt-3 text-center"><i class="icon-check icons"></i></h1>
        <?php endif; ?>
      </div>
      <?php if ($user['verify_status'] == 0) : ?>
      <?php echo form_open(site_url("account/settings/standart_verification/"), array("" => "")) ?>
      <div class="col-md-12 mt-3">
             <div class="row">
              <div class="form-group col-md-6">
                <label for="company"><?php echo lang('users settings company'); ?></label>
                <input type="text" class="form-control <?php echo form_error('users settings company') ? ' is-invalid' : ''; ?>" name="company" id="company" value="<?php echo $user['company']; ?>">
              </div>
              <div class="form-group col-md-6">
                <label for="country"><?php echo lang('users settings country'); ?>*</label>
                <input type="text" class="form-control <?php echo form_error('users settings country') ? ' is-invalid' : ''; ?>" name="country" id="country" value="<?php echo $user['country']; ?>">
              </div>
               <div class="form-group col-md-6">
                <label for="zip"><?php echo lang('users settings zip'); ?>*</label>
                <input type="text" class="form-control <?php echo form_error('users settings zip') ? ' is-invalid' : ''; ?>" name="zip" id="zip" value="<?php echo $user['zip']; ?>">
              </div>
               <div class="form-group col-md-6">
                <label for="city"><?php echo lang('users settings city'); ?>*</label>
                <input type="text" class="form-control <?php echo form_error('users settings city') ? ' is-invalid' : ''; ?>" name="city" id="city" value="<?php echo $user['city']; ?>">
              </div>
               <div class="form-group col-md-12">
                <label for="city"><?php echo lang('users settings address_1'); ?>*</label>
                <input type="text" class="form-control <?php echo form_error('users settings address_1') ? ' is-invalid' : ''; ?>" name="address_1" id="address_1" value="<?php echo $user['address_1']; ?>">
              </div>
               <div class="form-group col-md-6">
                <label for="city"><?php echo lang('users settings address_2'); ?></label>
                <input type="text" class="form-control <?php echo form_error('users settings address_2') ? ' is-invalid' : ''; ?>" name="address_2" id="address_2" value="<?php echo $user['address_2']; ?>">
              </div>
               <div class="form-group col-md-6">
                <label for="country"><?php echo lang('users input phone'); ?>*</label>
                <input type="text" class="form-control <?php echo form_error('users input phone') ? ' is-invalid' : ''; ?>" name="phone" id="phone" value="<?php echo $user['phone']; ?>">
              </div>
               <div class="col-md-10">
                 <p class="text-muted"><small><?php echo lang('users settings info'); ?></small></p>
              </div>
               
               <div class="col-md-2 text-right">
                  <button type="submit" class="btn btn-success mt-1"><?php echo lang('users button save'); ?></button>
              </div>
            </div>
      </div>
      <?php echo form_close(); ?> 
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="card mt-3">
  <div class="card-body">
     <div class="row">
      <div class="col-md-10">
        <h6 <?php if ($user['verify_status'] == 2) : ?>class="text-muted"<?php endif; ?>><?php echo lang('users settings extend_ver'); ?></h6>
        <?php if ($user['verify_status'] == 0) : ?>
        <p><?php echo lang('users settings affter_status'); ?></p>
        <?php endif; ?>
        <?php if ($user['verify_status'] == 1) : ?>
        <p><?php echo lang('users settings extend_desc'); ?></p>
        <?php endif; ?>
        <?php if ($user['verify_status'] == 2) : ?>
        <p class="text-muted"><?php echo lang('users settings ok_status'); ?></p>
        <?php endif; ?>
      </div>
       <div class="col-md-2">
         <?php if ($user['verify_status'] == 0) : ?>
        <h1 class="text-danger mt-3 text-center"><i class="icon-close icons"></i></h1>
        <?php endif; ?>
        <?php if ($user['verify_status'] == 2) : ?>
        <h1 class="text-success mt-3 text-center"><i class="icon-check icons"></i></h1>
        <?php endif; ?>
        <?php if ($check_request == 1 && $user['verify_status'] == 1) : ?>
        <h1 class="text-warning mt-3 text-center"><i class="icon-clock icons"></i></h1>
        <?php endif; ?>
      </div>
       <?php if ($user['verify_status'] != 2 && $user['verify_status'] == 1 && $check_request == 0) : ?>
       <?php echo form_open_multipart(site_url("account/settings/extended_verification/"), array("" => "")) ?>
       <div class="col-md-12 mt-3">
           <div class="row">
             <div class="form-group col-md-12">
                <label for="id_card"><?php echo lang('users settings id_card'); ?>*</label>
                <input type="file" class="form-control-file" id="id_card" name="id_card">
                <small id="id_card" class="form-text text-muted">
                 <?php echo lang('users settings id_card_info'); ?>
                </small>
              </div>
              <div class="form-group col-md-12">
                <label for="id_card"><?php echo lang('users settings id_address'); ?>*</label>
                <input type="file" class="form-control-file" id="id_address" name="id_address">
                <small id="id_address" class="form-text text-muted">
                 <?php echo lang('users settings id_address_info'); ?>
                </small>
              </div>
             <div class="col-md-10">
                 <p class="text-muted"><small><?php echo lang('users settings info'); ?></small></p>
              </div>
               
               <div class="col-md-2 text-right">
                  <button type="submit" class="btn btn-success mt-1"><?php echo lang('users button save'); ?></button>
              </div>
           </div>
       </div>
       <?php echo form_close(); ?>
       <?php endif; ?>
     </div>
  </div>
</div>