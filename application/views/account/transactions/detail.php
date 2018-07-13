<?php
  $label_check = mb_strimwidth($transactions['label'], 0, 3);
  if ($label_check == "blc") {
    $blockchain_type = '1';
  } else {
    $blockchain_type = '2';
  }
?>
<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users history detail'); ?> <?php echo lang('users trans id'); ?> <?php echo $transactions['id'] ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <?if($transactions['type'] != 2 & $transactions['type'] != 4){?>
        <?if($user['username'] == $transactions['sender']){?>
          <?if($dispute_mode == 1){?>
    <a href="#" data-toggle="modal" data-target="#dispute" class="btn btn-outline-danger btn-sm"><?php echo lang('users history open_dispute'); ?></a>
    <?}else{?>
          <?}?>
        <?}else{?>
        <?}?>
        <?}else{?>
        <?}?>
  </div>
</div>

<?php if ($transactions['protect'] != "none" & $transactions['status'] == 1 & $transactions['receiver'] == $user['username']) : ?>
<div class="row">
  <div class="col-md-12 mb-3">
    <div class="card text-white bg-primary">
      <div class="card-body">
        <div class="row">
          <div class="col-md-9">
            <p class="card-text"><?php echo lang('users transfer info_receiver'); ?></p>
          </div>
          <div class="col-md-3">
            <div class="btn-group mt-2" role="group" aria-label="Basic example">
              <button type="button" data-toggle="collapse" data-target="#protect" aria-expanded="false" aria-controls="protect" class="btn btn-outline-light"><?php echo lang('users transfer enter_code'); ?></button>
              <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#refund"><?php echo lang('users transfer refund'); ?></button>
            </div>
          </div>
          <div class="col-md-12 mt-3">
            <div class="collapse" id="protect"> 
              <?php echo form_open(site_url("account/transactions/protect_confirm/"), array("" => "")) ?>
              <?php if (isset($transactions['id'])) : ?>
                <?php echo form_hidden('id', $transactions['id']); ?>
              <?php endif; ?>
              <div class="row">
                <div class="col-md-12">
                    <label><?php echo lang('users transfer code_protect'); ?></label>
                    <input type="text" class="form-control" name="code_protect" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="1234" maxlength="4">
                    <small class="form-text text-white"><?php echo lang('users transaction protect_activate'); ?></small>
                </div>
                <div class="col-md-12 text-right">
                  <button type="submit" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></button>
               </div>
              </div>
              <?php echo form_close(); ?> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>


<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans date'); ?></strong></label>
         <p class="form-control-static"><?php echo $transactions['time'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans type'); ?></strong></label>
         <p class="form-control-static"><?if($transactions['type']==1){?>
                      <?php echo lang('users trans deposit'); ?>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['type']==2){?>
                      <?php echo lang('users trans withdrawal'); ?>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['type']==3){?>
                      <?php echo lang('users trans transfer'); ?>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['type']==4){?>
                      <?php echo lang('users trans exchange'); ?>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['type']==5){?>
                      <?php echo lang('users trans external'); ?>
                 <?}else{?>
                 <?}?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans status'); ?></strong></label>
         <p class="form-control-static"><?if($transactions['status']==1){?>
                <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['status']==2){?>
                <span class="badge badge-success"> <?php echo lang('users trans success'); ?> </span>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['status']==3){?>
                <span class="badge badge-info"> <?php echo lang('users trans refund'); ?> </span>
                 <?}else{?>
                 <?}?>
                <?if($transactions['status']==4){?>
                <span class="badge badge-danger"> <?php echo lang('users trans dispute'); ?> </span>
                 <?}else{?>
                 <?}?>
                 <?if($transactions['status']==5){?>
                <span class="badge badge-warning"> <?php echo lang('users trans blocked'); ?> </span>
                 <?}else{?>
                 <?}?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans amount'); ?></strong></label>
          <p class="form-control-static"><?php echo $transactions['amount'] ?> <?if($transactions['currency']=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans fee'); ?></strong></label>
         <p class="form-control-static">
           
           <?php echo $this->notice->check_fee_transaction($transactions['sum'], $transactions['amount'], $transactions['fee'], $transactions['sender'], $transactions['receiver'], $transactions['type'], $user['username'], $transactions['id']); ?> <?if($transactions['currency']=='debit_base'){?>
                      <?php echo $this->currencys->display->base_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra1'){?>
                      <?php echo $this->currencys->display->extra1_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra2'){?>
                      <?php echo $this->currencys->display->extra2_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra3'){?>
                      <?php echo $this->currencys->display->extra3_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra4'){?>
                      <?php echo $this->currencys->display->extra4_code ?>
                  <?}else{?>
                  <?}?>
                  <?if($transactions['currency']=='debit_extra5'){?>
                      <?php echo $this->currencys->display->extra5_code ?>
                  <?}else{?>
                  <?}?>
                
        </p>
      </div>
 <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans ip'); ?></strong></label>
         <p class="form-control-static"><?php echo $transactions['ip_address'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans sender'); ?></strong></label>
         <p class="form-control-static"><?php echo $transactions['sender'] ?></p>
      </div>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users trans receiver'); ?></strong></label>
         <p class="form-control-static"><?php echo $transactions['receiver'] ?></p>
      </div>
      <?php if ($blockchain_type == '1') : ?>
      <div class="form-group col-md-4">
         <label for="date"><strong><?php echo lang('users deposit number_confirm'); ?></strong></label>
         <p class="form-control-static"><?php echo $this->fixer->get_btc_confirm_network($transactions['user_comment']); ?></p>
      </div>
      <?php endif; ?>
      
      <?if($transactions['user_comment']!=NULL){?>
      <div class="form-group col-md-12">
         <label for="date"><strong><?php echo lang('users trans comment'); ?></strong></label>
         <p class="form-control-static"><?php echo $transactions['user_comment'] ?></p>
      </div>
      <?}else{?>
      <?}?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="refund" tabindex="-1" role="dialog" aria-labelledby="refund" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('users refund header'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo lang('users refund body'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo lang('users verifi close'); ?></button>
        <a href="<?php echo base_url();?>account/transactions/protect_refund/<?php echo $transactions['id']; ?>" class="btn btn-success"><?php echo lang('users transfer protect_confirm'); ?></a>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dispute" tabindex="-1" role="dialog" aria-labelledby="dispute" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('users history open_dispute'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <?php echo form_open(site_url("account/disputes/start_dispute"), array("" => "")) ?>
          <?php if (isset($transactions['id'])) : ?>
            <?php echo form_hidden('id', $transactions['id']); ?>
          <?php endif; ?>
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('users history dispute_title'); ?></label>
                <select class="form-control" name="title">
                  <option value="1"><?php echo lang('users history not_received'); ?></option>
                  <option value="2"><?php echo lang('users history not_desk'); ?></option>
                </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label><?php echo lang('users history reason'); ?></label>
              <textarea class="form-control" rows="10" name="message"></textarea>
              <span class="text-muted"><?php echo lang('users history help'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo lang('users verifi close'); ?></button>
        <button type="submit" name="submit" class="btn btn-success"><?php echo lang('users history start'); ?></button>
      </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>