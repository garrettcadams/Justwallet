<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users shops items'); ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="<?php echo base_url();?>account/merchants/merchant_orders/<?php echo $id;?>" class="btn btn-outline-secondary btn-sm"><i class="icon-bell icons"></i> <?php echo lang('users shops orders'); ?></a>
      <div class="btn-group" role="group">
        <button id="buyeer" type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="icon-tag icons"></i> <?php echo lang('users shops catalog'); ?></button>
        <div class="dropdown-menu" aria-labelledby="buyeer">
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/merchant_categories/<?php echo $id;?>"><?php echo lang('users shops categories'); ?></a>
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/items/<?php echo $id;?>"><?php echo lang('users shops items'); ?></a>
        </div>
      </div>
      <div class="btn-group" role="group">
          <a class="btn btn-sm btn-outline-secondary" href="<?php echo base_url();?>account/merchants/settings/<?php echo $id;?>"><i class="icon-settings icons"></i> <?php echo lang('users shops settings'); ?></a>
        </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 text-right">
         <a href="#search" data-toggle="collapse" href="#search" aria-expanded="false" aria-controls="search" class="btn btn-sm btn-warning mb-3"><i class="icon-magnifier icons"></i> <?php echo lang('users trans search'); ?></a>
        <a href="<?php echo base_url();?>account/merchants/add_item/<?php echo $id;?>" class="btn btn-sm btn-success mb-3"><i class="icon-plus icons"></i> <?php echo lang('users shops add_item'); ?></a>
      </div>
      <div class="col-md-12">
        <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
        <div class="collapse mb-3" id="search">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-12">
                <h6><?php echo lang('users trans search'); ?></h6>
              </div>
              <div class="form-group col-md-3">
                <label for="id"><?php echo lang('users trans id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control form-control-sm', 'placeholder'=> '84848',  'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-9">
                <label for="id"><?php echo lang('users invoices name'); ?></label>
                <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
              </div>
              <div class="form-group col-md-3">
                <label for="id"><?php echo lang('users trans status'); ?></label>
                <select class="form-control form-control-sm" name="status" id="exampleFormControlSelect1">
                  <option></option>
                  <option value="1"><?php echo lang('users shops enabled'); ?></option>
                  <option value="2"><?php echo lang('users shops disabled'); ?></option>
                  <option value="3"><?php echo lang('users merchants moderation'); ?></option>
                </select>
              </div>

              <div class="form-group col-md-9">
                <label for="id"><?php echo lang('users shops item_category'); ?></label>
                <select class="form-control form-control-sm" id="exampleFormControlSelect1" name="category_id">
                  <option></option>
                  <?php if ($total) : ?>
                    <?php foreach ($categories as $view) : ?>
                    <?php
                          $view['name'] = (@unserialize($view['name']) !== FALSE) ? unserialize($view['name']) : $view['name'];
                          if ( ! is_array($view['name']))
                          {
                              $old_value = $view['name'];
                              $view['name'] = array();
                              foreach ($this->session->languages as $language_key=>$language_name)
                              {
                                  $view['name'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                              }
                          }
                     ?>
                    
                    <option value="<?php echo $view['id']; ?>" <?if($merchant['category']==$view['id']){?>selected<?}else{?><?}?>>
                      <?php $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                      echo $name_category; ?>
                    </option>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <option>
                      <?php echo lang('core error no_results'); ?>
                    </option>
                  <?php endif; ?>
                </select>
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
            <th><?php echo lang('users invoices name'); ?></th>
            <th><?php echo lang('users shops price'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
          <tbody>
              <?php if ($total) : ?>
                <?php foreach ($items as $view) : ?>
                <tr>
                 <td><img class="item-img" src="<?php echo base_url();?>upload/items/img/<?php echo $view['img']; ?>"></td>
                 <td>
                   <?php echo $view['name']; ?></br>
                   <small class="text-muted"><?php echo lang('users shops availability'); ?>: <?php echo $view['availability']; ?></small>
                  </td>
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
                  <td>
                    <?if($view['status']==1){?>
                                  <span class="badge badge-success"> <?php echo lang('users shops enabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-danger"> <?php echo lang('users shops disabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-primary"> <?php echo lang('users merchants moderation'); ?> </span>
                                <?}else{?>
                                <?}?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <a href="<?php echo base_url();?>account/merchants/edit_item/<?php echo $view['id']; ?>" class="btn btn-outline-success btn-sm"><i class="icon-pencil icons"></i></a>
                      <a href="<?php echo base_url();?>account/merchants/del_items/<?php echo $view['id']; ?>" class="btn btn-outline-danger btn-sm"><i class="icon-trash icons"></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">
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
            <small><?php echo lang('users shops item_total'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>