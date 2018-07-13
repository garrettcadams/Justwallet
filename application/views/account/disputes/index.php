<div class="row">
  <div class="col-md-8 mb-2">
    <h5><?php echo lang('users dispute list'); ?></h5>
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
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users dispute id'); ?></label>
                <?php echo form_input(array('name'=>'id', 'id'=>'id', 'class'=>'form-control', 'placeholder'=> '84848',  'value'=>set_value('id', ((isset($filters['id'])) ? $filters['id'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users dispute date'); ?></label>
                <?php echo form_input(array('name'=>'time_dispute', 'id'=>'time_dispute', 'class'=>'form-control datepicker-here', 'placeholder'=> 'YYYY-MM-DD',  'value'=>set_value('time_dispute', ((isset($filters['time_dispute'])) ? $filters['time_dispute'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users history id_trans'); ?></label>
                <?php echo form_input(array('name'=>'transaction', 'id'=>'transaction', 'class'=>'form-control', 'placeholder'=> '3235',  'value'=>set_value('transaction', ((isset($filters['transaction'])) ? $filters['transaction'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users withdrawal amount'); ?></label>
                <?php echo form_input(array('name'=>'amount', 'id'=>'amount', 'class'=>'form-control', 'placeholder'=> '140.00',  'value'=>set_value('amount', ((isset($filters['amount'])) ? $filters['amount'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users disputes claimant'); ?></label>
                <?php echo form_input(array('name'=>'claimant', 'id'=>'claimant', 'class'=>'form-control', 'placeholder'=> 'username',  'value'=>set_value('claimant', ((isset($filters['claimant'])) ? $filters['claimant'] : '')))); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="id"><?php echo lang('users disputes defendant'); ?></label>
                <?php echo form_input(array('name'=>'defendant', 'id'=>'defendant', 'class'=>'form-control', 'placeholder'=> 'username',  'value'=>set_value('defendant', ((isset($filters['defendant'])) ? $filters['defendant'] : '')))); ?>
              </div>
              <div class="form-group col-md-12">
                <label for="id"><?php echo lang('users desc dispute'); ?></label>
                <?php echo form_input(array('name'=>'message', 'id'=>'message', 'class'=>'form-control', 'value'=>set_value('message', ((isset($filters['message'])) ? $filters['message'] : '')))); ?>
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
            <th><?php echo lang('users dispute id'); ?></th>
            <th><?php echo lang('users dispute date'); ?></th>
            <th><?php echo lang('users history id_trans'); ?></th>
            <th><?php echo lang('users withdrawal amount'); ?></th>
            <th><?php echo lang('users trans status'); ?></th>
            <th></th>
          </thead>
          <tbody>
            <?php if ($total) : ?>
            <?php foreach ($dispute as $view) : ?>
            
            <tr>
              <td><?php echo $view['id']; ?></td>
              <td><?php echo $view['time_dispute']; ?></td>
              <td><?php echo $view['transaction']; ?></td>
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
                                <?}?></td>
            <td>
              <?if($view['status']==1){?>
                                  <span class="badge badge-primary"> <?php echo lang('users disputes open'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==2){?>
                                  <span class="badge badge-danger"> <?php echo lang('users disputes claim'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==3){?>
                                  <span class="badge badge-warning"> <?php echo lang('users disputes rejected'); ?> </span>
                                <?}else{?>
                                <?}?>
                                <?if($view['status']==4){?>
                                  <span class="badge badge-success"> <?php echo lang('users disputes satisfied'); ?> </span>
                                <?}else{?>
                                <?}?>
            </td>
              
              <td class="text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <a href="/account/disputes/detail/<?php echo $view['id']; ?>" class="btn btn-outline-secondary btn-sm"><i class="icon-eye icons"></i></a>
                  <a class="btn btn-outline-info btn-sm" data-toggle="collapse" href="#id-<?php echo $view['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="icon-info icons"></i></a>
                </div>
              </td>
           </tr>
            
            <tr>
                  <td class="info-card" colspan="6">
                     <div class="collapse" id="id-<?php echo $view['id']; ?>">
                            <div class="card card-body mt-2 mb-2">
                              <div class="row">
                                <div class="col-md-12">
                                  <h6>
                                    <?if($view['title'] == 1){?>
                                    <?php echo lang('users history not_received'); ?>
                                    <?}else{?>
                                    <?}?><?if($view['title'] == 2){?>
                                      <?php echo lang('users history not_desk'); ?>
                                    <?}else{?>
                                    <?}?>
                                  </h6>
                                  <p>
                                    <?php echo $view['message']; ?>
                                  </p>
                                </div>
                              </div>
                            </div>
                      </div>
                    </td>
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
            <small><?php echo lang('users total disputes'); ?> <?php echo $total; ?></small>
        </div>
        <div class="col-md-9">
            <?php echo $pagination; ?>
        </div>
      </div>
  </div>
</div>