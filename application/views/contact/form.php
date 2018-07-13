<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="header-st2 mb-head">
			<div class="container">
				<div class="row">
          <div class="col-md-2">
            
          </div>
          <div class="col-md-8">
            <div class="card mb-5">
              <?php echo form_open('', array('role'=>'form')); ?>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <h5 class="text-center">
                      <?php echo lang('contact title'); ?>
                    </h5>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('contact input name'), 'name', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'name', 'value'=>set_value('name'), 'class'=>'form-control')); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php echo form_label(lang('contact input email'), 'email', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'email', 'value'=>set_value('email'), 'class'=>'form-control')); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <?php echo form_label(lang('contact input title'), 'title', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_input(array('name'=>'title', 'value'=>set_value('title'), 'class'=>'form-control')); ?>
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="form-group">
                      <?php echo form_label(lang('contact input message'), 'message', array('class'=>'control-label')); ?>
                      <span class="required">*</span>
                      <?php echo form_textarea(array('name'=>'message', 'value'=>set_value('message'), 'rows'=> '5', 'class'=>'form-control')); ?>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="g-recaptcha text-center" data-sitekey="<?php echo $this->settings->google_site_key; ?>"></div>
                  </div>
                  <div class="col-md-12 text-right">
                      <button type="submit" name="submit" class="btn btn-success"> Send</button>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
          <div class="col-md-2">
            
          </div>
        </div>
  </div>
</div>

<div class="container">
			<div class="row mt-10">
				<div class="col-md-12 mt-5">
					<h2 class="text-center">
						<?php echo lang('contact title us'); ?>
					</h2>
				</div>
        <div class="col-md-4 mt-5">
					<div class="text-center">
						<h1>
              <i class="icon-envelope icons text-primary"></i>
            </h1>
						<h5 class="mt-3"><?php echo $this->settings->site_email; ?></h5>
						<p class="mt-3"><?php echo lang('contact title mail'); ?></p>
					</div>
				</div>
        
				<div class="col-md-4 mt-5">
					<div class="text-center">
						<h1>
              <i class="icon-phone icons text-primary"></i>
            </h1>
						<h5 class="mt-3"><?php echo $this->settings->phone; ?></h5>
						<p class="mt-3"><?php echo lang('contact title phone'); ?></p>
					</div>
				</div>
        
        <div class="col-md-4 mt-5">
					<div class="text-center">
						<h1>
              <i class="icon-social-skype icons text-primary"></i>
            </h1>
						<h5 class="mt-3"><?php echo $this->settings->skype; ?></h5>
						<p class="mt-3"><?php echo lang('contact title skype'); ?></p>
					</div>
				</div>
        
			</div>
		</div>

<div class="top-merchant mt-5">
			<div class="container">
				<div class="row">
					<div class="col-md-12 mt-4">
						<h4 class="text-center">
							<?php echo lang('contact title create'); ?>
						</h4>
					</div>
					<div class="col-md-12 mt-4 mb-4">
						<h4 class="text-center">
							<a href="#" class="btn btn-success btn-lg"><?php echo lang('contact title sign'); ?></a>
						</h4>
					</div>
				</div>
			</div>
		</div>