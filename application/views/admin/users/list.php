<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admins button users_all'); ?>
          </div>
          <div class="col-md-8 -text-right">
            <?php if ($total) : ?>
               <a href="<?php echo $this_url; ?>/export?sort=<?php echo $sort; ?>&dir=<?php echo $dir; ?><?php echo $filter; ?>" class="btn btn-success btn-sm"><i class="icon-cloud-download icons"></i> <?php echo lang('admins button csv_export'); ?></a> 
            <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
            <?php endif; ?>
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
                           <label class="control-label"><?php echo lang('users input username'); ?></label>
                           <?php echo form_input(array('name'=>'username', 'id'=>'username', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('users input username'), 'value'=>set_value('username', ((isset($filters['username'])) ? $filters['username'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                           <label class="control-label"><?php echo lang('admin user email'); ?></label>
                           <?php echo form_input(array('name'=>'email', 'id'=>'email', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin user email'), 'value'=>set_value('email', ((isset($filters['email'])) ? $filters['email'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                           <label class="control-label"><?php echo lang('users input first_name'); ?></label>
                           <?php echo form_input(array('name'=>'first_name', 'id'=>'first_name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('users input first_name'), 'value'=>set_value('first_name', ((isset($filters['first_name'])) ? $filters['first_name'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group"> 
                           <label class="control-label"><?php echo lang('users input last_name'); ?></label>
                           <?php echo form_input(array('name'=>'last_name', 'id'=>'username', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('users input last_name'), 'value'=>set_value('last_name', ((isset($filters['last_name'])) ? $filters['last_name'] : '')))); ?>
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
 
               <th>
                    <?php echo lang('admin user email'); ?>
                </th>
                <th>
                    <?php echo lang('users col username'); ?>
                </th>
                <th>
                    <?php echo lang('admin settings name'); ?>
                </th>
                <th>
                    <?php echo $this->currencys->display->base_code ?>
                </th>
               <?php if ($this->currencys->display->extra1_check) : ?>
                <th>
                    <?php echo $this->currencys->display->extra1_code ?>
                </th>
                <?php endif; ?>
                <?php if ($this->currencys->display->extra2_check) : ?>
                <th>
                    <?php echo $this->currencys->display->extra2_code ?>
                </th>
                <?php endif; ?>
                <?php if ($this->currencys->display->extra3_check) : ?>
                <th>
                    <?php echo $this->currencys->display->extra3_code ?>
                </th>
                <?php endif; ?>
                <?php if ($this->currencys->display->extra4_check) : ?>
                <th>
                    <?php echo $this->currencys->display->extra4_code ?>
                </th>
                <?php endif; ?>
                <?php if ($this->currencys->display->extra5_check) : ?>
                <th>
                    <?php echo $this->currencys->display->extra5_code ?>
                </th>
                <?php endif; ?>
                <th class="-text-center"><?php echo lang('admin col actions'); ?></th>
            </thead>
             <tbody>
               <?php // data rows ?>
                <?php if ($total) : ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td>
                            <?php echo $user['email']; ?>
                        </td>
                        <td>
                            <?php echo $user['username']; ?>
                        </td>
                        <td>
                            <?php if ($user['verify_status'] == 2) : ?>
                            <span class="text-success"><i class="icon-user-following icons"></i></span>
                            <?php endif; ?>
                            <?php if ($user['verify_status'] == 1) : ?>
                            <span class="text-warning"><i class="icon-user icons"></i></span>
                            <?php endif; ?>
                            <?php if ($user['verify_status'] == 0) : ?>
                            <span class="text-danger"><i class="icon-user-unfollow icons"></i></span>
                            <?php endif; ?>
                            <?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?> 
                        </td>
                        <td>
                            <?php echo $user['debit_base']; ?>
                        </td>
                        <?php if ($this->currencys->display->extra1_check) : ?>
                        <td>
                            <?php echo $user['debit_extra1']; ?>
                        </td>
                        <?php endif; ?>
                        <?php if ($this->currencys->display->extra2_check) : ?>
                        <td>
                            <?php echo $user['debit_extra2']; ?>
                        </td>
                        <?php endif; ?>
                        <?php if ($this->currencys->display->extra3_check) : ?>
                        <td>
                            <?php echo $user['debit_extra3']; ?>
                        </td>
                        <?php endif; ?>
                        <?php if ($this->currencys->display->extra4_check) : ?>
                        <td>
                            <?php echo $user['debit_extra4']; ?>
                        </td>
                        <?php endif; ?>
                        <?php if ($this->currencys->display->extra5_check) : ?>
                        <td>
                            <?php echo $user['debit_extra5']; ?>
                        </td>
                        <?php endif; ?>
                        <td class="-text-center">
                               
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <?php if ($user['id'] > 1) : ?>
                              <a href="<?php echo $this_url; ?>/delete/<?php echo $user['id']; ?>" onclick ="return confirm('<?php echo sprintf(lang('users msg delete_confirm'), $user['first_name'] . " " . $user['last_name']); ?>');" class="btn btn-danger"><i class="icon-close icons"></i></a>
                              <?php endif; ?>
                              <a href="<?php echo $this_url; ?>/edit/<?php echo $user['id']; ?>" class="btn btn-primary"><i class="icon-eye icons"></i></a>
                            </div>
                               
                        </td>
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
      <div class="card-footer">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>
