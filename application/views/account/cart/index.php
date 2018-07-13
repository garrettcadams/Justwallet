<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users cart total'); ?> <?php echo $this->notice->sum_items_cart($user['username']); ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-hover table-responsive-lg">
      <tbody>
        <?php if ($total) : ?>
        <?php foreach ($history as $view) : ?>
        <?if($this->notice->detail_item_cart_name($view['id_item']) != NULL){?>
        <tr>
          <td>
            <div class="row">
              <div class="col-md-1">
                <img class="item-img" src="<?php echo base_url();?>upload/items/img/<?php echo $this->notice->detail_item_cart_img($view['id_item']); ?>">
              </div>
              <div class="col-md-6">
                <a href="<?php echo base_url();?>account/shops/detail_item/<?php echo $view['id_item']; ?>"><?php echo $this->notice->detail_item_cart_name($view['id_item']); ?></a></br>
                <small class="text-muted"><?php echo lang('users shops name_shop'); ?>: <?php echo $this->notice->detail_item_cart_shop($view['id_merchant']); ?> | ID: <?php echo $this->notice->detail_item_cart_id($view['id_item']); ?> | <?php echo lang('users shops availability'); ?>: <?php echo $this->notice->detail_item_cart_availability($view['id_item']); ?></small>
              </div>
              <div class="col-md-3 mt-1">
                <?php
                
                $get_amount = $this->notice->detail_item_cart_price($view['id_item']);
                
                $currency = $this->notice->detail_item_cart_currency($view['id_item']);
                
                if ($currency = "debit_base") {
                  $sym = $this->currencys->display->base_code;
                } else if ($currency = "debit_extra1") {
                  $sym = $this->currencys->display->extra1_code;
                } else if ($currency = "debit_extra2") {
                  $sym = $this->currencys->display->extra2_code;
                } else if ($currency = "debit_extra3") {
                  $sym = $this->currencys->display->extra3_code;
                } else if ($currency = "debit_extra4") {
                  $sym = $this->currencys->display->extra4_code;
                } else if ($currency = "debit_extra5") {
                  $sym = $this->currencys->display->extra5_code;
                }

                ?>
                <span class="text-success"><?php echo $this->notice->detail_item_cart_price($view['id_item']); ?> <?php echo $sym; ?></span></br>
                <small class="text-muted">+<?php echo $this->notice->detail_item_cart_fee($view['id_item'], $get_amount); ?> <?php echo $sym; ?></small>
              </div>
              <div class="col-md-2 mt-2">
                <a href="<?php echo base_url();?>account/cart/pay_item/<?php echo $view['id']; ?>" class="btn btn-sm btn-success"><?php echo lang('users invoices pay'); ?></a> <a href="<?php echo base_url();?>account/cart/del_item/<?php echo $view['id']; ?>" class="text-muted ml-2"><i class="fas fa-times"></i></a>
              </div>
            </div>
          </td>
        </tr>
        <?}else{?>
        <tr>
          <td>
            <div class="row">
              <div class="col-md-1">
                <img class="item-img" src="<?php echo base_url();?>upload/items/img/default.png">
              </div>
              <div class="col-md-6">
                <span class="text-danger"><?php echo lang('users cart not_aviable'); ?></span></br>
                <small class="text-muted"><?php echo lang('users shops name_shop'); ?>: <?php echo $this->notice->detail_item_cart_shop($view['id_merchant']); ?></small>
              </div>
              <div class="col-md-3 mt-1">
                
              </div>
              <div class="col-md-2 mt-2">
                <a href="" class="btn btn-sm btn-success disabled"><?php echo lang('users invoices pay'); ?></a> <a href="<?php echo base_url();?>account/cart/del_item/<?php echo $view['id']; ?>" class="text-muted ml-2"><i class="fas fa-times"></i></a>
              </div>
            </div>
          </td>
        </tr>
        <?}?>
        <?php endforeach; ?>
        <?php else : ?>
        
        <tr>
          <td>
            <?php echo lang('core error no_results'); ?>
          </td>
        </tr>

        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-12 text-right">
  <?php echo $pagination; ?>
</div>
</div>