<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users shops merchant_edit'); ?> <?php echo $merchant['id'] ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="<?php echo base_url();?>account/merchants/merchant_orders/<?php echo $merchant['id']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-bell icons"></i> <?php echo lang('users shops orders'); ?></a>
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
<?php echo form_open('', array('role'=>'form')); ?>
<?php if (isset($merchant['id'])) : ?>
      <?php echo form_hidden('id', $merchant['id']); ?>
<?php endif; ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-12">
         <label for="email"><?php echo lang('users invoices name'); ?></label>
         <input type="text" class="form-control" id="name" value="<?php echo $merchant['name']; ?>" disabled>
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users merchants url'); ?></label>
         <input type="text" class="form-control" id="url" value="<?php echo $merchant['link']; ?>" disabled>
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users merchants ipn'); ?></label>
         <input type="text" class="form-control" id="status_link" value="<?php echo $merchant['status_link']; ?>" disabled>
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_success'); ?></label>
         <input type="text" class="form-control" name="success_link" id="success_link" value="<?php echo $merchant['success_link']; ?>">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_fail'); ?></label>
         <input type="text" class="form-control" name="fail_link" id="fail_link" value="<?php echo $merchant['fail_link']; ?>">
      </div>
      <div class="form-group col-md-12">
         <label for="email"><?php echo lang('users shops merchant_password'); ?></label>
         <input type="password" class="form-control" name="password" id="password" value="<?php echo $merchant['password']; ?>">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops categories'); ?></label>
        <select class="form-control" name="category" id="exampleFormControlSelect1" disabled>
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
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_show'); ?></label>
        <select class="form-control" name="show_category" id="exampleFormControlSelect1">
          <option value="0" <?if($merchant['show_category']=="0"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_no'); ?></option>
          <option value="1" <?if($merchant['show_category']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_yes'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users trans fee'); ?></label>
         <input type="text" class="form-control" name="fee" id="fee" value="<?php echo $merchant['fee']; ?>" disabled>
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_fix_fee'); ?></label>
         <input type="text" class="form-control" name="fix_fee" id="fix_fee" value="<?php echo $merchant['fix_fee']; ?>" disabled>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_payeer'); ?></label>
        <select class="form-control" name="payeer_fee" id="exampleFormControlSelect1">
          <option value="0" <?if($merchant['payeer_fee']=="0"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_mecrh'); ?></option>
          <option value="1" <?if($merchant['payeer_fee']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_buyer'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_test'); ?></label>
        <select class="form-control" name="test_mode" id="exampleFormControlSelect1">
          <option value="0" <?if($merchant['test_mode']=="0"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_no'); ?></option>
          <option value="1" <?if($merchant['test_mode']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_yes'); ?></option>
        </select>
      </div>

      <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 