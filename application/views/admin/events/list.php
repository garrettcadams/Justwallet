<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin events all'); ?>
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
                          <label class="control-label"><?php echo lang('admin user username'); ?></label>
                          <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm',  'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                          <label class="control-label"><?php echo lang('admin events ip'); ?></label>
                          <?php echo form_input(array('name'=>'ip', 'id'=>'ip', 'class'=>'form-control form-control-sm',  'value'=>set_value('ip', ((isset($filters['ip'])) ? $filters['ip'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                          <label class="control-label"><?php echo lang('admin events date'); ?></label>
                          <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control form-control-sm datepicker-here',  'value'=>set_value('date', ((isset($filters['date'])) ? $filters['date'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                          <label class="control-label"><?php echo lang('admin events code'); ?></label>
                          <?php echo form_input(array('name'=>'code', 'id'=>'code', 'class'=>'form-control form-control-sm',  'value'=>set_value('code', ((isset($filters['code'])) ? $filters['code'] : '')))); ?>
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
                      <?php echo lang('admin events id'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events code'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin user username'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events date'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events ip'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events event'); ?>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if ($total) : ?>
                <?php foreach ($logs as $log) : ?>
                  <tr>
                    <td width="5%">
                        <?php echo $log['id']; ?>
                    </td>
                     <td width="10%">
                         <?php echo $log['code']; ?>
                    </td>
                     <td width="15%">
                         <?php echo $log['user']; ?>
                    </td>
                    <td width="20%">
                        <?php echo $log['date']; ?>
                    </td>
                    
                    <td width="15%">
                        <?php echo $log['ip']; ?>
                    </td>
                    <td width="15%">
                      <?php if ($log['type'] == 1) : ?>
                      <?php echo lang('admin events_status 1'); ?>
                      <?php elseif ($log['type'] == 2) : ?>
                      <?php echo lang('admin events_status 2'); ?>
                      <?php elseif ($log['type'] == 3) : ?>
                      <?php echo lang('admin events_status 3'); ?>
                      <?php elseif ($log['type'] == 4) : ?>
                      <?php echo lang('admin events_status 4'); ?>
                      <?php elseif ($log['type'] == 5) : ?>
                      <?php echo lang('admin events_status 5'); ?>
                      <?php elseif ($log['type'] == 6) : ?>
                      
                      <?php endif; ?>
                          
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
      <div class="card-footer">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>