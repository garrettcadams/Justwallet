<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users vouchers all'); ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="<?php echo base_url('account/vouchers/activate_code'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-key icons"></i> <?php echo lang('users vouchers ac'); ?></a>
      <a href="<?php echo base_url('account/vouchers/new_voucher'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-plus icons"></i> <?php echo lang('users vouchers new'); ?></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover table-responsive-lg">
          <thead>
            <th><?php echo lang('users vouchers date_created'); ?></th>
            <th><?php echo lang('users vouchers code'); ?></th>
            <th><?php echo lang('users trans amount'); ?></th>
            <th><?php echo lang('users disputes status'); ?></th>
          </thead>
          <tbody>
            <?php if ($total) : ?>
              <?php foreach ($vouchers as $view) : ?>
              <tr>

                <td><?php echo $view['date_creature']; ?></td>
                <td><?php echo $view['code']; ?></td>
                <td><?php echo $view['amount']; ?> <?if($view['currency']=='debit_base'){?>
                                  <?php echo $this->currencys->display->base_code ?>
                              <?}else{?>
                              <?}?>
                              <?if($view['currency']=='debit_extra1'){?>
                                  <?php echo $this->currencys->display->extra1_code ?>
                              <?}else{?>
                              <?}?>
                              <?if($view['currency']=='debit_extra2'){?>
                                  <?php echo $this->currencys->display->extra2_code ?>
                              <?}else{?>
                              <?}?>
                              <?if($view['currency']=='debit_extra3'){?>
                                  <?php echo $this->currencys->display->extra3_code ?>
                              <?}else{?>
                              <?}?>
                              <?if($view['currency']=='debit_extra4'){?>
                                  <?php echo $this->currencys->display->extra4_code ?>
                              <?}else{?>
                              <?}?>
                              <?if($view['currency']=='debit_extra5'){?>
                                  <?php echo $this->currencys->display->extra5_code ?>
                              <?}else{?>
                              <?}?></td>
                <td>
                  <?if($view['status']==1){?>
                                <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
                              <?}else{?>
                              <?}?>
                              <?if($view['status']==2){?>
                                <span class="badge badge-success"> <?php echo lang('users vouchers activated'); ?> </span>
                              <?}else{?>
                              <?}?>
                              <?if($view['status']==3){?>
                                <span class="badge badge-secondary"> <?php echo lang('users trans blocked'); ?> </span>
                              <?}else{?>
                              <?}?>

                </td>

              </tr>

            <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="4">
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
      <div class="row">
        <div class="col-md-3 text-left">
            <small><?php echo lang('users vouchers total'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>