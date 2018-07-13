<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin verify all'); ?>
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
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('users input username'); ?></label>
                           <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('users input username'), 'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin events code'); ?></label>
                           <?php echo form_input(array('name'=>'code', 'id'=>'code', 'class'=>'form-control form-control-sm',  'value'=>set_value('code', ((isset($filters['code'])) ? $filters['code'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin events date'); ?></label>
                           <?php echo form_input(array('name'=>'date', 'id'=>'date', 'class'=>'form-control form-control-sm datepicker-here',  'value'=>set_value('date', ((isset($filters['date'])) ? $filters['date'] : '')))); ?>
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
                    <?php echo lang('admin settings status'); ?>
                </th>
                <th class="-text-center">
                    <?php echo lang('admin col actions'); ?>
                </th>
                
              </tr>
              </thead>
              <tbody>
                <?php if ($total) : ?>
                <?php foreach ($verification as $view) : ?>
                  <tr>
                    <td<?php echo (($sort == 'id') ? ' class="sorted"' : ''); ?>>
                            <?php echo $view['id']; ?>
                    </td>
                    <td<?php echo (($sort == 'code') ? ' class="sorted"' : ''); ?>>
                            <?php echo $view['code']; ?>
                    </td>
                    <td<?php echo (($sort == 'user') ? ' class="sorted"' : ''); ?>>
                            <?php echo $view['user']; ?>
                    </td>
                    <td<?php echo (($sort == 'date') ? ' class="sorted"' : ''); ?>>
                            <?php echo $view['date']; ?>
                    </td>
                    <td>
                     <?if($view['status']==0){?>
                      <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($view['status']==1){?>
                      <span class="badge badge-success"><?php echo lang('admin verify confirmed'); ?></span>
                     <?}else{?>
                     <?}?>
                     <?if($view['status']==2){?>
                      <span class="badge badge-danger"><?php echo lang('admin verify rejected'); ?></span>
                     <?}else{?>
                     <?}?>
                  </td>
                    
                    <td class="-text-center">
                      
                      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="<?php echo $this_url; ?>/delete/<?php echo $view['id']; ?>" onclick ="return confirm('<?php echo sprintf(lang('users msg delete_confirm'), $view['code'] . " " . $view['user']); ?>');" class="btn btn-danger"><i class="icon-close icons"></i></a>
                              <a href="<?php echo $this_url; ?>/edit/<?php echo $view['id']; ?>" class="btn btn-primary"><i class="icon-eye icons"></i></a>
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
      <div class="card-footer">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>