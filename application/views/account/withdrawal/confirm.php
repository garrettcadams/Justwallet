<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users withdrawal confirm_start'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/withdrawal/start_withdrawal"), array("" => "")) ?>
<?php echo form_hidden('amount', $amount); ?>
<?php echo form_hidden('method', $code_method); ?>
<?php echo form_hidden('currency', $currency); ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?if($user[$currency] >= $total_amount){?>
        <?}else{?>
        <div class="alert alert-danger" role="alert">
          <?php echo lang('users withdrawal error_2'); ?>
        </div>
        <?}?>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans amount'); ?></strong></label>
        <p class="form-control-static"><?php echo $amount; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans fee'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_fee; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans sum'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_amount; ?> 
          <?if($currency=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($currency=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users withdrawal method'); ?></strong></label>
        <p class="form-control-static"><?php echo $method; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users withdrawal method_account'); ?></strong></label>
        <p class="form-control-static"><?php echo $account; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users withdrawal terms'); ?></strong></label>
        <p class="form-control-static"><?php echo $terms; ?></p>
      </div>
      <div class="col-md-12 text-right">
         <a href="<?php echo base_url('account/withdrawal'); ?>" class="btn btn-outline-secondary"><?php echo lang('users withdrawal cancel'); ?></a>
         <?if($user[$currency] >= $total_amount){?>
        <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
         <?}else{?>
         <?}?>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 