<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users merchants new'); ?></h5>
  </div>
</div>

<?php echo form_open_multipart('', array('role'=>'form')); ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-12">
         <label for="email"><?php echo lang('users invoices name'); ?></label>
         <input type="text" class="form-control" name="name" id="name">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users merchants url'); ?></label>
         <input type="text" class="form-control" name="link" id="link">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users merchants ipn'); ?></label>
         <input type="text" class="form-control" name="status_link" id="status_link">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_success'); ?></label>
         <input type="text" class="form-control" name="success_link" id="success_link">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_fail'); ?></label>
         <input type="text" class="form-control" name="fail_link" id="fail_link">
      </div>
      <div class="form-group col-md-6">
         <label for="email"><?php echo lang('users shops merchant_password'); ?></label>
         <input type="password" class="form-control" name="password" id="password">
      </div>
      <div class="form-group col-md-6">
        <?php echo form_label(lang('users shops merchant_logo'), array()); ?>
        <input type="file" class="form-control-file" id="logo" name="logo">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops categories'); ?></label>
        <select class="form-control" name="category" id="exampleFormControlSelect1">
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
          <option value="0"><?php echo lang('users shops merchant_yes'); ?></option>
          <option value="1"><?php echo lang('users shops merchant_no'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_payeer'); ?></label>
        <select class="form-control" name="payeer_fee" id="exampleFormControlSelect1">
          <option value="0"><?php echo lang('users shops merchant_mecrh'); ?></option>
          <option value="1"><?php echo lang('users shops merchant_buyer'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_test'); ?></label>
        <select class="form-control" name="test_mode" id="exampleFormControlSelect1">
          <option value="0"><?php echo lang('users shops merchant_yes'); ?></option>
          <option value="1"><?php echo lang('users shops merchant_no'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-12">
        <?php echo form_label(lang('users shops merchant_note'), array()); ?>
        <input type="text" class="form-control" name="note_payment" id="note_payment">
        <small class="form-text text-muted"><?php echo lang('users shops merchant_note_info'); ?></small>
      </div>
      <div class="form-group col-md-12">
        <label><?php echo lang('users merchants comment'); ?></label>
        <textarea class="form-control" id="exampleFormControlTextarea1"name="comment" rows="5"></textarea>
      </div>
      
      <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-success"><?php echo lang('users button save'); ?></button>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 