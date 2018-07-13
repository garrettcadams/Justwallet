<div class="row">
  <div class="col-md-5">
    <img class="w-100" src="<?php echo base_url();?>upload/items/img/<?php echo $item['img']; ?>">
    <div class="sharethis-inline-share-buttons mt-2"></div>
  </div>
  <div class="col-md-7">
    <h5><?php echo $item['name']; ?></h5>
    <small class="text-muted"><?php echo lang('users shops availability'); ?>: <?php echo $item['availability']; ?></small></br>
    <small class="text-muted"><?php echo lang('users shops name_shop'); ?>: <?php echo $merchant['name']; ?></small>
    <h4 class="text-success"><?php echo $item['price']; ?> <?if($item['currency']=='debit_base'){?>
                                    <?php echo $this->currencys->display->base_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra1'){?>
                                    <?php echo $this->currencys->display->extra1_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra2'){?>
                                    <?php echo $this->currencys->display->extra2_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra3'){?>
                                    <?php echo $this->currencys->display->extra3_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra4'){?>
                                    <?php echo $this->currencys->display->extra4_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra5'){?>
                                    <?php echo $this->currencys->display->extra5_code ?>
                                <?}else{?>
                                <?}?>
    </h4>
    <div class="alert alert-info mt-3" role="alert">
      <?php echo lang('users shops alert_protect'); ?>
    </div>
  
    
    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success"><i class="icon-credit-card icons"></i> <?php echo lang('users shops buy_now'); ?></button>
    <a href="<?php echo base_url();?>account/shops/add_to_cart_item/<?php echo $item['id']; ?>" class="btn btn-info"><i class="icon-basket icons"></i> <?php echo lang('users shops add_to_cart'); ?></a>
  </div>
</div>

<div class="row mt-4">
 <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <strong><?php echo lang('users invoices description'); ?></strong>
        <p class="mt-2"><?php echo $item['about']; ?></p>
      </div>
   </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('users orders modal_title'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo lang('users orders modal_body'); ?> <strong><?php echo $item['price']; ?> <?if($item['currency']=='debit_base'){?>
                                    <?php echo $this->currencys->display->base_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra1'){?>
                                    <?php echo $this->currencys->display->extra1_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra2'){?>
                                    <?php echo $this->currencys->display->extra2_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra3'){?>
                                    <?php echo $this->currencys->display->extra3_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra4'){?>
                                    <?php echo $this->currencys->display->extra4_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra5'){?>
                                    <?php echo $this->currencys->display->extra5_code ?>
                                <?}else{?>
                                <?}?></strong> + <?php echo lang('users orders modal_body2'); ?> <strong><?php echo $this->notice->detail_item_cart_fee($item['id'], $item['price']); ?> <?if($item['currency']=='debit_base'){?>
                                    <?php echo $this->currencys->display->base_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra1'){?>
                                    <?php echo $this->currencys->display->extra1_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra2'){?>
                                    <?php echo $this->currencys->display->extra2_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra3'){?>
                                    <?php echo $this->currencys->display->extra3_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra4'){?>
                                    <?php echo $this->currencys->display->extra4_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($item['currency']=='debit_extra5'){?>
                                    <?php echo $this->currencys->display->extra5_code ?>
                                <?}else{?>
                                <?}?></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('users verifi close'); ?></button>
        <a href="<?php echo base_url();?>account/shops/buy_now/<?php echo $item['id']; ?>" class="btn btn-success"><?php echo lang('users shops confirm_pay'); ?></a>
      </div>
    </div>
  </div>
</div>