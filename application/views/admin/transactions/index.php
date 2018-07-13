<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admins trans all'); ?>
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
                      <h5><?php echo lang('admins log search'); ?></h5>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans id'); ?></label>
                        <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control form-control-sm datepicker-here', 'placeholder'=>lang('admins trans id'), 'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans type'); ?></label>
                            <select name="type" id="type" class="form-control form-control-sm">
                                <option> </option>
                                <option value="1"><?php echo lang('admins trans deposit'); ?></option>
                                <option value="2"><?php echo lang('admins trans withdrawal'); ?></option>
                                <option value="3"><?php echo lang('admins trans transfer'); ?></option>
                                <option value="4"><?php echo lang('admins trans exchange'); ?></option>
                                <option value="5"><?php echo lang('admins trans external'); ?></option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans sender'); ?></label>
                        <?php echo form_input(array('name'=>'sender', 'id'=>'sender', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans sender'), 'value'=>set_value('sender', ((isset($filters['sender'])) ? $filters['sender'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans status'); ?></label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option> </option>
                                <option value="1"><?php echo lang('admins trans pending'); ?></option>
                                <option value="2"><?php echo lang('admins trans success'); ?></option>
                                <option value="3"><?php echo lang('admins trans refund'); ?></option>
                                <option value="4"><?php echo lang('admins trans dispute'); ?></option>
                                <option value="5"><?php echo lang('admins trans blocked'); ?></option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans receiver'); ?></label>
                        <?php echo form_input(array('name'=>'receiver', 'id'=>'receiver', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans receiver'), 'value'=>set_value('receiver', ((isset($filters['receiver'])) ? $filters['receiver'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin events date'); ?></label>
                        <?php echo form_input(array('name'=>'time', 'id'=>'time', 'class'=>'form-control form-control-sm datepicker-here', 'placeholder'=>lang('admin events date'), 'value'=>set_value('time', ((isset($filters['time'])) ? $filters['time'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin events ip'); ?></label>
                        <?php echo form_input(array('name'=>'ip_address', 'id'=>'ip_address', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin events ip'), 'value'=>set_value('ip_address', ((isset($filters['ip_address'])) ? $filters['ip_address'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans comment'); ?></label>
                        <?php echo form_input(array('name'=>'user_comment', 'id'=>'user_comment', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans comment'), 'value'=>set_value('user_comment', ((isset($filters['user_comment'])) ? $filters['user_comment'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans admins_comment'); ?></label>
                        <?php echo form_input(array('name'=>'admin_comment', 'id'=>'admin_comment', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans admins_comment'), 'value'=>set_value('admin_comment', ((isset($filters['admin_comment'])) ? $filters['admin_comment'] : '')))); ?>
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
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
              <tr>
                  <th>
                      <?php echo lang('admins trans id'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans type'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans status'); ?>
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
                   <th class="-text-center">
                      <?php echo lang('admins button currency'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans sum'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans fee'); ?>
                  </th>
                  <th>
                      <?php echo lang('admins trans amount'); ?>
                  </th>
                  <th class="-text-center"></th>
              </tr>
            </thead>
              <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($transactions as $transaction) : ?>
              <tr <?if($transaction['status']==4){?> class="table-danger" <?}else{?><?}?> >
                <td>
                   <?php echo $transaction['id']; ?> <?if($transaction['protect']!="none"){?><i class="icon-shield icons text-success"></i><?}else{?><?}?>
                </td>
                <td<?php echo (($sort == 'type') ? ' class="sorted"' : ''); ?>>
                   <?if($transaction['type']==1){?>
                        <?php echo lang('admins trans deposit'); ?>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['type']==2){?>
                        <?php echo lang('admins trans withdrawal'); ?>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['type']==3){?>
                        <?php echo lang('admins trans transfer'); ?>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['type']==4){?>
                        <?php echo lang('admins trans exchange'); ?>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['type']==5){?>
                        <?php echo lang('admins trans external'); ?>
                   <?}else{?>
                   <?}?>
                </td>
                <td<?php echo (($sort == 'status') ? ' class="sorted"' : ''); ?>>
                   <?if($transaction['status']==1){?>
                  <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['status']==2){?>
                  <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['status']==3){?>
                  <span class="badge badge-info"> <?php echo lang('admins trans refund'); ?> </span>
                   <?}else{?>
                   <?}?>
                  <?if($transaction['status']==4){?>
                  <span class="badge badge-danger"> <?php echo lang('admins trans dispute'); ?> </span>
                   <?}else{?>
                   <?}?>
                   <?if($transaction['status']==5){?>
                  <span class="badge badge-warning"> <?php echo lang('admins trans blocked'); ?> </span>
                   <?}else{?>
                   <?}?>
                </td>
                <td<?php echo (($sort == 'sender') ? ' class="sorted"' : ''); ?>>
                   <?php echo $transaction['sender']; ?>
                </td>
                <td<?php echo (($sort == 'receiver') ? ' class="sorted"' : ''); ?>>
                   <?php echo $transaction['receiver']; ?>
                </td>
                <td<?php echo (($sort == 'time') ? ' class="sorted"' : ''); ?>>
                   <?php echo $transaction['time']; ?>
                </td>
                <td class="-text-center">
                    <?if($transaction['currency']=='debit_base'){?>
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
                <td>
                   <?php echo $transaction['sum']; ?>
                </td>
                <td>
                   <?php echo $transaction['fee']; ?>
                </td>
                <td>
                   <?php echo $transaction['amount']; ?>
                </td>
                <td class="-text-center">
                    <a href="<?php echo $this_url; ?>/edit/<?php echo $transaction['id']; ?>" class="btn btn-sm btn-primary"><i class="icon-eye icons"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="11">
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