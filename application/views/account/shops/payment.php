<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo $merchant['name']; ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <?if($merchant['payeer_fee'] == "1"){?>
    <h5><i class="icon-info icons"></i> <?php echo lang('users trans fee'); ?>: <?php echo $merchant['fee']; ?> + <?php echo $merchant['fix_fee']; ?></h5>
    <?}else{?>
     <h5 class="text-success"><i class="icon-info icons"></i> <?php echo lang('users shops no_fee'); ?></h5>
    <?}?>
  </div>
</div>
<?php echo form_open(site_url("account/shops/confirm/"), array("" => "")) ?>
<input type="hidden" class="form-control" name="merchant" id="exampleInputEmail1" value="<?php echo $merchant['id']; ?>">
<div class="row">
  <div class="col-md-12 mb-3">
      <div class="card">
         <div class="card-body">
           <div class="row">
             <div class="form-group col-md-6">
              <label for="exampleInputEmail1"><?php echo $merchant['note_payment']; ?></label>
              <input type="text" class="form-control" name="id_payment" id="exampleInputEmail1">
            </div>
             <div class="form-group col-md-3">
                <label for="title"><?php echo lang('users transfer amount'); ?></label>
                <input type="text" class="form-control <?php echo form_error('title') ? ' is-invalid' : ''; ?>" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
             </div>
             <div class="form-group col-md-3">
            <label><?php echo lang('users trans cyr'); ?></label>
                  <select class="form-control" name="currency">
                    <option value="debit_base">
                    <?php echo $this->currencys->display->base_code ?>
                    </option>
                    <?php if($this->currencys->display->extra1_check) : ?>
                    <option value="debit_extra1">
                    <?php echo $this->currencys->display->extra1_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra2_check) : ?>
                    <option value="debit_extra2">
                    <?php echo $this->currencys->display->extra2_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra3_check) : ?>
                    <option value="debit_extra3">
                    <?php echo $this->currencys->display->extra3_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra4_check) : ?>
                    <option value="debit_extra4">
                    <?php echo $this->currencys->display->extra4_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra5_check) : ?>
                    <option value="debit_extra5">
                    <?php echo $this->currencys->display->extra5_code ?>
                    </option>
                    <?php endif; ?>
                  </select>
             </div>
             <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success"><?php echo lang('users deposit payment'); ?></button>
             </div>
           </div>
        </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 