<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users deposit deposit_bank'); ?></h5>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php echo lang('users deposit deposit_bank_info'); ?> <strong><?php echo $id_transaction ?></strong>.
      </div>
    </div>
  </div>
</div>

<div class="card mt-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <strong><label for="swift"><?php echo lang('users deposit deposit_bank_detail'); ?></label></strong>
          <textarea class="form-control" id="swift" rows="8" disabled><?php echo $merchant_account ?></textarea>
        </div>
      </div>
      <div class="col-md-12 text-right">
        <a href="<?php echo base_url('account/transactions'); ?>" class="btn btn-success"><?php echo lang('users title history'); ?></a>
      </div>
    </div>
  </div>
</div>