<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admins button pending'); ?>
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
                        <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans id'), 'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin events date'); ?></label>
                        <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control form-control-sm datepicker-here', 'placeholder'=>lang('admin events date'), 'value'=>set_value('date', ((isset($filters['date'])) ? $filters['date'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin invoices name'); ?></label>
                        <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin invoices name'), 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
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
                        <label class="control-label"><?php echo lang('admins trans receiver'); ?></label>
                        <?php echo form_input(array('name'=>'receiver', 'id'=>'receiver', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans receiver'), 'value'=>set_value('receiver', ((isset($filters['receiver'])) ? $filters['receiver'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admins trans amount'); ?></label>
                        <?php echo form_input(array('name'=>'amount', 'id'=>'amount', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins trans amount'), 'value'=>set_value('amount', ((isset($filters['amount'])) ? $filters['amount'] : '')))); ?>
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
                  <th class="-text-center"></th>
              </tr>
            </thead>
              <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($history as $view) : ?>
              <tr>
                <td><?php echo $view['id']; ?></td>
                <td><?php echo $view['date']; ?></td>
                <td><?php echo $view['name']; ?></td>
                <td><?php echo $view['sender']; ?></td>
                <td><?php echo $view['receiver']; ?></td>
                <td><?php echo $view['amount']; ?> <?if($view['currency']=='debit_base'){?>
                                    <?php echo $this->currencys->display->base_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view['currency']=='debit_extra1'){?>
                                    <?php echo $this->currencys->display->extra1_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view['currency']=='debit_extra2'){?>
                                    <?php echo $this->currencys->display->extra2_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view['currency']=='debit_extra3'){?>
                                    <?php echo $this->currencys->display->extra3_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view['currency']=='debit_extra4'){?>
                                    <?php echo $this->currencys->display->extra4_code ?>
                                <?}else{?>
                                <?}?>
                                <?if($view['currency']=='debit_extra5'){?>
                                    <?php echo $this->currencys->display->extra5_code ?>
                                <?}else{?>
                                <?}?>
                </td>
                <td> <?if($view['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('admins trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('admins trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('admin invoices declined'); ?> </span>
                                <?}else{?>
                                <?}?>
   
                  </td>
                  <td class="-text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                       <a href="<?php echo base_url();?>admin/invoices/delete/<?php echo $view['id']; ?>" onclick ="return confirm('<?php echo sprintf(lang('users msg delete_confirm'), $view['id'] . " " . $view['name']); ?>');" class="btn btn-danger"><i class="icon-close icons"></i></a>
                       <a href="<?php echo base_url();?>admin/invoices/detail/<?php echo $view['id']; ?>" class="btn btn-primary"><i class="icon-eye icons"></i></a>
                    </div>
                  </td>
              </tr>
              <?php endforeach; ?>
              <?php else : ?>
                  <tr>
                      <td colspan="8">
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