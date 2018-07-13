<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users vouchers ac'); ?></h5>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php echo form_open(site_url("account/vouchers/start_activate_code"), array("" => "")) ?>
    <div class="row">
      <div class="form-group col-md-12">
         <label for="title"><?php echo lang('users vouchers code_v'); ?></label>
         <input type="text" class="form-control" name="code">
      </div>
      <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users vouchers now'); ?></button>
      </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>