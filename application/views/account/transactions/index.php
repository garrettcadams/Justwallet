<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users trans all'); ?></h5>
  </div>
  <div class="col-md-4 mb-2 text-right">
    <a href="#search" data-toggle="collapse" href="#search" aria-expanded="false" aria-controls="search" class="btn btn-outline-secondary btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('users trans search'); ?></a>
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
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control', 'placeholder'=> '84848',  'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans sender'); ?></label>
                <?php echo form_input(array('name'=>'sender', 'id'=>'sender', 'class'=>'form-control', 'placeholder'=> 'Username',  'value'=>set_value('sender', ((isset($filters['sender'])) ? $filters['sender'] : '')))); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans receiver'); ?></label>
                <?php echo form_input(array('name'=>'receiver', 'id'=>'receiver', 'class'=>'form-control', 'placeholder'=> 'Username',  'value'=>set_value('receiver', ((isset($filters['receiver'])) ? $filters['receiver'] : '')))); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans sum'); ?></label>
                <?php echo form_input(array('name'=>'sum', 'id'=>'sum', 'class'=>'form-control', 'placeholder'=> '1500.75',  'value'=>set_value('sum', ((isset($filters['sum'])) ? $filters['sum'] : '')))); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans date'); ?></label>
                <?php echo form_input(array('name'=>'time', 'id'=>'time', 'class'=>'form-control datepicker-here', 'placeholder'=> 'YYYY-MM-DD',  'value'=>set_value('time', ((isset($filters['time'])) ? $filters['time'] : '')))); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="id"><?php echo lang('users trans comment'); ?></label>
                <?php echo form_input(array('name'=>'user_comment', 'id'=>'user_comment', 'class'=>'form-control', 'value'=>set_value('user_comment', ((isset($filters['user_comment'])) ? $filters['user_comment'] : '')))); ?>
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
            <th></th>
            <th><?php echo lang('users trans date'); ?></th>
            <th><?php echo lang('users trans type'); ?></th>
            <th><?php echo lang('users shops total'); ?></th>
            <th class="text-center"><?php echo lang('users trans cyr'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
           <tbody>
              <?php if ($total) : ?>
                <?php foreach ($history as $view) : ?>
                <tr>
                  <td><?php echo $view['id']; ?></td>
                  <td class="text-center">
                  <a href="#" data-tooltip-sender="<?php echo $view['sender']; ?>">
                     <img src="<?php echo $avatar = $this->notice->check_img($view['type'], $view['sender'], $view['id']); ?>" class="win-img-30">
                  </a>
                  </td>
                  <td><?php echo $view['time']; ?></td>
                  
                  <td>
                    <?if($view['type']==1){?>
                                  <?php echo lang('users trans deposit'); ?>
                                <?}else{?>
                                <?}?>
                               <?if($view['type']==2){?>
                                  <?php echo lang('users trans withdrawal'); ?>
                                <?}else{?>
                                <?}?>
                               <?if($view['type']==3){?>
                                  <?php echo lang('users trans transfer'); ?>
                                <?}else{?>
                                <?}?>
                               <?if($view['type']==4){?>
                                  <?php echo lang('users trans exchange'); ?>
                                <?}else{?>
                                <?}?>
                               <?if($view['type']==5){?>
                                  <?php echo lang('users trans external'); ?>
                                <?}else{?>
                                <?}?>
                  </td>
                  <td><?php echo $this->notice->check_amount_transaction($view['sum'], $view['amount'], $view['fee'], $view['sender'], $view['receiver'], $view['type'], $user['username'], $view['id']); ?></td>
                  <td class="text-center">
                    <?if($view['currency']=='debit_base'){?>
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
                  <td>
                    <?if($view['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('users trans pending'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-success"> <?php echo lang('users trans success'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-secondary"> <?php echo lang('users trans refund'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==4){?>
                                  <span class="badge badge-danger"> <?php echo lang('users trans dispute'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==5){?>
                                  <span class="badge badge-secondary"> <?php echo lang('users trans blocked'); ?> </span>
                                <?}else{?>
                                <?}?>
                  </td>
                  <td class="text-center"><a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url();?>account/transactions/detail/<?php echo $view['id']; ?>"><i class="icon-eye icons"></i></a></td>
                </tr>

              <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">
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
            <small><?php echo lang('users total transaction'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>