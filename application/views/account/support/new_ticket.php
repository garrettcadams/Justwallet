<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users support create_ticket'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/support/add_ticket/"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-12">
            <label for="title"><?php echo lang('users support title'); ?></label>
            <input type="text" class="form-control <?php echo form_error('title') ? ' is-invalid' : ''; ?>" name="title" id="title">
       </div>
        <div class="form-group col-md-12">
            <label for="title"><?php echo lang('users support message'); ?></label>
            <textarea class="form-control" id="comment" name="comment" rows="8"></textarea>
       </div>
       <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
       </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>