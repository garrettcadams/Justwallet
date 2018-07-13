<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-2">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="nav flex-column nav-pills" id="user_menu" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true"><?php echo lang('admin profit 4'); ?></a>
            <a class="nav-link" id="v-pills-logs-tab" data-toggle="pill" href="#v-pills-logs" role="tab" aria-controls="v-pills-logs" aria-selected="true"><?php echo lang('admin profit deposit'); ?></a>
            <a class="nav-link" id="v-pills-billing-tab" data-toggle="pill" href="#v-pills-billing" role="tab" aria-controls="v-pills-billing" aria-selected="true"><?php echo lang('admin profit 5'); ?></a>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  
  <div class="col-md-10">
    <div class="row">
       <div class="col-md-12">
            <div class="collapse" id="search">
              <div class="card card-search">
                <div class="card-body">
                  <?php echo form_open("{$this_url}?{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                  <div class="row">
                    <div class="col-md-12">
                      <h5><?php echo lang('admins log search'); ?></h5>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin profit 15'); ?></label>
                        <?php echo form_input(array('name'=>'start_date', 'id'=>'start_date', 'class'=>'form-control form-control-sm', 'placeholder'=>'2018-02-16', 'value'=>set_value('start_date', ((isset($filters['start_date'])) ? $filters['start_date'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin profit 16'); ?></label>
                        <?php echo form_input(array('name'=>'end_date', 'id'=>'end_date', 'class'=>'form-control form-control-sm', 'placeholder'=>'2018-02-17', 'value'=>set_value('end_date', ((isset($filters['end_date'])) ? $filters['end_date'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-12 -text-right">
                      <button type="submit"  class="btn btn-success btn-sm"> <?php echo lang('admins log search'); ?></button>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
                </div>
              </div>
         </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-title">
            <div class="row">
              <div class="col-md-4">
                <?php echo lang('admin profit 9'); ?>
              </div>
              <div class="col-md-8 -text-right">
                <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content" id="user_menu">
              <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                <div class="row">
                  <div class="col-md-12">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 12') ?></strong></p>
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-8">
                    <canvas id="summary_fee"></canvas>
                  </div>
                  <div class="col-md-2">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <p class="-text-center mt-tab-3"><strong><?php echo lang('admin profit 13') ?></strong></p>
                  </div>
                  <div class="col-md-6">
                    <canvas id="summary_debit_base"></canvas>
                  </div>
                  <div class="col-md-6">
                    <canvas id="summary_debit_extra1"></canvas>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->base_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_fee_confirm_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->extra1_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <canvas id="summary_debit_extra2"></canvas>
                  </div>
                  <div class="col-md-6">
                    <canvas id="summary_debit_extra3"></canvas>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->extra2_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->extra3_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <canvas id="summary_debit_extra4"></canvas>
                  </div>
                  <div class="col-md-6">
                    <canvas id="summary_debit_extra5"></canvas>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->extra4_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo $this->currencys->display->extra5_name ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admins trans deposit') ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans withdrawal') ?></td>
                          <td><?php echo $select_sum_withd_fee_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 6') ?></td>
                          <td><?php echo $select_sum_transfer_fee_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans exchange') ?></td>
                          <td><?php echo $select_sum_exchange_fee_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admins trans external') ?></td>
                          <td><?php echo $select_sum_sci_fee_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
                
              </div>
              <div class="tab-pane fade show" id="v-pills-logs" role="tabpanel" aria-labelledby="v-pills-logs-tab">
                <div class="row">
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-8">
                    <canvas id="deposit_method"></canvas>
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-12">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 11'); ?></strong></p>
                  </div>
                  <div class="col-md-6">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo $paypal['name'] ?></td>
                          <td><?php echo $total_method_1 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $perfect_m['name'] ?></td>
                          <td><?php echo $total_method_2 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $advcash['name'] ?></td>
                          <td><?php echo $total_method_3 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $payeer['name'] ?></td>
                          <td><?php echo $total_method_4 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $skrill['name'] ?></td>
                          <td><?php echo $total_method_5 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $paygol['name'] ?></td>
                          <td><?php echo $total_method_6 ?></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo $swift['name'] ?></td>
                          <td><?php echo $total_method_7 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $local_bank['name'] ?></td>
                          <td><?php echo $total_method_8 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $coinpayments['name'] ?></td>
                          <td><?php echo $total_method_9 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $blockchain['name'] ?></td>
                          <td><?php echo $total_method_10 ?></td>
                        </tr>
                        <tr>
                          <td><?php echo lang('admin profit 10'); ?></td>
                          <td><?php echo $total_method_11 ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <canvas id="deposit"></canvas>
                  </div>
                  <div class="col-md-6">
                    <canvas id="deposit_fee"></canvas>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 2'); ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admin profit 1'); ?></td>
                          <td><?php echo $total_deposits_confirm; ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->base_name ?></td>
                          <td><?php echo $total_deposits_debit_base; ?> / <?php echo $total_deposits_confirm_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra1_name ?></td>
                          <td><?php echo $total_deposits_debit_extra1; ?> / <?php echo $total_deposits_confirm_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra2_name ?></td>
                          <td><?php echo $total_deposits_debit_extra2; ?> / <?php echo $total_deposits_confirm_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra3_name ?></td>
                          <td><?php echo $total_deposits_debit_extra3; ?> / <?php echo $total_deposits_confirm_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra4_name ?></td>
                          <td><?php echo $total_deposits_debit_extra4; ?> / <?php echo $total_deposits_confirm_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra5_name ?></td>
                          <td><?php echo $total_deposits_debit_extra5; ?> / <?php echo $total_deposits_confirm_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 3'); ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo $this->currencys->display->base_name ?></td>
                          <td><?php echo $total_fee_confirm_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra1_name ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra2_name ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra3_name ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra4_name ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra5_name ?></td>
                          <td><?php echo $total_deposits_confirm_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
                <div class="row">
                  <div class="col-md-6">
                    <canvas id="withdrawal"></canvas>
                  </div>
                  <div class="col-md-6">
                    <canvas id="withdrawal_fee"></canvas>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 2'); ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo lang('admin profit 14'); ?></td>
                          <td><?php echo $total_withdrawal_confirm; ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->base_name ?></td>
                          <td><?php echo $total_withdrawal_debit_base; ?> / <?php echo $total_withdrawal_confirm_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra1_name ?></td>
                          <td><?php echo $total_withdrawal_debit_extra1; ?> / <?php echo $total_withdrawal_confirm_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra2_name ?></td>
                          <td><?php echo $total_withdrawal_debit_extra2; ?> / <?php echo $total_withdrawal_confirm_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra3_name ?></td>
                          <td><?php echo $total_withdrawal_debit_extra3; ?> / <?php echo $total_withdrawal_confirm_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra4_name ?></td>
                          <td><?php echo $total_withdrawal_debit_extra4; ?> / <?php echo $total_withdrawal_confirm_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra5_name ?></td>
                          <td><?php echo $total_withdrawal_debit_extra5; ?> / <?php echo $total_withdrawal_confirm_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <p class="-text-center mt-tab"><strong><?php echo lang('admin profit 3'); ?></strong></p>
                    <table class="table table-responsive-lg table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td><?php echo $this->currencys->display->base_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_base; ?> <?php echo $this->currencys->display->base_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra1_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_extra1; ?> <?php echo $this->currencys->display->extra1_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra2_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_extra2; ?> <?php echo $this->currencys->display->extra2_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra3_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_extra3; ?> <?php echo $this->currencys->display->extra3_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra4_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_extra4; ?> <?php echo $this->currencys->display->extra4_code ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $this->currencys->display->extra5_name ?></td>
                          <td><?php echo $total_withdrawal_fee_confirm_debit_extra5; ?> <?php echo $this->currencys->display->extra5_code ?></td>
                        </tr>
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

<script>
		var ctx = document.getElementById("summary_fee");

var data = {
    labels: [
        "<?php echo $this->currencys->display->base_code ?>",
        "<?php echo $this->currencys->display->extra1_code ?>",
        "<?php echo $this->currencys->display->extra2_code ?>",
        "<?php echo $this->currencys->display->extra3_code ?>",
        "<?php echo $this->currencys->display->extra4_code ?>",
        "<?php echo $this->currencys->display->extra5_code ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_fee_confirm_debit_base; ?>, <?php echo $total_deposits_confirm_debit_extra1; ?>, <?php echo $total_deposits_confirm_debit_extra2; ?>, <?php echo $total_deposits_confirm_debit_extra3; ?>, <?php echo $total_deposits_confirm_debit_extra4; ?>, <?php echo $total_deposits_confirm_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>


<script>
		var ctx = document.getElementById("summary_debit_base");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_fee_confirm_debit_base; ?>, <?php echo $select_sum_withd_fee_debit_base; ?>, <?php echo $select_sum_transfer_fee_debit_base; ?>, <?php echo $select_sum_exchange_fee_debit_base; ?>, <?php echo $select_sum_sci_fee_debit_base; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("summary_debit_extra1");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_extra1; ?>, <?php echo $select_sum_withd_fee_debit_extra1; ?>, <?php echo $select_sum_transfer_fee_debit_extra1; ?>, <?php echo $select_sum_exchange_fee_debit_extra1; ?>, <?php echo $select_sum_sci_fee_debit_extra1; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("summary_debit_extra2");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_extra2; ?>, <?php echo $select_sum_withd_fee_debit_extra2; ?>, <?php echo $select_sum_transfer_fee_debit_extra2; ?>, <?php echo $select_sum_exchange_fee_debit_extra2; ?>, <?php echo $select_sum_sci_fee_debit_extra2; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("summary_debit_extra3");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_extra3; ?>, <?php echo $select_sum_withd_fee_debit_extra3; ?>, <?php echo $select_sum_transfer_fee_debit_extra3; ?>, <?php echo $select_sum_exchange_fee_debit_extra3; ?>, <?php echo $select_sum_sci_fee_debit_extra3; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("summary_debit_extra4");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_extra4; ?>, <?php echo $select_sum_withd_fee_debit_extra4; ?>, <?php echo $select_sum_transfer_fee_debit_extra4; ?>, <?php echo $select_sum_exchange_fee_debit_extra4; ?>, <?php echo $select_sum_sci_fee_debit_extra4; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("summary_debit_extra5");

var data = {
    labels: [
        "<?php echo lang('admins trans deposit') ?>",
        "<?php echo lang('admins trans withdrawal') ?>",
        "<?php echo lang('admin profit 6') ?>",
        "<?php echo lang('admins trans exchange') ?>",
        "<?php echo lang('admins trans external') ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_extra5; ?>, <?php echo $select_sum_withd_fee_debit_extra5; ?>, <?php echo $select_sum_transfer_fee_debit_extra5; ?>, <?php echo $select_sum_exchange_fee_debit_extra5; ?>, <?php echo $select_sum_sci_fee_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("deposit");

var data = {
    labels: [
        "<?php echo $this->currencys->display->base_code ?>",
        "<?php echo $this->currencys->display->extra1_code ?>",
        "<?php echo $this->currencys->display->extra2_code ?>",
        "<?php echo $this->currencys->display->extra3_code ?>",
        "<?php echo $this->currencys->display->extra4_code ?>",
        "<?php echo $this->currencys->display->extra5_code ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_deposits_confirm_debit_base; ?>, <?php echo $total_deposits_confirm_debit_extra1; ?>, <?php echo $total_deposits_confirm_debit_extra2; ?>, <?php echo $total_deposits_confirm_debit_extra3; ?>, <?php echo $total_deposits_confirm_debit_extra4; ?>, <?php echo $total_deposits_confirm_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("withdrawal");

var data = {
    labels: [
        "<?php echo $this->currencys->display->base_code ?>",
        "<?php echo $this->currencys->display->extra1_code ?>",
        "<?php echo $this->currencys->display->extra2_code ?>",
        "<?php echo $this->currencys->display->extra3_code ?>",
        "<?php echo $this->currencys->display->extra4_code ?>",
        "<?php echo $this->currencys->display->extra5_code ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_withdrawal_confirm_debit_base; ?>, <?php echo $total_withdrawal_confirm_debit_extra1; ?>, <?php echo $total_withdrawal_confirm_debit_extra2; ?>, <?php echo $total_withdrawal_confirm_debit_extra3; ?>, <?php echo $total_withdrawal_confirm_debit_extra4; ?>, <?php echo $total_withdrawal_confirm_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("deposit_fee");

var data = {
    labels: [
        "<?php echo $this->currencys->display->base_code ?>",
        "<?php echo $this->currencys->display->extra1_code ?>",
        "<?php echo $this->currencys->display->extra2_code ?>",
        "<?php echo $this->currencys->display->extra3_code ?>",
        "<?php echo $this->currencys->display->extra4_code ?>",
        "<?php echo $this->currencys->display->extra5_code ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_fee_confirm_debit_base; ?>, <?php echo $total_deposits_confirm_debit_extra1; ?>, <?php echo $total_deposits_confirm_debit_extra2; ?>, <?php echo $total_deposits_confirm_debit_extra3; ?>, <?php echo $total_deposits_confirm_debit_extra4; ?>, <?php echo $total_deposits_confirm_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("withdrawal_fee");

var data = {
    labels: [
        "<?php echo $this->currencys->display->base_code ?>",
        "<?php echo $this->currencys->display->extra1_code ?>",
        "<?php echo $this->currencys->display->extra2_code ?>",
        "<?php echo $this->currencys->display->extra3_code ?>",
        "<?php echo $this->currencys->display->extra4_code ?>",
        "<?php echo $this->currencys->display->extra5_code ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_withdrawal_fee_confirm_debit_base; ?>, <?php echo $total_withdrawal_fee_confirm_debit_extra1; ?>, <?php echo $total_withdrawal_fee_confirm_debit_extra2; ?>, <?php echo $total_withdrawal_fee_confirm_debit_extra3; ?>, <?php echo $total_withdrawal_fee_confirm_debit_extra4; ?>, <?php echo $total_withdrawal_fee_confirm_debit_extra5; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>

<script>
		var ctx = document.getElementById("deposit_method");

var data = {
    labels: [
        "<?php echo $paypal['name'] ?>",
        "<?php echo $perfect_m['name'] ?>",
        "<?php echo $advcash['name'] ?>",
        "<?php echo $payeer['name'] ?>",
        "<?php echo $skrill['name'] ?>",
        "<?php echo $paygol['name'] ?>",
        "<?php echo $swift['name'] ?>",
        "<?php echo $local_bank['name'] ?>",
        "<?php echo $coinpayments['name'] ?>",
        "<?php echo $blockchain['name'] ?>",
        "<?php echo lang('admin profit 10'); ?>"
    ],
    datasets: [
        {
            data: [<?php echo $total_method_1; ?>, <?php echo $total_method_2; ?>, <?php echo $total_method_3; ?>, <?php echo $total_method_4; ?>, <?php echo $total_method_5; ?>, <?php echo $total_method_6; ?>, <?php echo $total_method_7; ?>, <?php echo $total_method_8; ?>, <?php echo $total_method_9; ?>, <?php echo $total_method_10; ?>, <?php echo $total_method_11; ?>],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e",
                "#795548",
                "#d45425",
                "#7c84b1",
                "#a03d5f",
                "#dbef1d"
                
            ],
            hoverBackgroundColor: [
                "#FF4394",
                "#36A2EB",
                "#FFCE56",
                "#4caf50",
                "#673ab7",
                "#9e9e9e",
                "#795548",
                "#d45425",
                "#7c84b1",
                "#a03d5f",
                "#dbef1d"
            ]
        }]
};

var options = { 
	cutoutPercentage:40,
  legend: {
            position: 'bottom',
        }
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
</script>