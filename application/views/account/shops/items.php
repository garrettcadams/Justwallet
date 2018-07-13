<div class="row">
  <div class="col-md-8 mb-2">
    <h5>
      <?php
                $category['name'] = (@unserialize($category['name']) !== FALSE) ? unserialize($category['name']) : $category['name'];
                if ( ! is_array($category['name']))
                {
                    $old_value = $category['name'];
                    $category['name'] = array();
                    foreach ($this->session->languages as $language_key=>$language_name)
                    {
                        $category['name'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                    }
                }
       ?>
      <?php 
         $name_category = (@$category['name'][$this->session->language]) ? $category['name'][$this->session->language] : "";
         echo $name_category;
      ?>
    </h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <a href="<?php echo base_url();?>account/shops/category/<?php echo $category['id_merchant']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-organization icons"></i> <?php echo lang('users shops categories'); ?></a>
  </div>
</div>

<div class="row">
  <?php if ($total) : ?>
  <?php foreach ($items as $view) : ?>
  <div class="col-md-12 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-2 text-center mt-2 mb-2">
                <img class="w-100" src="<?php echo base_url();?>upload/items/img/<?php echo $view['img']; ?>">
              </div>
              <div class="col-md-7 mb-2">
                <strong><a href="<?php echo base_url();?>account/shops/detail_item/<?php echo $view['id']; ?>"><?php echo $view['name']; ?></a></strong></br>
                <small class="text-muted">
                  <?php
                  echo mb_strimwidth($view['about'], 0, 150, "...");
                  ?>
               </small>
              </div>
              <div class="col-md-3 mb-2 mt-2 text-center">
                <h5 class="text-success"><?php echo $view['price']; ?> <?if($view['currency']=='debit_base'){?>
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
                </h5>
                <a href="<?php echo base_url();?>account/shops/add_to_cart/<?php echo $view['id']; ?>" class="btn btn-outline-success btn-sm"><i class="icon-basket icons"></i> <?php echo lang('users shops add_to_cart'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php endforeach; ?>
  <?php else : ?>
        
  <div class="col-md-12 mb-3">
         
  <?php echo lang('core error no_results'); ?>
  <?php endif; ?>
</div>
<div class="row">
  <div class="col-md-12 text-right">
  <?php echo $pagination; ?>
</div>
</div>
</div>
