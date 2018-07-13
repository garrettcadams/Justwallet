<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
         <?php echo lang('admin tickets ticket'); ?>
      </div>
      <div class="card-body">
        <?php echo form_open(site_url("admin/support/add_ticket"), array("" => "")) ?>
        <div class="row">
          <div class="col-md-12">
             <div class="form-group"> 
                <label><?php echo lang('admin tickets user'); ?></label>
                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="<?php echo lang('admin tickets user'); ?>"> 
             </div>
          </div>
          <div class="col-md-12">
             <div class="form-group"> 
                <label><?php echo lang('admin tickets title'); ?></label>
                <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="<?php echo lang('admin tickets title'); ?>">  
             </div>
          </div>
          <div class="col-md-12">
             <div class="form-group"> 
                <label><?php echo lang('admin tickets message'); ?></label>
                <textarea class="form-control underlined" rows="12" id="message" name="message" placeholder="<?php echo lang('admin tickets message'); ?>"></textarea>
              <script>
                CKEDITOR.replace( 'message', { height:['200px'] } );
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.replace('body', {height: 200});
              </script>  
             </div>
          </div>
          <div class="col-md-12 -text-right">
              <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admin tickets create'); ?></button>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>