<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users deposit deposit_blockchain'); ?></h5>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <img class="w-100" src="<?php echo $qr_img; ?>">
      </div>
      <div class="col-md-9">
        <h6 class="mt-3"><?php echo lang('users merchants btc_address'); ?>: <?php echo $forwarding_address; ?></h6>
        <p><?php echo lang('users merchants btc_order'); ?> <?php echo $btc_value; ?> BTC. <?php echo lang('users merchants btc_total'); ?> <?php echo $amount; ?> <?php echo $symbol; ?> <?php echo lang('users merchants btc_completed'); ?>. <?php echo lang('users deposit deposit_blockchain_in'); ?></p>
      </div>
    </div>
  </div>
</div>