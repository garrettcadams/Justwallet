<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users title form_exchange'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/exchange/calculation"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-8">
            <label><?php echo lang('users exchange amount'); ?>, <?php echo $this->currencys->display->base_code ?></label>
            <input type="text" class="form-control" name="amount" id="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users trans cyr'); ?></label>
                  <select class="form-control" name="currency">
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
       <div class="col-md-12 text-right mt-3">
          <button type="submit" class="btn btn-success"><?php echo lang('users exchange check_calc'); ?></button>
       </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 

<div class="row">
  <div class="col-md-12 mt-3 mb-2">
    <h5><?php echo lang('users title to_form_exchange'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/exchange/calculation_to"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-8">
            <label><?php echo lang('users exchange amount'); ?></label>
            <input type="text" class="form-control" name="amount" id="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users trans cyr'); ?></label>
                  <select class="form-control" name="currency">
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
       <div class="col-md-12 text-right mt-3">
          <button type="submit" class="btn btn-success"><?php echo lang('users exchange check_calc'); ?></button>
       </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 