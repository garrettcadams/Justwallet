<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users orders sales'); ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="#search" data-toggle="collapse" href="#search" aria-expanded="false" aria-controls="search" class="btn btn-outline-secondary btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('users trans search'); ?></a>
      <div class="btn-group" role="group">
        <button id="buyeer" type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="icon-tag icons"></i> <?php echo lang('users shops catalog'); ?></button>
        <div class="dropdown-menu" aria-labelledby="buyeer">
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/merchant_categories/<?php echo $merchant['id']; ?>"><?php echo lang('users shops categories'); ?></a>
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/items/<?php echo $merchant['id']; ?>"><?php echo lang('users shops items'); ?></a>
        </div>
      </div>
      <div class="btn-group" role="group">
          <a class="btn btn-sm btn-outline-secondary" href="<?php echo base_url();?>account/merchants/settings/<?php echo $merchant['id']; ?>"><i class="icon-settings icons"></i> <?php echo lang('users shops settings'); ?></a>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
    <div class="collapse mb-3" id="search">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-12">
                <h6><?php echo lang('users trans search'); ?></h6>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control form-control-sm', 'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users support code'); ?></label>
                <?php echo form_input(array('name'=>'code', 'id'=>'code', 'class'=>'form-control form-control-sm', 'value'=>set_value('code', ((isset($filters['code'])) ? $filters['code'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users history id_trans'); ?></label>
                <?php echo form_input(array('name'=>'id_transaction', 'id'=>'id_transaction', 'class'=>'form-control form-control-sm', 'value'=>set_value('id_transaction', ((isset($filters['id_transaction'])) ? $filters['id_transaction'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users shops merchant_buyer'); ?></label>
                <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm', 'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
              </div>
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success btn-sm"><?php echo lang('users trans search'); ?></button>
              </div>
            </div>
      </div>
    </div>
    <?php echo form_close(); ?>
    <table class="table table-bordered table-hover table-responsive-lg">
      <tbody>
        <?php if ($total) : ?>
        <?php foreach ($history as $view) : ?>
        <tr>
          <td>
            <div class="row">
              <div class="col-md-1">
                <img class="item-img" src="<?php echo base_url();?>upload/items/img/<?php echo $this->notice->detail_item_cart_img($view['id_item']); ?>">
              </div>
              <div class="col-md-11">
                <a href="<?php echo base_url();?>account/shops/detail_item/<?php echo $view['id_item']; ?>"><?php echo $this->notice->detail_item_cart_name($view['id_item']); ?></a></br>
                <small class="text-muted"><?php echo lang('users shops merchant_buyer'); ?>: <?php echo $view['user']; ?> | ID: <?php echo $view['id']; ?> | <?php echo lang('users support code'); ?>: <?php echo $view['code']; ?> | <?php echo lang('users history id_trans'); ?>: <?php echo $view['id_transaction']; ?></small>
              </div>
            </div>
          </td>
        </tr>
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
  <div class="col-md-3 text-left">
            <h5><?php echo lang('users orders total'); ?> <span class="text-success"><?php echo $total; ?></span></h5>
  </div>
        <div class="col-md-9 text-right">
            <?php echo $pagination; ?>
        </div>
</div>