<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <?php echo lang('admin settings all_currency'); ?>
      </div>
      <div class="card-body">
        <?php echo form_open(site_url("admin/settings/update_currencys"), array("" => "")) ?>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
                <?php // sortable headers ?>
                  <tr>
                    <th class="-text-center"><?php echo lang('admin settings activate'); ?></th>
                    <th><?php echo lang('admin settings name'); ?></th>
                    <th><?php echo lang('admin settings code'); ?></th>
                    <th><?php echo lang('admin settings used_rate'); ?></th>
                    <th><?php echo lang('admin settings rate'); ?></th>
                    <th><?php echo lang('admin settings api_rate'); ?></th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" value="1" checked disabled/></td>
                  <td><input type="text" class="form-control form-control-sm" id="base_name" name="base_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->base_name ?>"> </td>
                  <td colspan="4"><input type="text" class="form-control form-control-sm" id="base_code" name="base_code" placeholder="USD Wallet" value="<?php echo $this->currencys->display->base_code ?>"> </td>
                </tr>
                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" name="extra1_check" value="1" <?php if($this->currencys->display->extra1_check) echo "checked" ?>/>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra1_name" name="extra1_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->extra1_name ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra1_code" name="extra1_code" placeholder="USD" value="<?php echo $this->currencys->display->extra1_code ?>"> </td>
                  <td>
                  <select name="api_extra1" class="form-control form-control-sm">
                    <option <?if($this->currencys->display->api_extra1=="0"){?>selected<?}else{?><?}?> value="0">Local</option>
                    <option <?if($this->currencys->display->api_extra1=="1"){?>selected<?}else{?><?}?> value="1">API</option>
                  </select>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra1_rate" name="extra1_rate" placeholder="50.00" value="<?php echo $this->currencys->display->extra1_rate ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" value="<?php echo $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra1_code); ?>" disabled></td>
                </tr>

                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" name="extra2_check" value="1" <?php if($this->currencys->display->extra2_check) echo "checked" ?>/>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra2_name" name="extra2_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->extra2_name ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra2_code" name="extra2_code" placeholder="USD" value="<?php echo $this->currencys->display->extra2_code ?>"> </td>
                  <td>
                  <select name="api_extra2" class="form-control form-control-sm">
                    <option <?if($this->currencys->display->api_extra2=="0"){?>selected<?}else{?><?}?> value="0">Local</option>
                    <option <?if($this->currencys->display->api_extra2=="1"){?>selected<?}else{?><?}?> value="1">API</option>
                  </select>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra2_rate" name="extra2_rate" placeholder="50.00" value="<?php echo $this->currencys->display->extra2_rate ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" value="<?php echo $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra2_code); ?>" disabled></td>
                </tr>

                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" name="extra3_check" value="1" <?php if($this->currencys->display->extra3_check) echo "checked" ?>/>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra3_name" name="extra3_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->extra3_name ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra3_code" name="extra3_code" placeholder="USD" value="<?php echo $this->currencys->display->extra3_code ?>"> </td>
                  <td>
                  <select name="api_extra3" class="form-control form-control-sm">
                    <option <?if($this->currencys->display->api_extra3=="0"){?>selected<?}else{?><?}?> value="0">Local</option>
                    <option <?if($this->currencys->display->api_extra3=="1"){?>selected<?}else{?><?}?> value="1">API</option>
                  </select>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra3_rate" name="extra3_rate" placeholder="50.00" value="<?php echo $this->currencys->display->extra3_rate ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" value="<?php echo $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra3_code); ?>" disabled></td>
                </tr>

                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" name="extra4_check" value="1" <?php if($this->currencys->display->extra4_check) echo "checked" ?>/>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra4_name" name="extra4_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->extra4_name ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra4_code" name="extra4_code" placeholder="USD" value="<?php echo $this->currencys->display->extra4_code ?>"> </td>
                  <td>
                  <select name="api_extra4" class="form-control form-control-sm">
                    <option <?if($this->currencys->display->api_extra4=="0"){?>selected<?}else{?><?}?> value="0">Local</option>
                    <option <?if($this->currencys->display->api_extra4=="1"){?>selected<?}else{?><?}?> value="1">API</option>
                  </select>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra4_rate" name="extra4_rate" placeholder="50.00" value="<?php echo $this->currencys->display->extra4_rate ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" value="<?php echo $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra4_code); ?>" disabled></td>
                </tr>

                <tr>
                  <td class="-text-center"><input type="checkbox" class="js-switch primary" name="extra5_check" value="1" <?php if($this->currencys->display->extra5_check) echo "checked" ?>/>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra5_name" name="extra5_name" placeholder="USD Wallet" value="<?php echo $this->currencys->display->extra5_name ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra5_code" name="extra5_code" placeholder="USD" value="<?php echo $this->currencys->display->extra5_code ?>"> </td>
                  <td>
                  <select name="api_extra5" class="form-control form-control-sm">
                    <option <?if($this->currencys->display->api_extra5=="0"){?>selected<?}else{?><?}?> value="0">Local</option>
                    <option <?if($this->currencys->display->api_extra5=="1"){?>selected<?}else{?><?}?> value="1">API</option>
                  </select>
                  </td>
                  <td><input type="text" class="form-control form-control-sm" id="extra5_rate" name="extra5_rate" placeholder="50.00" value="<?php echo $this->currencys->display->extra5_rate ?>"> </td>
                  <td><input type="text" class="form-control form-control-sm" value="<?php echo $this->fixer->get_rates($this->currencys->display->base_code, $this->currencys->display->extra5_code); ?>" disabled></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo lang('admin settings fix_fee'); ?></label>
              <span class="required">*</span>
              <input type="text" class="form-control form-control-sm" name="fee_fix" value="<?php echo $this->currencys->display->fee_fix ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><?php echo lang('admin settings fee'); ?>, %</label>
              <span class="required">*</span>
              <input type="text" class="form-control form-control-sm" name="fee" value="<?php echo $this->currencys->display->fee ?>">
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
