<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo $ticket['title'] ?></h5>
  </div>
  <?php if ($ticket['status'] != 2) : ?>
  <div class="col-md-4 mb-2 text-right">
      <a href="<?php echo $this_url; ?>/close_ticket/<?php echo $ticket['code']; ?>" class="btn btn-danger btn-sm"><i class="icon-close icons"></i> <?php echo lang('users support close'); ?></a>
  </div>
  <?php endif; ?>
  <?php if ($ticket['status'] == 2) : ?>
  <div class="col-md-4 mb-2 text-right">
      <a href="<?php echo $this_url; ?>/reopen_ticket/<?php echo $ticket['code']; ?>" class="btn btn-success btn-sm"> <?php echo lang('users ticket reopen_ticket'); ?></a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <?php if ($ticket['message'] != NULL) : ?>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <?php echo $ticket['message'] ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
     
      <?php foreach($log_comment->result() as $view) : ?>
      <div class="col-md-12 mt-3">
        <div class="card">
          <div class="card-header">
            <?php echo $view->user ?>
          </div>
          <div class="card-body">
            <p class="card-text"><?php echo $view->comment ?></p>
            <p class="card-text"><small class="text-muted"><?php echo lang('users button update'); ?> <?php echo $view->date ?></small></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if ($ticket['status'] != 2) : ?>
      <div class="col-md-12 mt-4">
        <?php echo form_open(site_url("account/support/add_user_comment/" . $ticket['code']), array("" => "")) ?>
         <div class="form-group">
          <label><?php echo lang('users tickets new_comment'); ?></label>
          <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
         </div>
        
        
      </div>
      <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
          </div>
      <?php endif; ?>
      <?php echo form_close(); ?>  
    </div>
  </div>
</div>