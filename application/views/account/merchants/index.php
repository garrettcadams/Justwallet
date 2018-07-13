<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users merchants all'); ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="#search" data-toggle="collapse" href="#search" aria-expanded="false" aria-controls="search" class="btn btn-outline-secondary btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('users trans search'); ?></a>
      <a href="<?php echo base_url('account/merchants/add'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-plus icons"></i> <?php echo lang('users merchants new'); ?></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
        <div class="collapse mb-3" id="search">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><?php echo lang('users trans search'); ?></h5>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control', 'placeholder'=> '84848',  'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-8">
                <label for="id"><?php echo lang('users invoices name'); ?></label>
                <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control', 'placeholder'=> 'Merchant',  'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
              </div>
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success btn-sm"><?php echo lang('users trans search'); ?></button>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?>
        <table class="table table-hover table-responsive-lg">
           <thead>
            <th></th>
            <th><?php echo lang('users trans id'); ?></th>
            <th><?php echo lang('users invoices name'); ?></th>
            <th><?php echo lang('users merchants url'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
          <tbody>
              <?php if ($total) : ?>
                <?php foreach ($history as $view) : ?>
                <tr>
                  <td><img class="win-img logo-merchants" src="<?php echo base_url();?>upload/logo/<?php echo $view['logo']; ?>"></td>
                  <td><?php echo $view['id']; ?></td>
                  <td><?php echo $view['name']; ?></td>
                  <td><a href="<?php echo $view['link']; ?>" target="_blank"><?php echo $view['link']; ?></a></td>
                  <td>
                    <?if($view['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('users merchants moderation'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('users merchants active'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('users merchants disapproved'); ?> </span>
                                <?}else{?>
                                <?}?>
                  </td>
                  <td class="text-center"><a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url();?>account/merchants/merchant_orders/<?php echo $view['id']; ?>"><i class="icon-eye icons"></i></a></td>
                </tr>
              <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">
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
            <small><?php echo lang('users shops merchant_total'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>