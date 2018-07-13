<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo $merchant['name']; ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <a href="<?php echo base_url();?>account/shops/payment/<?php echo $merchant['id']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-credit-card icons"></i> <?php echo lang('users shops item_pay_id'); ?></a>
  </div>
</div>

<div class="row mt-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
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
          
          <div class="col-md-6 mb-3">
            <?php // start ?>
            <div class="row">
              <div class="col-md-10">
                <a href="<?php echo base_url();?>account/shops/items/<?php echo $view['id']; ?>">
                <?php 
                  $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                  echo $name_category;
                ?>
                </a></br>
                <small class="text-muted"><?php echo lang('users shops item_total'); ?>: <?php echo $this->notice->sum_items($view['id_merchant'], $view['id']); ?></small>
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