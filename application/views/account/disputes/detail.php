<div class="row">
  <div class="col-md-9 mb-2">
    <h5>ID <?php echo $dispute['id'] ?> : <?if($dispute['title'] == 1){?>
      <?php echo lang('users history not_received'); ?>
      <?}else{?>
      <?}?><?if($dispute['title'] == 2){?>
        <?php echo lang('users history not_desk'); ?>
      <?}else{?>
      <?}?>
    </h5>
  </div>
  <div class="col-md-3 mb-2 text-right">
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo lang('users dispute action'); ?>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if($dispute['status'] == 1) : ?>
        <a class="dropdown-item" href="<?php echo base_url();?>account/disputes/open_claim/<?php echo $dispute['id']; ?>"><?php echo lang('users dispute start_claim'); ?></a>
        <?php endif; ?>
        <?php if($dispute['status'] == 1 && $dispute['claimant'] == $user['username']) : ?>
        <a class="dropdown-item" href="<?php echo base_url();?>account/disputes/cancel_claim/<?php echo $dispute['id']; ?>"><?php echo lang('users dispute close_claim'); ?></a>
        <?php endif; ?>
        <?php if($dispute['status'] == 2 && $dispute['claimant'] == $user['username']) : ?>
        <a class="dropdown-item" href="<?php echo base_url();?>account/disputes/cancel_claim/<?php echo $dispute['id']; ?>"><?php echo lang('users dispute close_claim'); ?></a>
        <?php endif; ?>
        <?php if($dispute['status'] != 3 && $dispute['status'] != 4 && $dispute['defendant'] == $user['username']) : ?>
        <a class="dropdown-item" href="<?php echo base_url();?>account/disputes/refund/<?php echo $dispute['id']; ?>"><?php echo lang('users orders make'); ?></a>
        <?php endif; ?>
        <a class="dropdown-item" href="<?php echo base_url('account/disputes'); ?>"><?php echo lang('users disputes back'); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes status'); ?></label>
              <p class="form-control-static"><?if($dispute['status'] == 1){?>
                <span class="badge badge-primary"><?php echo lang('users disputes open'); ?></span>
                <?}else{?>
                <?}?>
                <?if($dispute['status'] == 2){?>
                <span class="badge badge-danger"><?php echo lang('users disputes claim'); ?></span>
                <?}else{?>
                <?}?>
                <?if($dispute['status'] == 3){?>
                <span class="badge badge-warning"><?php echo lang('users disputes rejected'); ?></span>
                <?}else{?>
                <?}?>
                <?if($dispute['status'] == 4){?>
                <span class="badge badge-success"><?php echo lang('users disputes satisfied'); ?></span>
                <?}else{?>
                <?}?>
              </p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes id_tran'); ?></label>
        <p class="form-control-static"><?php echo $dispute['transaction'] ?></p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes id_tran_time'); ?></label>
        <p class="form-control-static"><?php echo $dispute['time_transaction'] ?></p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes time_dispute'); ?></label>
        <p class="form-control-static"><?php echo $dispute['time_dispute'] ?></p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes claimant'); ?></label>
        <p class="form-control-static"><?php echo $dispute['claimant'] ?></p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users disputes defendant'); ?></label>
         <p class="form-control-static"><?php echo $dispute['defendant'] ?></p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users trans amount'); ?></label>
              <p class="form-control-static"><?php echo $dispute['amount'] ?> <?if($dispute['currency']=='debit_base'){?>
                <?php echo $this->currencys->display->base_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency']=='debit_extra1'){?>
                  <?php echo $this->currencys->display->extra1_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency']=='debit_extra2'){?>
                  <?php echo $this->currencys->display->extra2_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency']=='debit_extra3'){?>
                  <?php echo $this->currencys->display->extra3_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency']=='debit_extra4'){?>
                  <?php echo $this->currencys->display->extra4_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency']=='debit_extra5'){?>
                  <?php echo $this->currencys->display->extra5_code ?>
                <?}else{?>
                <?}?>
              </p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users trans fee'); ?></label>
              <p class="form-control-static"><?php echo $dispute['fee'] ?> <?if($dispute['currency']=='debit_base'){?>
                <?php echo $this->currencys->display->base_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra1'){?>
                  <?php echo $this->currencys->display->extra1_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra2'){?>
                  <?php echo $this->currencys->display->extra2_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra3'){?>
                  <?php echo $this->currencys->display->extra3_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra4'){?>
                  <?php echo $this->currencys->display->extra4_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra5'){?>
                  <?php echo $this->currencys->display->extra5_code ?>
                <?}else{?>
                <?}?>
              </p>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo lang('users trans sum'); ?></label>
              <p class="form-control-static"><?php echo $dispute['sum'] ?> <?if($dispute['currency'] == 'debit_base'){?>
                <?php echo $this->currencys->display->base_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra1'){?>
                  <?php echo $this->currencys->display->extra1_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra2'){?>
                  <?php echo $this->currencys->display->extra2_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra3'){?>
                  <?php echo $this->currencys->display->extra3_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra4'){?>
                  <?php echo $this->currencys->display->extra4_code ?>
                <?}else{?>
                <?}?>
                <?if($dispute['currency'] == 'debit_extra5'){?>
                  <?php echo $this->currencys->display->extra5_code ?>
                <?}else{?>
                <?}?>
              </p>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-12 mt-3">
    <ol class="progress_1">
      <li class="<?if($dispute['status'] == 1){?>is-active<?}else{?>is-complete<?}?>" data-step="1">
        <?php echo lang('users dispute step_1'); ?>
      </li>
      <li class="<?if($dispute['status'] == 2){?>is-active<?}else{?><?}?><?if($dispute['status'] == 3){?>is-complete<?}else{?><?}?><?if($dispute['status'] == 4){?>is-complete<?}else{?><?}?>" data-step="2">
        <?php echo lang('users dispute step_2'); ?>
      </li>
      <li class="<?if($dispute['status'] == 3){?>is-complete<?}else{?><?}?><?if($dispute['status'] == 4){?>is-complete<?}else{?><?}?>" data-step="3" class="progress__last">
        <?php echo lang('users dispute step_3'); ?>
      </li>
    </ol>
  </div>
