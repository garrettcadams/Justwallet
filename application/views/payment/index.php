

<div class="row mt-35px">
  <div class="col-md-3">

  </div>
  <div class="col-md-6">
    <div class="card box-shadow-sci mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="text-center">
              <img src="<?php echo base_url();?>upload/logo/<?php echo $merchant['logo'];?>" class="logo-merchant-sci">
              <h5 class="mt-2"><?php echo $merchant['name'];?></h5>
            </div>
          </div>
          <div class="col-md-12">
            <div class="text-center">
              <h5 class="text-success"><?php echo $total_amount;?> <?php echo $symbol;?> <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="icon-question h6 icons text-info"></i></a></h5>
              <p class="text-muted mb-0"><?php echo $item_name;?></p>
            </div>
						<div class="collapse mt-2" id="collapseExample">
							<div class="card card-body text-white bg-info">
								<div class="row">
									<div class="col-md-4">
										<strong><?php echo lang('users trans amount'); ?>:</strong> <p class="mb-0"><?php echo $amount;?> <?php echo $symbol;?></p>
									</div>
									<div class="col-md-4">
										<strong><?php echo lang('users trans fee'); ?>:</strong> <p class="mb-0"><?php echo $total_fee;?> <?php echo $symbol;?></p>
									</div>
									<div class="col-md-4">
										<strong><?php echo lang('users shops total'); ?>:</strong> <p class="mb-0"><?php echo $total_amount;?> <?php echo $symbol;?></p>
									</div>
								</div>
							</div>
						</div>
          </div>
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-body">
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?if($merchant['test_mode'] == 1){?>
                    <?php echo form_open('sci/test_mode', array('class'=>'')); ?>
                      <p class="text-center"><strong><?php echo lang('users sci test_not_valid');?></strong></p>
                      <input type="hidden" name="merchant" value="<?php echo $merchant['id'];?>">
                      <input type="hidden" name="amount" value="<?php echo $amount;?>">
                      <input type="hidden" name="currency" value="<?php echo $currency;?>">
                      <input type="hidden" name="item_name" value="<?php echo $item_name;?>">
                      <input type="hidden" name="custom" value="<?php echo $custom;?>">
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <button type="submit" class="btn btn-success mt-1"><?php echo lang('users deposit payment'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <?}else{?>
                      <p class="text-center"><strong>Login in account</strong></p>
                      <?php echo form_open('sci/start_payment', array('class'=>'')); ?>
                      <input type="hidden" name="merchant" value="<?php echo $merchant['id'];?>">
                      <input type="hidden" name="amount" value="<?php echo $amount;?>">
                      <input type="hidden" name="currency" value="<?php echo $currency;?>">
                      <input type="hidden" name="item_name" value="<?php echo $item_name;?>">
                      <input type="hidden" name="custom" value="<?php echo $custom;?>">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label for="exampleInputEmail1"><?php echo lang('core button username_email'); ?></label>
                          <?php echo form_input(array('name'=>'username', 'id'=>'username', 'class'=>'form-control', 'placeholder'=>lang('core button enter_username'), 'maxlength'=>256)); ?>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="exampleInputPassword1"><?php echo lang('core button password'); ?></label>
                          <?php echo form_password(array('name'=>'password', 'id'=>'password', 'class'=>'form-control', 'placeholder'=>lang('core button enter_password'), 'maxlength'=>72, 'autocomplete'=>'off')); ?>
                        </div>

                        <div class="col-md-7">
                          <small><a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo lang('users sci other'); ?></a></small></br>
                          <small><a href="<?php echo $merchant['fail_link'];?>"><?php echo lang('users sci return'); ?></a></small>
                        </div>
                        <div class="col-md-5 text-right">
                          <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success mt-1"><?php echo lang('users deposit payment'); ?></button>
                        </div>
                      </div>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('users sci check_captcha'); ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="g-recaptcha" data-sitekey="<?php echo $this->settings->google_site_key; ?>"></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?php echo lang('users verifi close'); ?></button>
                              <button type="submit" class="btn btn-primary btn-sm"><?php echo lang('users transfer protect_confirm'); ?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?>
                    <?}?>
                    
                  </div>
                  <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row text-center">
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/paypal.png" class="win-img">
                      </div>
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/visa.png" class="win-img">
                      </div>
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/pm.png" class="win-img">
                      </div>
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/advcash.png" class="win-img">
                      </div>
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/payeer.png" class="win-img">
                      </div>
                      <div class="col-md-2">
                        <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/btc.png" class="win-img">
                      </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                      <div class="col-md-2 mt-3">
                        <span class="step-badge">1</span>
                      </div>
                      <div class="col-md-10">
                        <p class="mb-1"><strong><?php echo lang('users sci step1_title'); ?></strong></p>
                        <p><?php echo lang('users sci step1_info'); ?></p>
                      </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-2 mt-3">
                        <span class="step-badge-2">2</span>
                      </div>
                      <div class="col-md-10">
                        <p class="mb-1"><strong><?php echo lang('users sci step2_title'); ?></strong></p>
                        <p><?php echo lang('users sci step2_info'); ?></p>
                      </div>
                    </div>
                    <div class="row mt-4">
                      <div class="col-md-2 mt-3">
                        <span class="step-badge-2">3</span>
                      </div>
                      <div class="col-md-10">
                        <p class="mb-1"><strong><?php echo lang('users sci step3_title'); ?></strong></p>
                        <p><?php echo lang('users sci step3_info'); ?></p>
                      </div>
                    </div>
                    <div class="row text-center mt-3">
                      <div class="col-md-12">
                        <a href="<?php echo base_url('user/register'); ?>" class="btn btn-success"><?php echo lang('users sci sign_up'); ?></a></br>
                        <small><a class="text-muted" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?php echo lang('users sci return_login'); ?></a></small>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-md-6">
            <i class="icon-shield icons text-success"></i> <small><a href="#" class="text-success"><?php echo lang('users sci under_protect'); ?></a></small>
          </div>
          <div class="col-md-6 text-right">
            <div class="dropdown dropup">
								<button id="session-language" class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php echo lang('core button language'); ?>
								</button>
								<div id="session-language-dropdown" class="dropdown-menu" aria-labelledby="session-language">
									<?php foreach ($this->languages as $key=>$name) : ?>
									<a class="dropdown-item" href="#" rel="<?php echo $key; ?>">
											<?php if ($key == $this->session->language) : ?>
													<i class="icon-arrow-right icons"></i>
											<?php endif; ?>
											<?php echo $name; ?>
									</a>
									<?php endforeach; ?>
								</div>
								
							</div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
   <div class="col-md-3">
    
  </div>
  <div class="col-md-12 text-center">
    <small><a class="text-muted" href="<?php echo base_url('user/register'); ?>"><?php echo lang('users sci accept'); ?></a></small>
  </div>
  <div class="col-md-12 text-center mb-4">
    <small><a class="text-muted" href="<?php echo base_url('how-it-works'); ?>"><?php echo date('Y') ?>, <?php echo $this->settings->site_name; ?></a></small>
  </div>
</div>