<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script >
(function($) {
  $(function() {
    var argument = $('input[name="amount"]')
      , result = $('input[name="sum"]')
      , multiplier = <?php echo $fee; ?>;
    argument.on('input', function() {
      result.val($(this).val() * multiplier);
    });
  });
})(jQuery);;
</script>
<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users title form_transfer'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/money_transfer/start_transfer/"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      
      <div class="form-group col-md-5">
            <label for="title"><?php echo lang('users transfer amount'); ?></label>
            <input type="text" class="form-control <?php echo form_error('title') ? ' is-invalid' : ''; ?>" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
       </div>
       <div class="form-group col-md-2">
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
       <div class="form-group col-md-5">
             <label><?php echo lang('users transfer sum'); ?>, <?php echo $percent; ?>%</label>
             <input type="text" class="form-control" name="sum" disabled>
       </div>
      <div class="form-group col-md-10">
             <label><?php echo lang('users transfer user_mail'); ?></label>
             <input type="text" class="form-control" name="receiver">
       </div>
      <div class="form-group col-md-2">
        <button type="button" data-toggle="collapse" data-target="#protect" aria-expanded="false" aria-controls="protect" class="btn btn-outline-secondary btn-block margin-t-transfer"><?php echo lang('users transfer protect'); ?></button>
      </div>
      <div class="collapse" id="protect">
        <div class="col-md-12">
          <div class="card text-white bg-danger card-body">
             <label><?php echo lang('users transfer code_protect'); ?></label>
             <input type="text" class="form-control" name="code_protect" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="1234" maxlength="4">
             <small class="form-text text-white"><?php echo lang('users transfer info_protect'); ?></small>
          </div>
        </div>
        
      </div>
      
      <div class="form-group col-md-12">
             <label><?php echo lang('users reqest note'); ?></label>
             <textarea class="form-control" rows="5" name="note"></textarea>
       </div>
      
       <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users transfer send'); ?></button>
       </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>