

<div class="row">

  <div class="col-md-2">
    <div class="row">
      <div class="col-md-12">
        <img class="img-responsive " src="<?php echo base_url();?>upload/logo/<?php echo $merchant['logo']; ?>">
      </div>
      <div class="col-md-12 mt-tab">
        <div class="card">
          <div class="nav flex-column nav-pills" id="user_menu" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true"><?php echo lang('admin user main'); ?></a>
            <a class="nav-link" id="v-pills-verify-tab" data-toggle="pill" href="#v-pills-verify" role="tab" aria-controls="v-pills-verify" aria-selected="true"><?php echo lang('admin deposit connection'); ?></a>
            <a class="nav-link" id="v-pills-cat-tab" data-toggle="pill" href="#v-pills-cat" role="tab" aria-controls="v-pills-cat" aria-selected="true"><?php echo lang('admin shops categories'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-10">
    <div class="row">
      
      <div class="col-md-12">
        <div class="card">
          <div class="card-title">
              <?php echo lang('admin shops edit_merch'); ?> <?php echo $merchant['id']; ?>
          </div>
          <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <?php // hidden id ?>
            <?php if (isset($merchant_id)) : ?>
            <?php echo form_hidden('id', $merchant_id); ?>
            <?php endif; ?>
            <div class="tab-content" id="user_menu">
              <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                       <?php echo form_label(lang('admin invoices name'), 'name', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'name', 'value'=>set_value('name', (isset($merchant['name']) ? $merchant['name'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                       <?php echo form_label(lang('users merchants url'), 'link', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'link', 'value'=>set_value('link', (isset($merchant['link']) ? $merchant['link'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin settings fee'), 'fee', array('class'=>'control-label')); ?>
                       <span class="required">%</span>
                       <?php echo form_input(array('name'=>'fee', 'value'=>set_value('fee', (isset($merchant['fee']) ? $merchant['fee'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin settings fix_fee'), 'fix_fee', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'fix_fee', 'value'=>set_value('fix_fee', (isset($merchant['fix_fee']) ? $merchant['fix_fee'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlSelect1"><?php echo lang('users shops merchant_payeer'); ?></label>
                      <select class="form-control form-control-sm" name="payeer_fee" id="exampleFormControlSelect1">
                        <option value="0" <?if($merchant['payeer_fee']=="0"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_mecrh'); ?></option>
                        <option value="1" <?if($merchant['payeer_fee']=="1"){?>selected<?}else{?><?}?>><?php echo lang('users shops merchant_buyer'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlSelect1"><?php echo lang('admins trans status'); ?></label>
                      <select class="form-control form-control-sm" name="status" id="exampleFormControlSelect1">
                        <option value="1" <?if($merchant['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admins trans pending'); ?></option>
                        <option value="2" <?if($merchant['status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('admins trans success'); ?></option>
                        <option value="3" <?if($merchant['status']=="3"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlSelect1"><?php echo lang('admin shops category'); ?></label>
                      <select class="form-control form-control-sm" name="category" id="exampleFormControlSelect1">
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
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <?php echo form_label(lang('admin shops logo'), array('class'=>'control-label')); ?>
                      <input type="file" class="form-control-file" id="logo" name="logo">
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-cat" role="tabpanel" aria-labelledby="v-pills-cat-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>

                        <th>
                        <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin settings name'); ?>
                        </th>
                        <th class="-text-center">
                            <?php echo lang('admins trans status'); ?>
                        </th>

                        <th class="-text-center"></th>
                    </thead>
                      <tbody>
                      <?php if ($total2) : ?>
                      <?php foreach ($categories2 as $view) : ?>
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
                            ?></br>
                            <small class="text-muted"><?php echo lang('users shops item_total'); ?>: <?php echo $this->notice->sum_items($view['id_merchant'], $view['id']); ?></small>
                          </td>
                          <td class="-text-center">
                               <?if($view['status']==1){?>
                                  <span class="badge badge-success"> <?php echo lang('admin template enabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-danger"> <?php echo lang('admin template disabled'); ?> </span>
                                <?}else{?>
                                <?}?>
                          </td>
                    
                          <td class="-text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="<?php echo base_url();?>admin/merchants/merchant_items?sort=id&dir=desc&limit=10&offset=0&category_id=<?php echo $view['id'] ?>" class="btn btn-primary" target="_blank"><i class="icon-eye icons"></i></a>
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
              <div class="tab-pane fade show" id="v-pills-verify" role="tabpanel" aria-labelledby="v-pills-verify-tab">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                       <?php echo form_label(lang('admin shops desc'), 'comment', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_textarea(array('name'=>'comment', 'value'=>set_value('comment', (isset($merchant['comment']) ? $merchant['comment'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                       <?php echo form_label(lang('admin shops note'), 'note_payment', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'note_payment', 'value'=>set_value('note_payment', (isset($merchant['note_payment']) ? $merchant['note_payment'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlSelect1"><?php echo lang('admin shops show'); ?></label>
                      <select class="form-control form-control-sm" name="show_category" id="exampleFormControlSelect1">
                        <option value="0" <?if($merchant['show_category']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin template disabled'); ?></option>
                        <option value="1" <?if($merchant['show_category']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin template enabled'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleFormControlSelect1"><?php echo lang('admin shops test'); ?></label>
                      <select class="form-control form-control-sm" name="test_mode" id="exampleFormControlSelect1">
                        <option value="0" <?if($merchant['test_mode']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin shops no'); ?></option>
                        <option value="1" <?if($merchant['test_mode']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin shops yes'); ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin user password'), 'password', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'password', 'value'=>set_value('password', (isset($merchant['password']) ? $merchant['password'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin shops status_link'), 'status_link', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'status_link', 'value'=>set_value('status_link', (isset($merchant['status_link']) ? $merchant['status_link'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin shops fail_link'), 'fail_link', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'fail_link', 'value'=>set_value('fail_link', (isset($merchant['fail_link']) ? $merchant['fail_link'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                       <?php echo form_label(lang('admin shops success_link'), 'success_link', array('class'=>'control-label')); ?>
                       <span class="required">*</span>
                       <?php echo form_input(array('name'=>'success_link', 'value'=>set_value('success_link', (isset($merchant['success_link']) ? $merchant['success_link'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
          </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="card-footer-padding">
                <button type="submit"  class="btn btn-success btn-sm"><?php echo lang('core button save'); ?></button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
  
</div>