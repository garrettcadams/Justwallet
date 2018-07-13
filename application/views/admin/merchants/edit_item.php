<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin shops it-edit_item'); ?> <?php echo $item['id']; ?>
          </div>
        </div>
      </div>
      <?php echo form_open_multipart(site_url('admin/merchants/start_edit_item/'.$item['id'].''), array("" => "")) ?>
       <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('users invoices name'); ?></label>
              <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $item['name']; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="id"><?php echo lang('users trans status'); ?></label>
                    <select class="form-control form-control-sm" name="status" id="exampleFormControlSelect1">
                      <option value="1" <?if($item['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops enabled'); ?></option>
                      <option value="2" <?if($item['status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('users shops disabled'); ?></option>
                    </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('users shops item_link'); ?></label>
              <input type="text" class="form-control form-control-sm" name="download_link" value="<?php echo $item['download_link']; ?>">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('users shops item_category'); ?></label>
              <select class="form-control form-control-sm" id="exampleFormControlSelect1" name="category_id">
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
              <input type="text" class="form-control form-control-sm" name="availability" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" value="<?php echo $item['availability']; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('users shops price'); ?></label>
              <input type="text" class="form-control form-control-sm" name="price" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00" value="<?php echo $item['price']; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo lang('users trans cyr'); ?></label>
                      <select class="form-control form-control-sm" name="currency">
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
              <textarea class="form-control form-control-sm" name="about" rows="8"><?php echo $item['about']; ?></textarea>
            </div>
          </div>

          <div class="col-md-4">
            <img class="img-responsive" src="<?php echo base_url();?>upload/items/img/<?php echo $item['img']; ?>">
          </div>

          <div class="col-md-8">
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo lang('users shops image'); ?></label>
              <input type="file" class="form-control-file" id="img" name="img">
            </div>
          </div>
         </div>
      </div>
      
      <div class="card-footer-padding">
        <button type="submit" class="btn btn-success btn-sm"><?php echo lang('users button save'); ?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>