<div class="row">
  <div class="col-md-4 mb-2">
    <h5><?php echo lang('users settings history'); ?></h5>
  </div>
  <div class="col-md-8 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?php echo base_url('account/settings/logs'); ?>" class="btn btn-outline-secondary btn-sm active"><i class="icon-lock icons"></i> <?php echo lang('users settings logs'); ?></a>
      <a href="<?php echo base_url('account/settings/verification'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-user-following icons"></i> <?php echo lang('users settings verify'); ?></a>
      <a href="<?php echo base_url('account/settings/billing'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-wallet icons"></i> <?php echo lang('users settings billing'); ?></a>
      <a href="<?php echo base_url('account/settings/security'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-shield icons"></i> <?php echo lang('users security title'); ?></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover table-responsive-lg">
          <thead>
            <tr>
              <th scope="col"><?php echo lang('users support code'); ?></th>
              <th scope="col"><?php echo lang('users support date'); ?></th>
              <th scope="col"><?php echo lang('users settings type'); ?></th>
              <th scope="col"><?php echo lang('users settings ip'); ?></th>
            </tr>
          </thead>
          <tbody>
           <?php if ($total) : ?>
              <?php foreach ($logs as $view) : ?>
              <tr>
                <td><?php echo $view['code']; ?></td>
                <td><?php echo $view['date']; ?></td>
                <td>
                  <?php if ($view['type'] == 1) : ?>
                  <?php echo lang('users events_status 1'); ?>
                  <?php elseif ($view['type'] == 2) : ?>
                  <?php echo lang('users events_status 2'); ?>
                  <?php elseif ($view['type'] == 3) : ?>
                  <?php echo lang('users events_status 3'); ?>
                  <?php elseif ($view['type'] == 4) : ?>
                  <?php echo lang('users events_status 4'); ?>
                  <?php elseif ($view['type'] == 5) : ?>
                  <?php echo lang('users events_status 5'); ?>
                  <?php elseif ($view['type'] == 6) : ?>
                  
                  <?php endif; ?>
                </td>
                <td><?php echo $view['ip']; ?></td>
              </tr>

            <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="5">
                          <?php echo lang('core error no_results'); ?>
                      </td>
                  </tr>
              <?php endif; ?>
          </tbody>
        </table>
        
      </div>
    </div>
  </div>
  <div class="card-footer text-right">
          <?php echo $pagination; ?>
        </div>
</div>