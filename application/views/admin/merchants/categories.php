

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin shops categories'); ?>
          </div>
          <div class="col-md-8 -text-right">
            <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
            <a href="<?php echo base_url();?>admin/merchants/add" class="btn btn-success btn-sm"><i class="icon-plus icons"></i> <?php echo lang('admin shops categories_new'); ?></a>
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
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label"><?php echo lang('admin invoices name'); ?></label>
                        <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('admin invoices name'), 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
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
                      <?php echo lang('admin events code'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin events date'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin invoices name'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admins trans status'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admin shops title'); ?>
                  </th>
                  <th class="-text-center"></th>
              </tr>
            </thead>
            <tbody>
              <?php // data rows ?>
              <?php if ($total) : ?>
              <?php foreach ($history as $view) : ?>
              <?php
                $view['name'] = (@unserialize($view['name']) !== FALSE) ? unserialize($view['name']) : $view['name'];
                if ( ! is_array($view['name']))
                {
                    $old_value = $view['name'];
                    $view['name'] = array();
                    foreach ($this->session->languages as $language_key=>$language_name)
                    {
                        $view['name'][$language_key] = ($language_key == $this->session->language) ? $old_value : "";
                    }
                }
              ?>
              <tr>
                <td class="-text-center"><img class="img-circle" src="<?php echo base_url();?>upload/logo/<?php echo $view['img']; ?>"></td>
                <td><?php echo $view['id']; ?></td>
                <td><?php echo $view['code']; ?></td>
                <td><?php echo $view['date']; ?></td>
                <td>
                  <?php 
                  $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                  echo $name_category;
                  ?>
                </td>
                <td class="-text-center">
                  <?php if ($view['status'] == 0) : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-success"><?php echo lang('admin template enabled'); ?></span>
                            <?php endif; ?>
                </td>
                <td class="-text-center"><a href="<?php echo base_url();?>admin/merchants/?sort=id&dir=desc&limit=10&offset=0&category=<?php echo $view['id']; ?>" target="_blank"><?php echo $this->notice->sum_merchants($view['id']); ?></a></td>
                <td class="-text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                       <a href="<?php echo base_url();?>admin/merchants/delete/<?php echo $view['id']; ?>" onclick ="return confirm('<?php echo sprintf(lang('users msg delete_confirm'), $view['id'] . " " . $view['code']); ?>');" class="btn btn-danger"><i class="icon-close icons"></i></a>
                       <a href="<?php echo base_url();?>admin/merchants/edit/<?php echo $view['id']; ?>" class="btn btn-primary"><i class="icon-eye icons"></i></a>
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
