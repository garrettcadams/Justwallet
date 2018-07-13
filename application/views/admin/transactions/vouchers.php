<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admins vouchers all'); ?>
          </div>
          <div class="col-md-8 -text-right">
            <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="collapse" id="search">
              <div class="card card-search">
                <div class="card-body">
                  <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
                  <div class="row">
                    <div class="col-md-12">
                      <h6><?php echo lang('admins log search'); ?></h6>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins vouchers code'); ?></label>
                           <?php echo form_input(array('name'=>'code', 'id'=>'code', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins vouchers code'), 'value'=>set_value('code', ((isset($filters['code'])) ? $filters['code'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins trans status'); ?></label>
                            <select class="form-control form-control-sm" name="status">
                              <option></option>
                              <option value="1"><?php echo lang('admins trans pending'); ?></option>
                              <option value="2"><?php echo lang('admins trans success'); ?></option>
                              <option value="3"><?php echo lang('admins trans blocked'); ?></option>
                            </select>
                       </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin events date'); ?></label>
                           <?php echo form_input(array('name'=>'date_creature', 'id'=>'date_creature', 'class'=>'form-control form-control-sm datepicker-here', 'placeholder'=>lang('admin events date'), 'value'=>set_value('date_creature', ((isset($filters['date_creature'])) ? $filters['date_creature'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins vouchers date'); ?></label>
                           <?php echo form_input(array('name'=>'date_activation', 'id'=>'date_activation', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins vouchers date'), 'value'=>set_value('date_activation', ((isset($filters['date_activation'])) ? $filters['date_activation'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins vouchers creator'); ?></label>
                           <?php echo form_input(array('name'=>'creator', 'id'=>'creator', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins vouchers creator'), 'value'=>set_value('creator', ((isset($filters['creator'])) ? $filters['creator'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admins vouchers activator'); ?></label>
                           <?php echo form_input(array('name'=>'activator', 'id'=>'activator', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins vouchers activator'), 'value'=>set_value('activator', ((isset($filters['activator'])) ? $filters['activator'] : '')))); ?>
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
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
              <tr>
                  <th>
                      <?php echo lang('admins vouchers code'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans amount'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins vouchers creator'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins vouchers activator'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events date'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins vouchers date'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans status'); ?>
                  </th>

                  <th class="-text-center"></th>
              </tr>
            </thead>
              <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($transactions as $transaction) : ?>
              
                <tr>
                  
                  <td><?php echo $transaction['code']; ?></td>
                  <td><?php echo $transaction['amount']; ?> <?if($transaction['currency']=='debit_base'){?>
                        <?php echo $this->currencys->display->base_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transaction['currency']=='debit_extra1'){?>
                        <?php echo $this->currencys->display->extra1_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transaction['currency']=='debit_extra2'){?>
                        <?php echo $this->currencys->display->extra2_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transaction['currency']=='debit_extra3'){?>
                        <?php echo $this->currencys->display->extra3_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transaction['currency']=='debit_extra4'){?>
                        <?php echo $this->currencys->display->extra4_code ?>
                    <?}else{?>
                    <?}?>
                    <?if($transaction['currency']=='debit_extra5'){?>
                        <?php echo $this->currencys->display->extra5_code ?>
                    <?}else{?>
                    <?}?>
                  </td>
                  <td><?php echo $transaction['creator']; ?></td>
                  <td><?php echo $transaction['activator']; ?></td>
                  <td><?php echo $transaction['date_creature']; ?></td>
                  <td><?php echo $transaction['date_activation']; ?></td>
                  <td>
                    <?if($transaction['status']==1){?>
                    <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                     <?}else{?>
                     <?}?>
                     <?if($transaction['status']==2){?>
                    <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                     <?}else{?>
                     <?}?>
                     <?if($transaction['status']==3){?>
                    <span class="badge badge-info"> <?php echo lang('admins trans blocked'); ?> </span>
                     <?}else{?>
                     <?}?>
                  </td>
                  <td class="-text-center">
                               
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="<?php echo base_url();?>admin/transactions/block_voucher/<?php echo $transaction['id'] ?>" class="btn btn-danger <?if($transaction['status'] == 3 or $transaction['status'] == 2){?>disabled<?}else{?><?}?>"><i class="icon-lock icons"></i></a>
                            </div>
                               
                        </td>
                  
                </tr>
               
              <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="10">
                          <?php echo lang('core error no_results'); ?>
                      </td>
                  </tr>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>