</div>

<div class="card mt-3">
  <div class="card-body">
    <h6>
      <?php echo lang('users desc dispute'); ?>
    </h6>
    <p>
      <?php echo $dispute['message'] ?>
    </p>
  </div>
</div>

<?php foreach($log_comment->result() as $view) : ?>

<div class="card mt-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-10">
        <h6><?php echo $view->user ?></h6>
      </div>
      <div class="col-md-2 text-right">
        <?if($view->role==1){?><i class="icon-user icons"></i><?}else{?><?}?>
        <?if($view->role==2){?><i class="icon-user-following icons text-success"></i><?}else{?><?}?>
        <?if($view->role==3){?><i class="icon-exclamation icons text-danger"></i><?}else{?><?}?>
      </div>
    </div>
    <p>
      <?php echo $view->comment ?>
    </p>
    <div class="text-right">
      <small class="text-muted"><i class="icon-clock icons"></i> <?php echo $view->time ?></small>
    </div>
  </div>
</div>

<?php endforeach; ?>

<?php if($dispute['status'] != 3 && $dispute['status'] != 4) : ?>
<div class="card mt-3">
  <div class="card-body">
    <?php echo form_open(site_url("account/disputes/add_comment"), array("" => "")) ?>
    <?php if (isset($dispute['id'])) : ?>
      <?php echo form_hidden('id', $dispute['id']); ?>
    <?php endif; ?>
    <div class="row">
      <div class="form-group col-md-12">
        <label><?php echo lang('users disputes new_comment'); ?></label>
        <textarea class="form-control" rows="8" name="comment"></textarea>
      </div>
      <div class="col-md-12 text-right">
        <button type="submit" name="submit" class="btn btn-success"><?php echo lang('users disputes add_comment'); ?></button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php endif; ?>