<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open('', array('role'=>'form')); ?>
            <?php // hidden id ?>
            <?php if (isset($page_id)) : ?>
              <?php echo form_hidden('id', $page_id); ?>
            <?php endif; ?>

<div class="row">
  <div class="col-md-2">
    <div class="card">
        <div class="nav flex-column nav-pills" id="language" role="tablist" aria-orientation="vertical">
          <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
            <a class="nav-link <?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>" id="v-pills-<?php echo $language_key; ?>-tab" data-toggle="pill" href="#v-pills-<?php echo $language_key; ?>" role="tab" aria-controls="v-pills-<?php echo $language_key; ?>" aria-selected="true"><?php echo $language_name; ?></a>
          <?php endforeach; ?>
        </div>
    </div>
  </div>
  <div class="col-md-10">
    <div class="card">
      <div class="card-title">
          <?php echo lang('admin pages page'); ?> - <?php echo $page['name']; ?>
      </div>
      <div class="card-body">
        <div class="tab-content" id="language">
          <?php // has translations ?>
            <?php
              $page['content'] = (@unserialize($page['content']) !== FALSE) ? unserialize($page['content']) : $page['content'];
              if ( ! is_array($page['content']))
              {
                  $old_value = $page['content'];
                  $page['content'] = array();
                  foreach ($this->session->languages as $language_key=>$language_name)
                  {
                      $page['content'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                  }
              }
            ?>
          <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
          <div class="tab-pane fade <?php echo ($language_key == $this->session->language) ? 'show active' : ''; ?>" id="v-pills-<?php echo $language_key; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $language_key; ?>-tab">
          
           <?php
                 $field_data['name']  = "content[" . $language_key . "]";
                 $field_data['id']    = "content-" . $language_key;
                 $field_data['class'] = "form-control underlined";
                 $field_data['value'] = (@$page['content'][$language_key]) ? $page['content'][$language_key] : "";
              
                 $editor = "content-" . $language_key;
              ?>
              <?php echo form_textarea($field_data); ?>
              <script>
                CKEDITOR.replace( '<?php echo $editor; ?>', { height:['550px'] } );
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.replace('body', {height: 500});
            </script> 
            
          </div>
          
          <?php endforeach; ?>
          
        </div>
      </div>
      <div class="card-footer">
       <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
      </div>
    </div>
  </div>

</div>
<?php echo form_close(); ?>