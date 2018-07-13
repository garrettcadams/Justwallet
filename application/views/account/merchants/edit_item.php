<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users shops item_edit'); ?> <?php echo $item['id']; ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="<?php echo base_url();?>account/merchants/merchant_orders/<?php echo $item['merchant_id']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-bell icons"></i> <?php echo lang('users shops orders'); ?></a>
      <div class="btn-group" role="group">
        <button id="buyeer" type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="icon-tag icons"></i> <?php echo lang('users shops catalog'); ?></button>
        <div class="dropdown-menu" aria-labelledby="buyeer">
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/merchant_categories/<?php echo $item['merchant_id']; ?>"><?php echo lang('users shops categories'); ?></a>
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/items/<?php echo $item['merchant_id']; ?>"><?php echo lang('users shops items'); ?></a>
        </div>
      </div>
      <div class="btn-group" role="group">
          <a class="btn btn-sm btn-outline-secondary" href="<?php echo base_url();?>account/merchants/settings/<?php echo $item['merchant_id']; ?>"><i class="icon-settings icons"></i> <?php echo lang('users shops settings'); ?></a>
        </div>
      </div>
    </div>
</div>
<?php echo form_open_multipart(site_url('account/merchants/start_edit_item/'.$id.''), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users invoices name'); ?></label>
          <input type="text" class="form-control" name="name" value="<?php echo $item['name']; ?>">
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="id"><?php echo lang('users trans status'); ?></label>
                <select class="form-control" name="status" id="exampleFormControlSelect1">
                  <option value="1" <?if($item['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops enabled'); ?></option>
                  <option value="2" <?if($item['status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('users shops disabled'); ?></option>
                </select>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users shops item_link'); ?></label>
          <input type="text" class="form-control" name="download_link" value="<?php echo $item['download_link']; ?>">
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users shops item_category'); ?></label>
          <select class="form-control" id="exampleFormControlSelect1" name="category_id">
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
              <option value="<?php echo $view['id']; ?>" <?if($item['category_id']==$view['id']){?>selected<?}else{?><?}?>>
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
      </div>
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users shops availability'); ?></label>
          <input type="text" class="form-control" name="availability" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" value="<?php echo $item['availability']; ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users shops price'); ?></label>
          <input type="text" class="form-control" name="price" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00" value="<?php echo $item['price']; ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label><?php echo lang('users trans cyr'); ?></label>
                  <select class="form-control" name="currency">
                    <option value="debit_base" <?if($item['currency']=="debit_base"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->base_code ?>
                    </option>
                    <?php if($this->currencys->display->extra1_check) : ?>
                    <option value="debit_extra1" <?if($item['currency']=="debit_extra1"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->extra1_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra2_check) : ?>
                    <option value="debit_extra2" <?if($item['currency']=="debit_extra2"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->extra2_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra3_check) : ?>
                    <option value="debit_extra3" <?if($item['currency']=="debit_extra3"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->extra3_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra4_check) : ?>
                    <option value="debit_extra4" <?if($item['currency']=="debit_extra4"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->extra4_code ?>
                    </option>
                    <?php endif; ?>
                    <?php if($this->currencys->display->extra5_check) : ?>
                    <option value="debit_extra5" <?if($item['currency']=="debit_extra5"){?>selected<?}else{?><?}?>>
                    <?php echo $this->currencys->display->extra5_code ?>
                    </option>
                    <?php endif; ?>
                  </select>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users invoices description'); ?></label>
          <textarea class="form-control" name="about" rows="8"><?php echo $item['about']; ?></textarea>
        </div>
      </div>
      
      <div class="col-md-6">
        <img class="mw-100" src="<?php echo base_url();?>upload/items/img/<?php echo $item['img']; ?>">
      </div>
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo lang('users shops image'); ?></label>
          <input type="file" class="form-control-file" id="img" name="img">
        </div>
      </div>
      
      <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
      </div>
      
    </div>
  </div>
</div>
<?php echo form_close(); ?> 