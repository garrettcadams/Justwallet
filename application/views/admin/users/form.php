<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-2">
    <div class="card">
      <div class="nav flex-column nav-pills" id="user_menu" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true"><?php echo lang('admin user main'); ?></a>
        <a class="nav-link" id="v-pills-sec-tab" data-toggle="pill" href="#v-pills-sec" role="tab" aria-controls="v-pills-sec" aria-selected="true"><?php echo lang('admin security title'); ?></a>
        <a class="nav-link" id="v-pills-billing-tab" data-toggle="pill" href="#v-pills-billing" role="tab" aria-controls="v-pills-billing" aria-selected="true"><?php echo lang('admin user billing'); ?></a>
        <a class="nav-link" id="v-pills-verify-tab" data-toggle="pill" href="#v-pills-verify" role="tab" aria-controls="v-pills-verify" aria-selected="true"><?php echo lang('admin verify user_menu'); ?></a>
        <a class="nav-link" id="v-pills-doc-tab" data-toggle="pill" href="#v-pills-doc" role="tab" aria-controls="v-pills-doc" aria-selected="true"><?php echo lang('admin verify documents'); ?></a>
        <a class="nav-link" id="v-pills-carts-tab" data-toggle="pill" href="#v-pills-carts" role="tab" aria-controls="v-pills-carts" aria-selected="true"><?php echo lang('admin shops user_carts'); ?></a>
        <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="true"><?php echo lang('admin shops user_orders'); ?></a>
        <a class="nav-link" id="v-pills-logs-tab" data-toggle="pill" href="#v-pills-logs" role="tab" aria-controls="v-pills-logs" aria-selected="true"><?php echo lang('admin user logs'); ?></a>
        <a class="nav-link" id="v-pills-20trans-tab" data-toggle="pill" href="#v-pills-20trans" role="tab" aria-controls="v-pills-20trans" aria-selected="true"><?php echo lang('admin security last_20_transaction'); ?></a>
        <a class="nav-link" id="v-pills-20tickets-tab" data-toggle="pill" href="#v-pills-20tickets" role="tab" aria-controls="v-pills-20tickets" aria-selected="true"><?php echo lang('admin security last_20_tickets'); ?></a>
        <a class="nav-link" id="v-pills-merchants-tab" data-toggle="pill" href="#v-pills-merchants" role="tab" aria-controls="v-pills-merchants" aria-selected="true"><?php echo lang('admins merchant title'); ?></a>
        <a class="nav-link" id="v-pills-inv-tab" data-toggle="pill" href="#v-pills-inv" role="tab" aria-controls="v-pills-inv" aria-selected="true"><?php echo lang('admin security last_20_invoices'); ?></a>
        <a class="nav-link" id="v-pills-rel-tab" data-toggle="pill" href="#v-pills-rel" role="tab" aria-controls="v-pills-rel" aria-selected="true"><?php echo lang('admin security related'); ?></a>
        <a class="nav-link" id="v-pills-sms-tab" data-toggle="pill" href="#v-pills-sms" role="tab" aria-controls="v-pills-sms" aria-selected="true"><?php echo lang('admin security send_sms'); ?></a>
        <a class="nav-link" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" role="tab" aria-controls="v-pills-email" aria-selected="true"><?php echo lang('admin security send_email'); ?></a>
        <a class="nav-link" id="v-pills-addfunds-tab" data-toggle="pill" href="#v-pills-addfunds" role="tab" aria-controls="v-pills-addfunds" aria-selected="true"><?php echo lang('admins trans add_ball'); ?></a>
        <a class="nav-link" id="v-pills-tofunds-tab" data-toggle="pill" href="#v-pills-tofunds" role="tab" aria-controls="v-pills-tofunds" aria-selected="true"><?php echo lang('admins trans win_ball'); ?></a>
      </div>
    </div>
  </div>
  <div class="col-md-10">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->base_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->base_code ?></span>
            <div class="result"><?php echo $user['debit_base'] ?> <?php echo $this->currencys->display->base_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->extra1_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->extra1_code ?></span>
            <div class="result"><?php echo $user['debit_extra1'] ?> <?php echo $this->currencys->display->extra1_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->extra2_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->extra2_code ?></span>
            <div class="result"><?php echo $user['debit_extra2'] ?> <?php echo $this->currencys->display->extra2_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->extra3_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->extra3_code ?></span>
            <div class="result"><?php echo $user['debit_extra3'] ?> <?php echo $this->currencys->display->extra3_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->extra4_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->extra4_code ?></span>
            <div class="result"><?php echo $user['debit_extra4'] ?> <?php echo $this->currencys->display->extra4_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-4">
        <div class="card card-widget-success">
          <div class="card-body">
            <div class="widget-title"><strong><?php echo $this->currencys->display->extra5_name ?></strong></div>
            <span class="icons"><?php echo $this->currencys->display->extra5_code ?></span>
            <div class="result"><?php echo $user['debit_extra5'] ?> <?php echo $this->currencys->display->extra5_code ?></div>
          </div>
       </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-title">
            <div class="row">
              <div class="col-md-4">
                User ID: <?php echo $user['id']; ?>
              </div>
              <div class="col-md-8 -text-right">
                <p class="f-size"><?php echo lang('admin security profit'); ?>: <?php echo $profit_debit_base; ?> <?php echo $this->currencys->display->base_code ?> | <?php echo $profit_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?> | <?php echo $profit_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?> | <?php echo $profit_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?> | <?php echo $profit_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?> | <?php echo $profit_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></p>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content" id="user_menu">
              <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                <?php echo form_open('', array('role'=>'form')); ?>

                  <?php // hidden id ?>
                  <?php if (isset($user_id)) : ?>
                      <?php echo form_hidden('id', $user_id); ?>
                  <?php endif; ?>
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user username'), 'username', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'username', 'value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user email'), 'email', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user first_name'), 'first_name', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user last_name'), 'last_name', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user created'), 'created', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'created', 'value'=>set_value('created', (isset($user['created']) ? $user['created'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user update'), 'updated', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'updated', 'value'=>set_value('updated', (isset($user['updated']) ? $user['updated'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin verify user_menu'), 'verify_status', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="verify_status">
                            <option value="0" <?if($user['verify_status']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin settings 0'); ?></option>
                            <option value="1" <?if($user['verify_status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin settings 1'); ?></option>
                            <option value="2" <?if($user['verify_status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('admin settings 2'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user language'), 'language', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control form-control-sm"'); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user admin'), 'language', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="is_admin">
                            <option value="1" <?if($user['is_admin']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin user yes'); ?></option>
                            <option value="0" <?if($user['is_admin']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin user no'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user status'), 'language', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="status">
                            <option value="1" <?if($user['status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin user active'); ?></option>
                            <option value="0" <?if($user['status']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin user inactive'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user password'), 'password', array('class'=>'control-label')); ?>
                      <?php if ($password_required) : ?><span class="required">*</span><?php endif; ?>
                      <?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control form-control-sm', 'autocomplete'=>'off')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin user re_password'), 'password_repeat', array('class'=>'control-label')); ?>
                      <?php if ($password_required) : ?><span class="required">*</span><?php endif; ?>
                      <?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control form-control-sm', 'autocomplete'=>'off')); ?>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
                  </div>
                </div>
                 <?php echo form_close(); ?>
              </div>
              <div class="tab-pane fade show" id="v-pills-sec" role="tabpanel" aria-labelledby="v-pills-sec-tab">
                <?php echo form_open(site_url("admin/users/edit_security/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admins input phone'), 'phone', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'phone', 'value'=>set_value('phone', (isset($user['phone']) ? $user['phone'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin security login_method'), 'method_login', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="method_login">
                            <option value="1" <?if($user['method_login']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin security 1'); ?></option>
                            <option value="2" <?if($user['method_login']=="2"){?>selected<?}else{?><?}?>><?php echo lang('admin security 2'); ?></option>
                            <option value="3" <?if($user['method_login']=="3"){?>selected<?}else{?><?}?>><?php echo lang('admin security 3'); ?></option>
                            <option value="4" <?if($user['method_login']=="4"){?>selected<?}else{?><?}?>><?php echo lang('admin security 4'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin security login_token'), 'login_token', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'login_token', 'value'=>set_value('login_token', (isset($user['login_token']) ? $user['login_token'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin security 2fa_token'), '2fa_login', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'2fa_login', 'value'=>set_value('2fa_login', (isset($user['2fa_login']) ? $user['2fa_login'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin security lstatus_0'), 'login_status', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="login_status">
                            <option value="1" <?if($user['login_status']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin security lstatus_1'); ?></option>
                            <option value="2" <?if($user['login_status']=="2"){?>selected<?}else{?><?}?>><?php echo lang('admin security lstatus_2'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('admin security fraud_status'), 'fraud', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <select class="form-control form-control-sm" name="fraud">
                            <option value="0" <?if($user['fraud']=="0"){?>selected<?}else{?><?}?>><?php echo lang('admin security fraud_status1'); ?></option>
                            <option value="1" <?if($user['fraud']=="1"){?>selected<?}else{?><?}?>><?php echo lang('admin security fraud_status2'); ?></option>
                          </select>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              
              
              <div class="tab-pane fade show" id="v-pills-addfunds" role="tabpanel" aria-labelledby="v-pills-sec-tab">
                <?php echo form_open(site_url("admin/users/add_funds/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  
                  <div class="form-group col-md-8">
                      <label for="title"><?php echo lang('users transfer amount'); ?></label>
                      <input type="text" class="form-control <?php echo form_error('title') ? ' is-invalid' : ''; ?> form-control-sm" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
                 </div>
                  
                  <div class="form-group col-md-4">
                    <label><?php echo lang('users trans cyr'); ?></label>
                          <select class="form-control form-control-sm" name="currency">
                            <option value="debit_base">
                            <?php echo $this->currencys->display->base_code ?>
                            </option>
                            <?php if($this->currencys->display->extra1_check) : ?>
                            <option value="debit_extra1">
                            <?php echo $this->currencys->display->extra1_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra2_check) : ?>
                            <option value="debit_extra2">
                            <?php echo $this->currencys->display->extra2_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra3_check) : ?>
                            <option value="debit_extra3">
                            <?php echo $this->currencys->display->extra3_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra4_check) : ?>
                            <option value="debit_extra4">
                            <?php echo $this->currencys->display->extra4_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra5_check) : ?>
                            <option value="debit_extra5">
                            <?php echo $this->currencys->display->extra5_code ?>
                            </option>
                            <?php endif; ?>
                          </select>
               </div>
                  
                  <div class="form-group col-md-12">
                       <label><?php echo lang('users reqest note'); ?></label>
                       <textarea class="form-control" rows="5" name="note"></textarea>
                 </div>
                  
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('users transfer send'); ?></button>
                  </div>
                  
                </div>
                
                <?php echo form_close(); ?>
              </div>
              
              
              <div class="tab-pane fade show" id="v-pills-tofunds" role="tabpanel" aria-labelledby="v-pills-sec-tab">
                
                <?php echo form_open(site_url("admin/users/to_funds/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  
                  <div class="form-group col-md-8">
                      <label for="title"><?php echo lang('users transfer amount'); ?></label>
                      <input type="text" class="form-control <?php echo form_error('title') ? ' is-invalid' : ''; ?> form-control-sm" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
                 </div>
                  
                  <div class="form-group col-md-4">
                    <label><?php echo lang('users trans cyr'); ?></label>
                          <select class="form-control form-control-sm" name="currency">
                            <option value="debit_base">
                            <?php echo $this->currencys->display->base_code ?>
                            </option>
                            <?php if($this->currencys->display->extra1_check) : ?>
                            <option value="debit_extra1">
                            <?php echo $this->currencys->display->extra1_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra2_check) : ?>
                            <option value="debit_extra2">
                            <?php echo $this->currencys->display->extra2_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra3_check) : ?>
                            <option value="debit_extra3">
                            <?php echo $this->currencys->display->extra3_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra4_check) : ?>
                            <option value="debit_extra4">
                            <?php echo $this->currencys->display->extra4_code ?>
                            </option>
                            <?php endif; ?>
                            <?php if($this->currencys->display->extra5_check) : ?>
                            <option value="debit_extra5">
                            <?php echo $this->currencys->display->extra5_code ?>
                            </option>
                            <?php endif; ?>
                          </select>
               </div>
                  
                  <div class="form-group col-md-12">
                       <label><?php echo lang('users reqest note'); ?></label>
                       <textarea class="form-control" rows="5" name="note"></textarea>
                 </div>
                  
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admins button withdrawal_funds'); ?></button>
                  </div>
                  
                </div>
                
                <?php echo form_close(); ?>
                
              </div>
              
              
              <div class="tab-pane fade show" id="v-pills-sms" role="tabpanel" aria-labelledby="v-pills-sec-tab">
                <?php echo form_open(site_url("admin/users/send_sms/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admins input phone'), 'phone', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'phone', 'value'=>set_value('phone', (isset($user['phone']) ? $user['phone'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admin tickets message'), 'message', array('class'=>'control-label')); ?>
                     <textarea class="form-control form-control-sm" name="message" id="message" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admin security send_sms'); ?></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              <div class="tab-pane fade show" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
                <?php echo form_open(site_url("admin/users/send_email/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user email'), 'email', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admins tickets title'), 'title', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'title', 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admin tickets message'), 'message', array('class'=>'control-label')); ?>
                     <textarea class="form-control form-control-sm" name="message" id="message" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admin security send_email'); ?></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              <div class="tab-pane fade show" id="v-pills-carts" role="tabpanel" aria-labelledby="v-pills-carts-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
 
                        <th>
                            <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin invoices name'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin shops it-merchant'); ?>
                        </th>
                    </thead>
                      <tbody>
                        <?php foreach($carts->result() as $view) : ?>
                        <?if($this->notice->detail_item_cart_name($view->id_item) != NULL){?>
                        <tr>
                          <td><?php echo $view->id ?></td>
                          <td><a href="<?php echo base_url();?>admin/merchants/edit_item/<?php echo $view->id_item ?>" target="_blank"><?php echo $this->notice->detail_item_cart_name($view->id_item); ?></a></td>
                          <td><?php echo $this->notice->detail_item_cart_shop($view->id_merchant); ?></td>

                        </tr>
                        <?}else{?>
                        <tr>
                          <td><?php echo $view->id ?></td>
                          <td><?php echo lang('users cart not_aviable'); ?></td>
                          <td><?php echo $this->notice->detail_item_cart_shop($view->id_merchant); ?></td>

                        </tr>
                        <?}?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
              <div class="tab-pane fade show" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
 
                        <th>
                            <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin events code'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin tickets date_info'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin invoices name'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin shops it-merchant'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes id_tran'); ?>
                        </th>
                    </thead>
                      <tbody>
                       <?php foreach($orders->result() as $view) : ?>
                        <?if($this->notice->detail_item_cart_name($view->id_item) != NULL){?>
                        <tr>
                          
                          <td><?php echo $view->id ?></td>
                          <td><?php echo $view->code ?></td>
                          <td><?php echo $view->date ?></td>
                          <td><a href="<?php echo base_url();?>admin/merchants/edit_item/<?php echo $view->id_item ?>" target="_blank"><?php echo $this->notice->detail_item_cart_name($view->id_item); ?></a></td>
                          <td><?php echo $this->notice->detail_item_cart_shop($view->id_merchant); ?></td>
                          <td><a href="<?php echo base_url();?>admin/transactions/edit/<?php echo $view->id_transaction ?>" target="_blank"><?php echo $view->id_transaction; ?></a></td>
                          
                        </tr>
                        <?}else{?>
                        <tr>
                          
                          <td><?php echo $view->id ?></td>
                          <td><?php echo $view->code ?></td>
                          <td><?php echo $view->date ?></td>
                          <td><?php echo lang('users cart not_aviable'); ?></td>
                          <td><?php echo $this->notice->detail_item_cart_shop($view->id_merchant); ?></td>
                          <td><a href="<?php echo base_url();?>admin/transactions/edit/<?php echo $view->id_transaction ?>" target="_blank"><?php echo $view->id_transaction; ?></a></td>
                          
                        </tr>
                        <?}?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
              <div class="tab-pane fade show" id="v-pills-rel" role="tabpanel" aria-labelledby="v-pills-rel-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
 
                       <th>
                            <?php echo lang('admin user email'); ?>
                        </th>
                        <th>
                            <?php echo lang('users col username'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin settings name'); ?>
                        </th>
                        <th class="-text-center"></th>
                    </thead>
                      <tbody>
                        <?php foreach($rel_accounts->result() as $view) : ?>
                        
                        <tr>
                          <td><?php echo $view->email ?></td>
                          <td><?php echo $view->username ?></td>
                          <td><?php echo $view->first_name ?> <?php echo $view->last_name ?></td>
                          <td class="-text-center"><a href="<?php echo base_url();?>admin/users/edit/<?php echo $view->id ?>" class="btn btn-primary btn-sm" target="_blank"><i class="icon-eye icons"></i></a></td>
                        </tr>
                        
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
              <div class="tab-pane fade show" id="v-pills-inv" role="tabpanel" aria-labelledby="v-pills-inv-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                        <th>
                      <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin events date'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin invoices name'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins trans sender'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins trans receiver'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins trans amount'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins trans status'); ?>
                        </th>
                      </thead>
                      <tbody>
                      <?php foreach($inv_user->result() as $view) : ?>
                       <tr>
                        <td><a href="<?php echo base_url();?>admin/invoices/detail/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                         <td><?php echo $view->date ?></td>
                         <td><?php echo $view->name ?></td>
                         <td><?php echo $view->sender ?></td>
                         <td><?php echo $view->receiver ?></td>
                         <td><?php echo $view->amount ?> <?if($view->currency=='debit_base'){?>
                                    <?php echo $this->currencys->display->base_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view->currency=='debit_extra1'){?>
                                    <?php echo $this->currencys->display->extra1_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view->currency=='debit_extra2'){?>
                                    <?php echo $this->currencys->display->extra2_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view->currency=='debit_extra3'){?>
                                    <?php echo $this->currencys->display->extra3_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view->currency=='debit_extra4'){?>
                                    <?php echo $this->currencys->display->extra4_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view->currency=='debit_extra5'){?>
                                    <?php echo $this->currencys->display->extra5_code ?>
                                <?}else{?>
                                <?}?>
                         </td>
                         <td> <?if($view->status==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view->status==2){?>
                                  <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view->status==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('admin invoices declined'); ?> </span>
                                <?}else{?>
                                <?}?>
   
                        </td>
                       </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
                
              </div>
              <div class="tab-pane fade show" id="v-pills-merchants" role="tabpanel" aria-labelledby="v-pills-merchants-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                        <th></th>
                        <th>
                            <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin invoices name'); ?>
                        </th>
                        <th>
                          <?php echo lang('users merchants url'); ?>
                        </th>
                        <th class="-text-center">
                            <?php echo lang('admins trans status'); ?>
                        </th>
                        <th class="-text-center">
                            <?php echo lang('admin shops show'); ?>
                        </th>
                      </thead>
                      <tbody>
                      <?php foreach($merchant_user->result() as $view) : ?>
                        <tr>
                           <td class="-text-center"><img class="img-circle" src="<?php echo base_url();?>upload/logo/<?php echo $view->logo ?>"></td>
                           <td><a href="<?php echo base_url();?>admin/merchants/edit_merchant/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                           <td><?php echo $view->name ?></td>
                           <td><?php echo $view->link ?></td>
                          <td class="-text-center">
                            <?php if ($view->status == 1) : ?>
                              <span class="badge badge-primary"><?php echo lang('admins trans pending'); ?></span>
                            <?php elseif ($view->status == 2) : ?>
                              <span class="badge badge-success"><?php echo lang('admins trans success'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                            <?php endif; ?>
                          </td>
                          <td class="-text-center">
                            <?php if ($view->show_category == 1) : ?>
                              <span class="badge badge-success"><?php echo lang('admin template enabled'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
              <div class="tab-pane fade show" id="v-pills-20tickets" role="tabpanel" aria-labelledby="v-pills-20tickets-tab">
                
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                        <th>  
                          <?php echo lang('admin events code'); ?>
                        </th>
                        <th>
                           <?php echo lang('admin tickets date'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin tickets title'); ?>
                        </th>
                        <th>
                            <?php echo lang('admin col status'); ?>
                        </th>
                      </thead>
                      <tbody>
                        <?php foreach($support_user->result() as $view) : ?>
                          <tr>
                            <td><a href="<?php echo base_url();?>admin/support/edit/<?php echo $view->id ?>" target="_blank"><?php echo $view->code ?></a></td>
                            <td><?php echo $view->date ?></td>
                            <td><?php echo $view->title ?></td>
                            <td>
                              <?if($view->status==0){?>
                              <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                             <?}else{?>
                             <?}?>
                             <?if($view->status==1){?>
                              <span class="badge badge-success"><?php echo lang('admin tickets processed'); ?></span>
                             <?}else{?>
                             <?}?>
                             <?if($view->status==2){?>
                              <span class="badge badge-danger"><?php echo lang('admin tickets closed'); ?></span>
                             <?}else{?>
                             <?}?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                
              </div>
              <div class="tab-pane fade show" id="v-pills-20trans" role="tabpanel" aria-labelledby="v-pills-20trans-tab">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                         <th>
                      <?php echo lang('admins trans id'); ?>
                          </th>
                          <th>
                              <?php echo lang('admins trans type'); ?>
                          </th>
                          <th>
                              <?php echo lang('admins trans sender'); ?>
                          </th>
                          <th>
                              <?php echo lang('admins trans receiver'); ?>
                          </th>
                          <th>
                              <?php echo lang('admin events date'); ?>
                          </th>
                          <th>
                              <?php echo lang('admins trans sum'); ?>
                          </th>
                          <th>
                              <?php echo lang('admins trans status'); ?>
                          </th>
                        </thead>
                        <tbody>
                          <?php foreach($transaction_user->result() as $view) : ?>
                          <tr>
                            <td><a href="<?php echo base_url();?>admin/transactions/edit/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                            <td>
                              <?if($view->type==1){?>
                                  <?php echo lang('admins trans deposit'); ?>
                             <?}else{?>
                             <?}?>
                             <?if($view->type==2){?>
                                  <?php echo lang('admins trans withdrawal'); ?>
                             <?}else{?>
                             <?}?>
                             <?if($view->type==3){?>
                                  <?php echo lang('admins trans transfer'); ?>
                             <?}else{?>
                             <?}?>
                             <?if($view->type==4){?>
                                  <?php echo lang('admins trans exchange'); ?>
                             <?}else{?>
                             <?}?>
                             <?if($view->type==5){?>
                                  <?php echo lang('admins trans external'); ?>
                             <?}else{?>
                             <?}?>
                            </td>
                            <td><?php echo $view->sender ?></td>
                            <td><?php echo $view->receiver ?></td>
                            <td><?php echo $view->time ?></td>
                            <td><?php echo $view->sum ?></td>
                            <td>
                              <?if($view->status==1){?>
                              <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                               <?}else{?>
                               <?}?>
                               <?if($view->status==2){?>
                              <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                               <?}else{?>
                               <?}?>
                               <?if($view->status==3){?>
                              <span class="badge badge-info"> <?php echo lang('admins trans refund'); ?> </span>
                               <?}else{?>
                               <?}?>
                              <?if($view->status==4){?>
                              <span class="badge badge-danger"> <?php echo lang('admins trans dispute'); ?> </span>
                               <?}else{?>
                               <?}?>
                               <?if($view->status==5){?>
                              <span class="badge badge-warning"> <?php echo lang('admins trans blocked'); ?> </span>
                               <?}else{?>
                               <?}?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-logs" role="tabpanel" aria-labelledby="v-pills-logs-tab">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                          <th><?php echo lang('admin events code'); ?></th>
                          <th><?php echo lang('admin events date'); ?></th>
                          <th><?php echo lang('admin events ip'); ?></th>
                          <th><?php echo lang('admin events event'); ?></th>
                        </thead>
                        <tbody>
                          <?php foreach($log_user->result() as $view) : ?>
                          <tr>
                            <td><?php echo $view->code ?></td>
                            <td><?php echo $view->date ?></td>
                            <td><?php echo $view->ip ?></td>
                            <td>
                              <?php if ($view->type == 1) : ?>
                              <?php echo lang('admin events_status 1'); ?>
                              <?php elseif ($view->type == 2) : ?>
                              <?php echo lang('admin events_status 2'); ?>
                              <?php elseif ($view->type == 3) : ?>
                              <?php echo lang('admin events_status 3'); ?>
                              <?php elseif ($view->type == 4) : ?>
                              <?php echo lang('admin events_status 4'); ?>
                              <?php elseif ($view->type == 5) : ?>
                              <?php echo lang('admin events_status 5'); ?>
                              <?php elseif ($view->type == 6) : ?>

                              <?php endif; ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
                <?php echo form_open(site_url("admin/users/edit_billing/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user paypal'), 'paypal', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'paypal', 'value'=>set_value('paypal', (isset($user['paypal']) ? $user['paypal'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user card'), 'card', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'card', 'value'=>set_value('card', (isset($user['card']) ? $user['card'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user bitcoin'), 'bitcoin', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'bitcoin', 'value'=>set_value('bitcoin', (isset($user['bitcoin']) ? $user['bitcoin'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user skrill'), 'skrill', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'skrill', 'value'=>set_value('skrill', (isset($user['skrill']) ? $user['skrill'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user payza'), 'payza', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'payza', 'value'=>set_value('payza', (isset($user['payza']) ? $user['payza'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user advcash'), 'advcash', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'advcash', 'value'=>set_value('advcash', (isset($user['advcash']) ? $user['advcash'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user perfect_m'), 'perfect_m', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'perfect_m', 'value'=>set_value('perfect_m', (isset($user['perfect_m']) ? $user['perfect_m'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                     <?php echo form_label(lang('admin user swift'), 'swift', array('class'=>'control-label')); ?>
                     <textarea class="form-control form-control-sm" name="swift" id="swift" rows="7"><?php echo $user['swift']; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              <div class="tab-pane fade show" id="v-pills-verify" role="tabpanel" aria-labelledby="v-pills-verify-tab">
                <?php echo form_open(site_url("admin/users/edit_verify/" . $user['id']), array("" => "")) ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify company'), 'company', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'company', 'value'=>set_value('company', (isset($user['company']) ? $user['company'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify country'), 'country', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'country', 'value'=>set_value('country', (isset($user['country']) ? $user['country'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify zip'), 'zip', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'zip', 'value'=>set_value('zip', (isset($user['zip']) ? $user['zip'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify city'), 'city', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'city', 'value'=>set_value('city', (isset($user['city']) ? $user['city'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify address_1'), 'address_1', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'address_1', 'value'=>set_value('address_1', (isset($user['address_1']) ? $user['address_1'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <?php echo form_label(lang('admin verify address_2'), 'address_2', array('class'=>'control-label')); ?>
                     <?php echo form_input(array('name'=>'address_2', 'value'=>set_value('address_2', (isset($user['address_2']) ? $user['address_2'] : '')), 'class'=>'form-control form-control-sm')); ?>
                    </div>
                  </div>
                  <div class="col-md-12 -text-right">
                    <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('core button save'); ?></button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
              <div class="tab-pane fade show" id="v-pills-doc" role="tabpanel" aria-labelledby="v-pills-doc-tab">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <thead>
                          <?php // sortable headers ?>
                          <tr>
                            <th>
                                <?php echo lang('admin verify id_card'); ?>
                            </th>
                            <th>
                                <?php echo lang('admin verify address_user'); ?>
                            </th>
                            <th>
                                <?php echo lang('admin events code'); ?>
                            </th>
                            <th>
                                <?php echo lang('admin events date'); ?>
                            </th>
                            <th class="-text-center">
                                <?php echo lang('admin settings status'); ?>
                            </th>
                            <th class="-text-center">
                                <?php echo lang('admin col actions'); ?>
                            </th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($documents->result() as $view) : ?>
                          <tr>
                            <td><img src="<?php echo base_url();?>upload/verify/<?php echo $view->id_card ?>" class="doc-user-table"></td>
                            <td><img src="<?php echo base_url();?>upload/verify/<?php echo $view->id_address ?>" class="doc-user-table"></td>
                            <td><?php echo $view->code ?></td>
                            <td><?php echo $view->date ?></td>
                            <td class="-text-center">
                             <?if($view->status==0){?>
                              <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                             <?}else{?>
                             <?}?>
                             <?if($view->status==1){?>
                              <span class="badge badge-success"><?php echo lang('admin verify confirmed'); ?></span>
                             <?}else{?>
                             <?}?>
                             <?if($view->status==2){?>
                              <span class="badge badge-danger"><?php echo lang('admin verify rejected'); ?></span>
                             <?}else{?>
                             <?}?>
                          </td>
                           <td class="-text-center"><a href="<?php echo base_url();?>admin/verification/edit/<?php echo $view->id; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="icon-eye icons"></i></a></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
