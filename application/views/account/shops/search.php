<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users shops search_result'); ?></h5>
  </div>
</div>

<div class="row">
  <?php if ($total) : ?>
  <?php foreach ($shops as $view) : ?>
  <div class="col-md-12 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-1 text-center mt-2 mb-2">
                <img src="<?php echo base_url();?>upload/logo/<?php echo $view['logo']; ?>" class="win-img">
              </div>
              <div class="col-md-9 mb-2">
                <strong><?php echo $view['name']; ?></strong></br>
                <small class="text-muted"><?php echo $view['comment']; ?></small></br>
                <small><a href="<?php echo $view['link']; ?>" target="_blank"><?php echo $view['link']; ?></a></small>
              </div>
              <div class="col-md-2 mb-2 mt-2rem">
                <a href="<?php echo base_url();?>account/shops/payment/<?php echo $view['id']; ?>" class="btn btn-outline-success btn-block"><?php echo lang('users invoices pay'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php endforeach; ?>
  <?php else : ?>
        
  <div class="col-md-12 mb-3">
         
  <?php echo lang('core error no_results'); ?>
  <?php endif; ?>
</div>
</div>