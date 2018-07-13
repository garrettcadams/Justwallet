<div class="row">
  <div class="col-md-12 mb-2">
    <h5><?php echo lang('users title form_withdrawal'); ?></h5>
  </div>
</div>
<?php echo form_open(site_url("account/withdrawal/confirm"), array("" => "")) ?>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="form-group col-md-9">
         <label for="title"><?php echo lang('users transfer amount'); ?></label>
         <input type="text" class="form-control" name="amount" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" placeholder="0.00">
      </div>
      <div class="form-group col-md-3">
            <label><?php echo lang('users trans cyr'); ?></label>
                  <select class="form-control" name="currency">
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
       <div class="col-md-12">
          <fieldset>
            <div class="plan-card-group">
              <?php if ($paypal['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="paypal" id="tradicional" checked/>
                <label for="tradicional" id="radio-label1">
                 <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/paypal.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $paypal['name']; ?>
                      </h5>
                       <?if($enabled_paypal == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $paypal['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($paypal['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($paypal['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($paypal['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($paypal['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($paypal['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($paypal['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $paypal['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $paypal['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $paypal['fee']; ?>% + <?php echo $paypal['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($credit_card['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="credit_card" id="marca-blanca"/>
                <label for="marca-blanca" id="radio-label2">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/visa.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $credit_card['name']; ?>
                      </h5>
                       <?if($enabled_credit_card == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $credit_card['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($credit_card['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($credit_card['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($credit_card['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($credit_card['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($credit_card['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($credit_card['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $credit_card['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $credit_card['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $credit_card['fee']; ?>% + <?php echo $credit_card['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($bitcoin['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="bitcoin" id="full-marca-blanca"/>
                <label for="full-marca-blanca" id="radio-label3">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/btc.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $bitcoin['name']; ?>
                      </h5>
                       <?if($enabled_bitcoin == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $bitcoin['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($bitcoin['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($bitcoin['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($bitcoin['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($bitcoin['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($bitcoin['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($bitcoin['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $bitcoin['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $bitcoin['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $bitcoin['fee']; ?>% + <?php echo $bitcoin['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($swift['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="swift" id="full-marca-blanca2"/>
                <label for="full-marca-blanca2" id="radio-label5">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/swift.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $swift['name']; ?>
                      </h5>
                       <?if($enabled_swift == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $swift['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($swift['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($swift['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($swift['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($swift['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($swift['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($swift['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $swift['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $swift['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $swift['fee']; ?>% + <?php echo $swift['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($skrill['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="skrill" id="full-marca-blanca3"/>
                <label for="full-marca-blanca3" id="radio-label6">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/skrill.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $skrill['name']; ?>
                      </h5>
                       <?if($enabled_skrill == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $skrill['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($skrill['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($skrill['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($skrill['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($skrill['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($skrill['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($skrill['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $skrill['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $skrill['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $skrill['fee']; ?>% + <?php echo $skrill['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($payza['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="payza" id="full-marca-blanca4"/>
                <label for="full-marca-blanca4" id="radio-label7">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/payza.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $payza['name']; ?>
                      </h5>
                       <?if($enabled_payza == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $payza['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($payza['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($payza['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($payza['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($payza['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($payza['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($payza['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $payza['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $payza['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $payza['fee']; ?>% + <?php echo $payza['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($advcash['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="advcash" id="full-marca-blanca5"/>
                <label for="full-marca-blanca5" id="radio-label8">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/advcash.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $advcash['name']; ?>
                      </h5>
                       <?if($enabled_advcash == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $advcash['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($advcash['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($advcash['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($advcash['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($advcash['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($advcash['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($advcash['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $advcash['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $advcash['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $advcash['fee']; ?>% + <?php echo $advcash['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
              <?php if ($perfect_m['status'] == 1) : ?>
              <div class="radio-card">
                <input type="radio" class="planes-radio" name="method" value="perfect_m" id="full-marca-blanca6"/>
                <label for="full-marca-blanca6" id="radio-label9">
                  <div class="row">
                    <div class="col-md-1 mt-3 mb-3 text-center">
                      <img src="<?php echo base_url();?>assets/themes/account/img/pay-icon/pm.png" class="win-img">
                    </div>
                     <div class="col-md-8 mt-12px mb-3">
                      <h5 class="mb-0">
                        <?php echo $perfect_m['name']; ?>
                      </h5>
                       <?if($enabled_perfect_m == FALSE){?><small class="text-danger"><?php echo lang('users withdrawal verify_error'); ?></small><?}else{?><small class="text-muted"><?php echo lang('users withdrawal terms'); ?> <?php echo $perfect_m['terms']; ?>. <?php echo lang('users withdrawal available'); ?> <?if($perfect_m['debit_base'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_base']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_base']; ?>"><?php echo $this->currencys->display->base_code ?></a><?}else{?><?}?> <?if($perfect_m['debit_extra1'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_extra1']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_extra1']; ?>"><?php echo $this->currencys->display->extra1_code ?></a><?}else{?><?}?> <?if($perfect_m['debit_extra2'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_extra2']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_extra2']; ?>"><?php echo $this->currencys->display->extra2_code ?></a><?}else{?><?}?> <?if($perfect_m['debit_extra3'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_extra3']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_extra3']; ?>"><?php echo $this->currencys->display->extra3_code ?></a><?}else{?><?}?> <?if($perfect_m['debit_extra4'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_extra4']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_extra4']; ?>"><?php echo $this->currencys->display->extra4_code ?></a><?}else{?><?}?> <?if($perfect_m['debit_extra5'] == 1){?><a href="#" data-tooltip="<?php echo lang('users withdrawal minimum'); ?>: <?php echo $perfect_m['minimum_debit_extra5']; ?> <?php echo lang('users withdrawal maximum'); ?>: <?php echo $perfect_m['maximum_debit_extra5']; ?>"><?php echo $this->currencys->display->extra5_code ?></a><?}else{?><?}?></small><?}?>
                    </div>
                   <div class="col-md-3 mt-22px mb-3 text-right">
                     <span class="badge badge-secondary"><?php echo $perfect_m['fee']; ?>% + <?php echo $perfect_m['fee_fix']; ?></span>
                   </div>
                  </div>
                </label>
              </div>
              <?php endif; ?>
            </div>
          </fieldset>
       </div>
       <div class="col-md-12 text-right mt-2">
         <button type="submit" class="btn btn-success"><?php echo lang('users transfer send'); ?></button>
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?> 