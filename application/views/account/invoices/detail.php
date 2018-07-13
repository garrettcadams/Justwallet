<div class="row">
  <div class="col-md-4 mb-2">
    <h5><?php echo lang('users invoices detail'); ?> <?php echo $invoice['id'] ?></h5>
  </div>
  <?if($user['username']==$invoice['receiver'] && $invoice['status']==1){?>
  <div class="col-md-8 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="icon-check icons"></i> <?php echo lang('users invoices pay'); ?></a>
      <a href="<?php echo base_url();?>account/invoices/cancel_invoice/<?php echo $invoice['id']; ?>" class="btn btn-danger btn-sm"><i class="icon-close icons"></i> <?php echo lang('users invoices refuse'); ?></a>
    </div>
  </div>
  <?}else{?>
  <?}?>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-9">
         <?if($sender['verify_status']==2){?>
         <p class="form-control-static text-success"><i class="icon-user-following icons"></i> <?php echo lang('users invoices sender_verify'); ?></p>
         <?}else{?>
         <p class="form-control-static text-danger"><i class="icon-user-unfollow icons"></i> <?php echo lang('users invoices sender_not_verify'); ?></p>
         <?}?>
      </div>
      <div class="col-md-3 text-right">
         <p class="form-control-static"><?if($invoice['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($invoice['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('users trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($invoice['status']==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('users invoices declined'); ?> </span>
                                <?}else{?>
                                <?}?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans date'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['date'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans sender'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['sender'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans receiver'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['receiver'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans amount'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['amount'] ?> <?php echo $symbol ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans fee'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['fee'] ?> <?php echo $symbol ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans sum'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['total'] ?> <?php echo $symbol ?></p>
      </div>
      <div class="form-group col-md-12">
         <label for="date"><strong><?php echo lang('users invoices name'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['name'] ?></p>
      </div>
      <div class="form-group col-md-12">
         <label for="date"><strong><?php echo lang('users invoices description'); ?></strong></label>
         <p class="form-control-static"><?php echo $invoice['info'] ?></p>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('users invoices modal_title1'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo lang('users invoices modal_body1'); ?> <?php echo $invoice['total'] ?> <?php echo $symbol ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?php echo lang('users invoices modal_close'); ?></button>
        <a href="<?php echo base_url();?>account/invoices/pay_invoice/<?php echo $invoice['id']; ?>" class="btn btn-success btn-sm"><?php echo lang('users invoices modal_agree'); ?></a>
      </div>
    </div>
  </div>
</div>