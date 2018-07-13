<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-6">
            <?php echo lang('admin shops items_category'); ?>
          </div>
          <div class="col-md-6 -text-right">
            <a data-toggle="collapse" href="#search" role="button" aria-expanded="false" aria-controls="search" class="btn btn-warning btn-sm"><i class="icon-magnifier icons"></i> <?php echo lang('admins log search'); ?></a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
              <tr>
                  <th>
                      <?php echo lang('admins trans id'); ?>
                  </th>
                  <th>
                      <?php echo lang('admin invoices name'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admins trans status'); ?>
                  </th>
                  <th class="-text-center">
                      <?php echo lang('admin shops items'); ?>
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
                <td><?php echo $view['id']; ?></td>
                <td>
                  <?php 
                  $name_category = (@$view['name'][$this->session->language]) ? $view['name'][$this->session->language] : "";
                  echo $name_category;
                  ?>
                </td>
                <td class="-text-center">
                  <?php if ($view['status'] == 1) : ?>
                              <span class="badge badge-success"><?php echo lang('admin template enabled'); ?></span>
                            <?php else : ?>
                              <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
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
                      <td colspan="5">
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