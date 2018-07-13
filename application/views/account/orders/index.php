<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users orders total'); ?> <?php echo $this->notice->sum_items_orders($user['username']); ?></h5>
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
              <div class="col-md-9">
                <a href="<?php echo base_url();?>account/shops/detail_item/<?php echo $view['id_item']; ?>"><?php echo $this->notice->detail_item_cart_name($view['id_item']); ?></a></br>
                <small class="text-muted"><?php echo lang('users shops name_shop'); ?>: <?php echo $this->notice->detail_item_cart_shop($view['id_merchant']); ?> | ID: <?php echo $view['id']; ?> | <?php echo lang('users support code'); ?>: <?php echo $view['code']; ?> | <?php echo lang('users history id_trans'); ?>: <?php echo $view['id_transaction']; ?></small>
              </div>
              <div class="col-md-2 mt-2 text-right">
                <a href="<?php echo $this->notice->detail_item_cart_link($view['id_item']); ?>" class="btn btn-sm btn-success"><i class="icon-cloud-download icons"></i> <?php echo lang('users orders download'); ?></a>
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
                <a href="" class="btn btn-sm btn-success disabled"><i class="icon-cloud-download icons"></i> <?php echo lang('users orders download'); ?></a>
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