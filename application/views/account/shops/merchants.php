<div class="row">
  <div class="col-md-12 mb-2">
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
    <h5>
    <?php 
                  $name_category = (@$category['name'][$this->session->language]) ? $category['name'][$this->session->language] : "";
                  echo $name_category;
    ?>
    </h5>
  </div>
</div>

<div class="row">
  <?php if ($total) : ?>
  <?php foreach ($shops as $view) : ?>
  <div class="col-md-12 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-1 text-center mt-2 mb-2">
                <img src="<?php echo base_url();?>upload/logo/<?php echo $view['logo']; ?>" class="win-img">
              </div>
              <div class="col-md-9 mb-2">
                <strong><?php echo $view['name']; ?></strong></br>
                <small class="text-muted"><?php echo $view['comment']; ?></small></br>
                <small><a href="<?php echo $view['link']; ?>" target="_blank"><?php echo $view['link']; ?></a></small>
              </div>
              <div class="col-md-2 mb-2 mt-2rem">
                <a href="<?php echo base_url();?>account/shops/category/<?php echo $view['id']; ?>" class="btn btn-outline-success btn-block"><?php echo lang('users shops item_go_now'); ?></a>
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
</div>