<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users vouchers new_v'); ?></h5>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php echo form_open(site_url("account/vouchers/start_new_voucher"), array("" => "")) ?>
    <div class="row">
      <div class="form-group col-md-9">
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
          <button type="submit" class="btn btn-success"><?php echo lang('users vouchers create_v'); ?></button>
       </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>