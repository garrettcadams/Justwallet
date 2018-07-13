<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin shops all'); ?>
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
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin invoices name'); ?></label>
                        <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin invoices name'), 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
                      </div>
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
                        <label class="control-label"><?php echo lang('users merchants url'); ?></label>
                        <?php echo form_input(array('name'=>'link', 'id'=>'link', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin invoices name'), 'value'=>set_value('link', ((isset($filters['link'])) ? $filters['link'] : '')))); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('users col username'); ?></label>
                        <?php echo form_input(array('name'=>'user', 'id'=>'user', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('users col username'), 'value'=>set_value('user', ((isset($filters['user'])) ? $filters['user'] : '')))); ?>
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
          </div>
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
              <tr>
                <th></th>
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
                    <?php echo lang('users merchants url'); ?>
                  </th>
                  <th>
                    <?php echo lang('users col username'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admins trans status'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admin shops show'); ?>
                  </th>
                  <th class="-text-center"></th>
              </tr>
            </thead>
            <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($history as $view) : ?>
              <tr>
                <td class="-text-center"><img class="img-circle" src="<?php echo base_url();?>upload/logo/<?php echo $view['logo']; ?>"></td>
                <td><?php echo $view['id']; ?></td>
                <td><?php echo $view['date']; ?></td>
                <td><?php echo $view['name']; ?></td>
                <td><?php echo $view['link']; ?></td>
                <td><?php echo $view['user']; ?></td>
                <td class="-text-center">
                  <?php if ($view['status'] == 1) : ?>
                              <span class="badge badge-primary"><?php echo lang('admins trans pending'); ?></span>
                            <?php elseif ($view['status'] == 2) : ?>
                              <span class="badge badge-success"><?php echo lang('admins trans success'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                            <?php endif; ?>
                </td>
                <td class="-text-center">
                  <?php if ($view['show_category'] == 1) : ?>
                              <span class="badge badge-success"><?php echo lang('admin template enabled'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                            <?php endif; ?>
                </td>
                <td class="-text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                       <a href="<?php echo base_url();?>admin/merchants/delete_merchant/<?php echo $view['id']; ?>" onclick ="return confirm('<?php echo sprintf(lang('users msg delete_confirm'), $view['id'] . " " . $view['code']); ?>');" class="btn btn-danger"><i class="icon-close icons"></i></a>
                       <a href="<?php echo base_url();?>admin/merchants/edit_merchant/<?php echo $view['id']; ?>" class="btn btn-primary"><i class="icon-eye icons"></i></a>
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
