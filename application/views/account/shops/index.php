<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users shops title_order'); ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <a href="<?php echo base_url('account/merchants'); ?>" class="btn btn-outline-success btn-sm"><i class="icon-plus icons"></i> <?php echo lang('users shops add_your'); ?></a>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <div class="card text-white bg-secondary">
      <?php echo form_open("account/shops/search?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
      <div class="card-body">
        <h6><?php echo lang('users shops search'); ?></h6>
        <div class="row">
          <div class="form-group col-md-8">
            <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo lang('users shops name'); ?>">
          </div>
          <div class="form-group col-md-4">
            <input type="text" class="form-control" id="id" name="id" placeholder="<?php echo lang('users shops id'); ?>">
          </div>
          <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-outline-light"><?php echo lang('users trans search'); ?></button>
          </div>
        </div>
      </div>
      <?php echo form_close(); ?> 
    </div>
  </div>
</div>

<div class="row mb-2">
  <div class="col-md-12">
    <h5><?php echo lang('users shops all'); ?> (<?php echo $all_shops; ?>)</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <?php if ($total) : ?>
          <?php foreach ($history as $view) : ?>
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
          <div class="col-md-6 mb-3">
            <?php // start ?>
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2 col-2">
                <img src="<?php echo base_url();?>upload/logo/<?php echo $view['img']; ?>" class="win-img w-100 mt-2">
              </div>
              <div class="col-md-10">
                <a href="<?php echo base_url();?>account/shops/merchants/<?php echo $view['id']; ?>">
                <?php 
                  $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                  echo $name_category;
                ?>
                </a></br>
                <small class="text-muted"><?php echo lang('users shops total'); ?>: <?php echo $this->notice->sum_merchants($view['id']); ?></small>
              </div>
            </div>
            
          </div>
          <?php endforeach; ?>
          <?php else : ?>
        
          <div class="col-md-12 mb-3">
            
            <?php echo lang('core error no_results'); ?>
            
          </div>
          <?php endif; ?>
      
        </div>
      </div>
    </div>
  </div>
</div>