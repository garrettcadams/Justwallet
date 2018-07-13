<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-3">
    <li class="list-group-item"><strong><?php echo lang('admins trans id'); ?>:</strong> <span class="pull-right"><?php echo $disputes['id']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admins disputes id_tran'); ?>:</strong> <span class="pull-right"><?php echo $disputes['transaction']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admins tickets date_info'); ?>:</strong> <span class="pull-right"><?php echo $disputes['time_dispute']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admins disputes claimant'); ?>:</strong> <span class="pull-right"><?php echo $disputes['claimant']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admins disputes defendant'); ?>:</strong> <span class="pull-right"><?php echo $disputes['defendant']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admins trans amount'); ?>:</strong> 
      <span class="pull-right">
        <?php echo $disputes['amount']; ?> 
        <?if($disputes['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
      </span>
    </li>
    <li class="list-group-item"><strong><?php echo lang('admins fees fees'); ?>:</strong> 
      <span class="pull-right">
        <?php echo $disputes['fee']; ?>
        <?if($disputes['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
      </span>
    </li>
    <li class="list-group-item"><strong><?php echo lang('admins trans sum'); ?>:</strong> 
      <span class="pull-right">
        <?php echo $disputes['sum']; ?>
        <?if($disputes['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
      </span>
    </li>
    <li class="list-group-item"><strong><?php echo lang('admins disputes status'); ?>:</strong> 
      <span class="pull-right">
        <?if($disputes['status']==1){?>
                      <span class="badge badge-primary"><?php echo lang('admins disputes open'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($disputes['status']==2){?>
                      <span class="badge badge-danger"><?php echo lang('admins disputes claim'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($disputes['status']==3){?>
                      <span class="badge badge-warning"><?php echo lang('admins disputes rejected'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($disputes['status']==4){?>
                      <span class="badge badge-success"><?php echo lang('admins disputes satisfied'); ?></span>
                     <?}else{?>
                     <?}?>
      </span>
    </li>
    <?if($disputes['status'] == 2){?>
    <li class="list-group-item">
        <div class="dropdown">
          <button class="btn btn-warning btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo lang('admin col actions'); ?>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?php echo $this_url; ?>/full_refund/<?php echo $disputes['id']; ?>"><?php echo lang('admin disputes full_satisfy'); ?></a>
            
            <a class="dropdown-item modalbttn" href="#0" data-toggle="modal" data-target="#0"><?php echo lang('admin disputes part_satisfy'); ?></a>
            <a class="dropdown-item" href="<?php echo $this_url; ?>/reject/<?php echo $disputes['id']; ?>"><?php echo lang('admins disputes reject'); ?></a>
          </div>
        </div>
      </li>
    <?}else{?>
    <?}?>
  </div>
  <div class="col-md-9">
     <div class="row">
      <div class="col-md-12">
        <div class="card margin-standart">
          <div class="card-title">
             <?if($disputes['title'] == 1){?>
                    <?php echo lang('admin disputes not_received'); ?>
                    <?}else{?>
                    <?}?><?if($disputes['title'] == 2){?>
                      <?php echo lang('admin disputes not_desk'); ?>
                    <?}else{?>
                    <?}?>
          </div>
          <div class="card-body">
            <?php echo $disputes['message'] ?>
          </div>
        </div>
       </div>
       <?php foreach($log_comment->result() as $view) : ?>
       <div class="col-md-12">
        <div class="card margin-standart">
          <div class="card-title-mini">
            <div class="row">
              <div class="col-md-9">
                <?if($view->role==1){?><i class="icon-user icons"></i><?}else{?><?}?>
                <?if($view->role==2){?><i class="icon-user-following icons text-success"></i><?}else{?><?}?>
                <?if($view->role==3){?><i class="icon-exclamation icons text-danger"></i><?}else{?><?}?> 
                <?php echo $view->user ?>, <small><?php echo $view->time ?></small>
              </div>
              <div class="col-md-3 -text-right">
                <?if($disputes['claimant'] == $view->user){?>
                <span class="badge badge-primary"><?php echo lang('admins disputes claimant'); ?></span>
                <?}else{?>
                <span class="badge badge-danger"><?php echo lang('admins disputes defendant'); ?></span>
                <?}?>
              </div>
            </div>
          </div>
          <div class="card-body">
            <p>
              <?php echo $view->comment ?>
            </p>
          </div>
        </div>
       </div>
       <?php endforeach; ?>
       
       <?php if($disputes['status'] != 3 & $disputes['status'] != 4) : ?>
       <div class="col-md-12">
         <?php echo form_open(site_url("admin/disputes/add_comment"), array("" => "")) ?>
       <?php if (isset($disputes['id'])) : ?>
        <?php echo form_hidden('id', $disputes['id']); ?>
       <?php endif; ?>
        <div class="card margin-standart">
          <div class="card-body">
            <label for="transaction" class="control-label"><strong><?php echo lang('admin tickets enter'); ?></strong></label>   
              <textarea name="comment" id="comment" class="form-control form-control-sm" rows="10" placeholder="<?php echo lang('admin tickets textarea'); ?>"></textarea>
               <script>
                CKEDITOR.replace( 'comment', { height:['150px'] } );
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.replace('body', {height: 150});
              </script>
          </div>
          <div class="card-footer-padding">
              <button type="submit" class="btn btn-success btn-sm"><?php echo lang('admins disputes add_comment'); ?></button>
           </div>
         </div>
       </div>
       <?php echo form_close(); ?> 
       <?php endif; ?>
    </div>
  </div>
</div>

  <div class="modalcontainer">
    <div class="flex">
      <div class="modal">
        <div class="close"><span>&#43;</span></div>
        <div class="content">
          <h4 class="mb-modal"><?php echo lang('admin disputes detaill_refund'); ?>, </h4>
          <div class="row">
            <div class="col-md-12">
              <?php echo form_open(site_url("admin/disputes/partially_refund"), array("" => "")) ?>
               <?php if (isset($disputes['id'])) : ?>
                <?php echo form_hidden('id', $disputes['id']); ?>
               <?php endif; ?>
              <div class="form-group"> 
                  <label class="control-label"><?php echo lang('admin disputes amount_refund'); ?>, <?if($disputes['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($disputes['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
                </label>
                  <input type="text" class="form-control form-control-sm" id="amount" name="amount" placeholder="0.00" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"> 
             </div>
            </div>
            <div class="col-md-12 -text-right">
                <button class="btn btn-success mb-modal-btn" type="submit">
                  <?php echo lang('admin disputes accept'); ?>
                </button>
              </div>
          </div>
        </div>
        <?php echo form_close(); ?> 
      </div>
    </div>
  </div>
