<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admins button all_dispute'); ?>
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
                         <label class="control-label"><?php echo lang('admins disputes time_dispute'); ?></label>
                         <?php echo form_input(array('name'=>'time_dispute', 'id'=>'time_dispute', 'class'=>'form-control form-control-sm datepicker-here', 'placeholder'=>lang('admins disputes time_dispute'), 'value'=>set_value('time_dispute', ((isset($filters['time_dispute'])) ? $filters['time_dispute'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('admins disputes defendant'); ?></label>
                         <?php echo form_input(array('name'=>'defendant', 'id'=>'defendant', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins disputes defendant'), 'value'=>set_value('defendant', ((isset($filters['defendant'])) ? $filters['defendant'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('admins disputes claimant'); ?></label>
                         <?php echo form_input(array('name'=>'claimant', 'id'=>'claimant', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins disputes claimant'), 'value'=>set_value('claimant', ((isset($filters['claimant'])) ? $filters['dclaimant'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('admins disputes id_tran'); ?></label>
                         <?php echo form_input(array('name'=>'transaction', 'id'=>'transaction', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admins disputes id_tran'), 'value'=>set_value('transaction', ((isset($filters['transaction'])) ? $filters['transaction'] : '')))); ?>
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
                    <?php // sortable headers ?>
                <tr>
                        <th>
                            <?php echo lang('admins trans id'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes id_tran'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes time_dispute'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins tickets title'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes claimant'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes defendant'); ?>
                        </th>
                        <th>
                            <?php echo lang('admins disputes status'); ?>
                        </th>
                        <th></th>
                    </tr>

              </thead>
              <tbody>
              <?php // data rows ?>
                <?php if ($total) : ?>
                <?php foreach ($disputes as $dispute) : ?>

                <tr>

                  <td>
                     <?php echo $dispute['id']; ?>
                  </td>
                  <td>
                     <?php echo $dispute['transaction']; ?>
                  </td>
                  <td>
                     <?php echo $dispute['time_dispute']; ?>
                  </td>
                  <td>
                    <?if($dispute['title'] == 1){?>
                    <?php echo lang('admin disputes not_received'); ?>
                    <?}else{?>
                    <?}?><?if($dispute['title'] == 2){?>
                      <?php echo lang('admin disputes not_desk'); ?>
                    <?}else{?>
                    <?}?>
                  </td>
                  <td>
                     <?php echo $dispute['claimant']; ?>
                  </td>
                  <td>
                     <?php echo $dispute['defendant']; ?>
                  </td>
                  <td>
                     <?if($dispute['status']==1){?>
                      <span class="badge badge-primary"><?php echo lang('admins disputes open'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($dispute['status']==2){?>
                      <span class="badge badge-danger"><?php echo lang('admins disputes claim'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($dispute['status']==3){?>
                      <span class="badge badge-warning"><?php echo lang('admins disputes rejected'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($dispute['status']==4){?>
                      <span class="badge badge-success"><?php echo lang('admins disputes satisfied'); ?></span>
                     <?}else{?>
                     <?}?>
                  </td>
                  <td class="-text-center">
                      <a href="<?php echo $this_url; ?>/detail/<?php echo $dispute['id']; ?>" class="btn btn-sm btn-primary"><i class="icon-eye icons"></i></a>
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