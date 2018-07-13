<div class="row">
  <div class="col-md-4 mb-2">
    <h5><?php echo lang('users invoices sent'); ?> <?php echo $this->notice->sum_user_invoices($user['username']); ?></h5>
  </div>
  <div class="col-md-8 mb-2 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="#search" data-toggle="collapse" href="#search" aria-expanded="false" aria-controls="search" class="btn btn-outline-secondary btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('users trans search'); ?></a>
      <a href="<?php echo base_url('account/invoices/inbox'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-drawer icons"></i> <?php echo lang('users invoices inbox'); ?></a>
      <a href="<?php echo base_url('account/invoices/sent'); ?>" class="btn btn-outline-secondary btn-sm active"><i class="icon-paper-plane icons"></i> <?php echo lang('users invoices sent'); ?></a>
      <a href="<?php echo base_url('account/invoices/new_invoice'); ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-plus icons"></i> <?php echo lang('users invoices create'); ?></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php echo form_open("{$this_url}?sort={$sort}&dir={$dir}&limit={$limit}&offset=0{$filter}", array('role'=>'form', 'id'=>"filters")); ?>
        <div class="collapse mb-3" id="search">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-12">
                <h5><?php echo lang('users trans search'); ?></h5>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control', 'placeholder'=> '84848',  'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users invoices name'); ?></label>
                <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control', 'placeholder'=> 'Main task',  'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans sender'); ?></label>
                <?php echo form_input(array('name'=>'sender', 'id'=>'sender', 'class'=>'form-control', 'placeholder'=> 'Username',  'value'=>set_value('sender', ((isset($filters['sender'])) ? $filters['sender'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans receiver'); ?></label>
                <?php echo form_input(array('name'=>'receiver', 'id'=>'receiver', 'class'=>'form-control', 'placeholder'=> 'Username',  'value'=>set_value('receiver', ((isset($filters['receiver'])) ? $filters['receiver'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans amount'); ?></label>
                <?php echo form_input(array('name'=>'amount', 'id'=>'amount', 'class'=>'form-control', 'placeholder'=> '1500.75',  'value'=>set_value('amount', ((isset($filters['amount'])) ? $filters['amount'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users trans date'); ?></label>
                <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control datepicker-here', 'placeholder'=> 'YYYY-MM-DD',  'value'=>set_value('date', ((isset($filters['date'])) ? $filters['date'] : '')))); ?>
              </div>
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success btn-sm"><?php echo lang('users trans search'); ?></button>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?>
        <table class="table table-hover table-responsive-lg">
           <thead>
            <th><?php echo lang('users trans id'); ?></th>
            <th><?php echo lang('users trans date'); ?></th>
            <th><?php echo lang('users invoices name'); ?></th>
            <th><?php echo lang('users trans amount'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
          <tbody>
              <?php if ($total) : ?>
                <?php foreach ($history as $view) : ?>
                <tr>
                  <td><?php echo $view['id']; ?></td>
                  <td><?php echo $view['date']; ?></td>
                  <td><?php echo $view['name']; ?></td>
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
                                  <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('users trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-danger"> <?php echo lang('users invoices declined'); ?> </span>
                                <?}else{?>
                                <?}?>
   
                  </td>
                  <td class="text-center"><a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url();?>account/invoices/detail/<?php echo $view['id']; ?>"><i class="icon-eye icons"></i></a></td>
                </tr>
              <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">
                            <?php echo lang('core error no_results'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card-footer text-right">
      <div class="row">
        <div class="col-md-3 text-left">
            <small><?php echo lang('users invoices total'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>