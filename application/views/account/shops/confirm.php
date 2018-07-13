<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users shops confirm'); ?></h5>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans amount'); ?></strong></label>
        <p class="form-control-static"><?php echo $amount; ?> <?php echo $symbol; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans fee'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_fee; ?>  <?php echo $symbol; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users trans sum'); ?></strong></label>
        <p class="form-control-static"><?php echo $total_amount; ?>  <?php echo $symbol; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo lang('users shops name'); ?></strong></label>
        <p class="form-control-static"><?php echo $merchant['name']; ?></p>
      </div>
      <div class="form-group col-md-4">
        <label for="date"><strong><?php echo $merchant['note_payment']; ?></strong></label>
        <p class="form-control-static"><?php echo $id_payment; ?></p>
      </div>
      <div class="col-md-12 text-right">
        <?php echo form_open(site_url("account/shops/start_payment"), array("" => "")) ?>
           <input type="hidden" name="amount" value="<?php echo $amount; ?>">
           <input type="hidden" name="currency" value="<?php echo $currency?>">
           <input type="hidden" name="merchant" value="<?php echo $merchant['id']?>">
            <input type="hidden" name="id_payment" value="<?php echo $id_payment?>">
           <button type="submit" class="btn btn-success"><?php echo lang('users shops confirm_pay'); ?></button>
          <?php echo form_close(); ?> 
      </div>
    </div>
  </div>
</div>