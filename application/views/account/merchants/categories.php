<div class="row">
  <div class="col-md-6 mb-2">
    <h5><?php echo lang('users shops categories'); ?></h5>
  </div>
  <div class="col-md-6 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
      <a href="<?php echo base_url();?>account/merchants/merchant_orders/<?php echo $id; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-bell icons"></i> <?php echo lang('users shops orders'); ?></a>
      <div class="btn-group" role="group">
        <button id="buyeer" type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="icon-tag icons"></i> <?php echo lang('users shops catalog'); ?></button>
        <div class="dropdown-menu" aria-labelledby="buyeer">
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/merchant_categories/<?php echo $id; ?>"><?php echo lang('users shops categories'); ?></a>
          <a class="dropdown-item" href="<?php echo base_url();?>account/merchants/items/<?php echo $id; ?>"><?php echo lang('users shops items'); ?></a>
        </div>
      </div>
      <div class="btn-group" role="group">
          <a class="btn btn-sm btn-outline-secondary" href="<?php echo base_url();?>account/merchants/settings/<?php echo $id; ?>"><i class="icon-settings icons"></i> <?php echo lang('users shops settings'); ?></a>
        </div>
      </div>
    </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 text-right">
        <button type="button" data-toggle="collapse" data-target="#add" aria-expanded="false" aria-controls="add" class="btn btn-sm btn-success mb-3"><i class="icon-plus icons"></i> <?php echo lang('users shops category_add'); ?></button>
      </div>
      <div class="col-md-12 mb-3">
        <div class="collapse" id="add">
          <?php echo form_open(site_url('account/merchants/add_merchant_categories/'.$id.''), array("" => "")) ?>
          <div class="card card-body">
            <div class="row">
              <div class="col-md-12">
                <h6><?php echo lang('users shops category_new'); ?></h6>
              </div>
              <div class="col-md-12 mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
              <li class="nav-item">
              <a class="nav-link <?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>" id="<?php echo $language_key; ?>-tab" data-toggle="tab" href="#<?php echo $language_key; ?>" role="tab" aria-controls="<?php echo $language_key; ?>" aria-selected="true"><?php echo $language_name; ?></a>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="tab-content mt-tab" id="myTabContent">
              <?php // has translations ?>

              <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
              <div class="tab-pane fade <?php echo ($language_key == $this->session->language) ? 'show active' : ''; ?>" id="<?php echo $language_key; ?>" role="tabpanel" aria-labelledby="<?php echo $language_key; ?>-tab">
                <?php
                 $field_data['name']  = "name[" . $language_key . "]";
                 $field_data['id']    = "name-" . $language_key;
                 $field_data['class'] = "form-control form-control-sm";
                ?>
                <div class="row">
                  <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label class="control-label"><?php echo lang('users invoices name'); ?></label>
                        <?php echo form_input($field_data); ?>
                    </div>
                  </div>

                </div>

              </div>
              <?php endforeach; ?>
              <div class="row">
              <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="exampleFormControlSelect2"><?php echo lang('users trans status'); ?></label>
                                            <select class="form-control form-control-sm" name="status" id="exampleFormControlSelect2">
                                              <option value="1" <?if($view['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops enabled'); ?></option>
                                              <option value="2" <?if($view['status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('users shops disabled'); ?></option>
                                            </select>
                                          </div>
                                        </div>
                                <div class="col-md-12 text-right">
                                          <button type="submit" class="btn btn-success btn-sm mt-1">
                                            <?php echo lang('users button save'); ?>
                                          </button>
                                        </div>
              </div>
            </div>
          </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
      <div class="col-md-12">
        
         <table class="table table-hover table-responsive-lg">
           <thead>
            <th><?php echo lang('users trans id'); ?></th>
            <th><?php echo lang('users invoices name'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
           <tbody>
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
                <tr>
                  <td><?php echo $view['id']; ?></td>
                  <td>
                  <?php 
                    $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                    echo $name_category;
                  ?>
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
                  </td>
                  <td class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <a data-toggle="collapse" href="#id-<?php echo $view['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" class="btn btn-outline-success btn-sm"><i class="icon-pencil icons"></i></a>
                      <a href="<?php echo base_url();?>account/merchants/del_merchant_categories/<?php echo $view['id']; ?>" class="btn btn-outline-danger btn-sm"><i class="icon-trash icons"></i></a>
                    </div>
                  </td>
                </tr>
             <tr>
                  <td class="info-card" colspan="6">
                     <div class="collapse" id="id-<?php echo $view['id']; ?>">
                            <div class="card card-body mt-2 mb-2">
                              <?php echo form_open(site_url('account/merchants/edit_merchant_categories/'.$id.''), array("" => "")) ?>
                              <?php // hidden id ?>
                              <?php if (isset($view['id'])) : ?>
                                <?php echo form_hidden('id', $view['id']); ?>
                              <?php endif; ?>
                              <div class="row">
                                <div class="col-md-12">
                                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                    <li class="nav-item">
                                      <a class="nav-link <?php echo ($language_key == $this->session->language) ? 'active' : ''; ?>" id="<?php echo $language_key; ?>-<?php echo $view['id']; ?>-tab" data-toggle="tab" href="#<?php echo $language_key; ?>-<?php echo $view['id']; ?>" role="tab" aria-controls="<?php echo $language_key; ?>-<?php echo $view['id']; ?>" aria-selected="true"><?php echo $language_name; ?></a>
                                    </li>
                                    <?php endforeach; ?>
                                  </ul>
                                  <div class="tab-content" id="myTabContent">
                                    <?php foreach ($this->session->languages as $language_key=>$language_name) : ?>
                                    <div class="tab-pane fade <?php echo ($language_key == $this->session->language) ? 'show active' : ''; ?>" id="<?php echo $language_key; ?>-<?php echo $view['id']; ?>" role="tabpanel" aria-labelledby="<?php echo $language_key; ?>-<?php echo $view['id']; ?>-tab">
                                      <?php
                                       $field_data['name']  = "name[" . $language_key . "]";
                                       $field_data['id']    = "name-" . $language_key;
                                       $field_data['class'] = "form-control form-control-sm";
                                       $field_data['value'] = (@$view['name'][$language_key]) ? $view['name'][$language_key] : "";

                                       $editor = "name-" . $language_key;
                                      ?>
                                      <div class="row mt-3">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                              <label><?php echo lang('users invoices name'); ?></label>
                                              <?php echo form_input($field_data); ?>
                                          </div>
                                        </div>
                                        
                                      </div>
                                    </div>
                                    <?php endforeach; ?>
                                  </div>
                                  
                                </div>
                                <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="exampleFormControlSelect2"><?php echo lang('users trans status'); ?></label>
                                            <select class="form-control form-control-sm" name="status" id="exampleFormControlSelect2">
                                              <option value="1" <?if($view['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops enabled'); ?></option>
                                              <option value="2" <?if($view['status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('users shops disabled'); ?></option>
                                            </select>
                                          </div>
                                        </div>
                                <div class="col-md-12 text-right">
                                          <button type="submit" class="btn btn-success btn-sm mt-1">
                                            <?php echo lang('users button save'); ?>
                                          </button>
                                        </div>
                              </div>
                              <?php echo form_close(); ?>
                            </div>
                      </div>
                    </td>
                </tr>
              <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">
                            <?php echo lang('core error no_results'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>