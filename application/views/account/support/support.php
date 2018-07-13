<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users support open_tickets'); ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <a href="<?php echo base_url('account/support/new_ticket'); ?>" class="btn btn-success btn-sm"><i class="icon-plus icons"></i> <?php echo lang('users support new_ticket'); ?></a>
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
              <th scope="col"><?php echo lang('users support title'); ?></th>
              <th scope="col"><?php echo lang('users support status'); ?></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php if ($total) : ?>
              <?php foreach ($ticket as $view) : ?>
              <tr>
                <td><?php echo $view['code']; ?></td>
                <td><?php echo $view['date']; ?></td>
                <td><?php echo $view['title']; ?></td>
                <td>
                   <?if($view['status']==1){?>
                    <span class="badge badge-warning"><?php echo lang('users tickets untreated'); ?></span>
                   <?}else{?>
                   <?}?>
                   <?if($view['status']==0){?>
                    <span class="badge badge-success"><?php echo lang('users tickets processed'); ?></span>
                   <?}else{?>
                   <?}?>
                   <?if($view['status']==2){?>
                    <span class="badge badge-danger"><?php echo lang('users tickets closed'); ?></span>
                   <?}else{?>
                   <?}?></td>
                <td><a href="<?php echo base_url('account/support/detail_ticket'); ?>/<?php echo $view['code']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-eye icons"></i></a></td>
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