<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin tickets all'); ?>
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
                           <label class="control-label"><?php echo lang('admin events code'); ?></label>
                           <?php echo form_input(array('name'=>'code', 'id'=>'code', 'class'=>'form-control form-control-sm', 'value'=>set_value('code', ((isset($filters['code'])) ? $filters['code'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin tickets date'); ?></label>
                           <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control form-control-sm datepicker-here', 'value'=>set_value('date', ((isset($filters['date'])) ? $filters['date'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin tickets user'); ?></label>
                           <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm', 'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin tickets title'); ?></label>
                           <?php echo form_input(array('name'=>'title', 'id'=>'title', 'class'=>'form-control form-control-sm', 'value'=>set_value('title', ((isset($filters['title'])) ? $filters['title'] : '')))); ?>
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
                          <?php echo lang('admin events code'); ?>
                      </th>
                      <th>
                         <?php echo lang('admin tickets date'); ?>
                      </th>
                      <th>
                          <?php echo lang('admin tickets user'); ?>
                      </th>
                      <th>
                          <?php echo lang('admin tickets title'); ?>
                      </th>
                      <th>
                          <?php echo lang('admin col status'); ?>
                      </th>
                
                      <th class="-text-center">
                          <?php echo lang('admin col actions'); ?>
                      </th>
                  </tr>

            </thead>
              <?php if ($total) : ?>
            <?php foreach ($tickets as $ticket) : ?>
            
            <tr>
              <td><?php echo $ticket['code']; ?></td>
              <td>
                 <?php echo $ticket['date']; ?>
              </td>
              <td>
                 <?php echo $ticket['user']; ?>
              </td>
              <td>
                 <?php echo $ticket['title']; ?>
              </td>
              
              <td>
                 <?if($ticket['status']==0){?>
                  <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($ticket['status']==1){?>
                  <span class="badge badge-success"><?php echo lang('admin tickets processed'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($ticket['status']==2){?>
                  <span class="badge badge-danger"><?php echo lang('admin tickets closed'); ?></span>
                 <?}else{?>
                 <?}?>
              </td>
              <td class="-text-center">
                  <a href="<?php echo $this_url; ?>/edit/<?php echo $ticket['id']; ?>" class="btn btn-sm btn-primary"><i class="icon-eye icons"></i></a>
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