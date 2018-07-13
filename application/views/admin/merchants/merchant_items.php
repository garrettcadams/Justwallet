<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin shops all_items'); ?>
          </div>
          <div class="col-md-8 -text-right">
            <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="collapse" id="search">
              <div class="card card-search">
                <div class="card-body">
                  <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                  <div class="row">
                    <div class="col-md-12">
                      <h6><?php echo lang('admins log search'); ?></h6>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins trans id'); ?></label>
                           <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans id'), 'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin shops it-merchant'); ?></label>
                           <?php echo form_input(array('name'=>'merchant_id', 'id'=>'merchant_id', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin shops it-merchant'), 'value'=>set_value('merchant_id', ((isset($filters['merchant_id'])) ? $filters['merchant_id'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin shops it-user'); ?></label>
                           <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin shops it-user'), 'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins trans status'); ?></label>
                            <select class="form-control form-control-sm" name="status">
                              <option></option>
                              <option value="1"><?php echo lang('admin template enabled'); ?></option>
                              <option value="2"><?php echo lang('admin template disabled'); ?></option>
                            </select>
                       </div>
                    </div>
                    <div class="col-md-8">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin settings name'); ?></label>
                           <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin settings name'), 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-12 -text-right">
                      <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admins log search'); ?></button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
              <tr>
                  <th></th>
                    <th>
                        <?php echo lang('admins trans id'); ?>
                    </th>
                    <th>
                        <?php echo lang('admin settings name'); ?>
                    </th>
                    <th>
                        <?php echo lang('admin shops it-user'); ?>
                    </th>
                    <th class="-text-center">
                        <?php echo lang('admin shops it-merchant'); ?>
                    </th>
                    <th class="-text-center">
                        <?php echo lang('admin shops it-availability'); ?>
                    </th>
                    <th>
                        <?php echo lang('admin shops it-price'); ?>
                    </th>
                    <th class="-text-center">
                        <?php echo lang('admins trans status'); ?>
                    </th>
                    
                    <th class="-text-center"></th>
                </tr>
              </thead>
              <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($history as $view) : ?>
              <tr>
                
                <td class="-text-center"><img class="img-item" src="<?php echo base_url();?>upload/items/img/<?php echo $view['img']; ?>"></td>
                <td><?php echo $view['id']; ?></td>
                <td><?php echo $view['name']; ?></td>
                <td><?php echo $view['user']; ?></td>
                <td class="-text-center"><a href="<?php echo base_url();?>admin/merchants/edit_merchant/<?php echo $view['merchant_id']; ?>" target="_blank"><?php echo $view['merchant_id']; ?></a></td>
                <td class="-text-center"><?php echo $view['availability']; ?></td>
                <td><?php echo $view['price']; ?> <?if($view['currency']=='debit_base'){?>
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
                                <?}?>
                </td>
                <td class="-text-center">
                  <?if($view['status']==1){?>
                                  <span class="badge badge-success"> <?php echo lang('admin template enabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-danger"> <?php echo lang('admin template disabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                </td>
                <td class="-text-center">
                               
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="<?php echo base_url();?>admin/merchants/delete_item/<?php echo $view['id'] ?>" class="btn btn-danger"><i class="icon-close icons"></i></a>
                              <a href="<?php echo base_url();?>admin/merchants/edit_item/<?php echo $view['id'] ?>" class="btn btn-primary"><i class="icon-pencil icons"></i></a>
                            </div>
                               
                        </td>
                
              </tr>
              <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="9">
                          <?php echo lang('core error no_results'); ?>
                      </td>
                  </tr>
              <?php endif; ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>