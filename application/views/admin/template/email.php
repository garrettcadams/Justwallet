<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
          <?php echo lang('admin template title'); ?>
        </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center" width="10%">
                   <?php echo lang('admin template status'); ?>  
                  </th>
                  <th>
                   <?php echo lang('admin template title_message'); ?>  
                  </th>
                  <th class="-text-center" width="10%">
                       <?php echo lang('admin col actions'); ?>  
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if ($total) : ?>
                <?php foreach ($email_templates as $view) : ?>

                <tr>

                  <td>
                    <?php if ($view['status'] == "0") : ?>
                       <span class="badge badge-danger"><?php echo lang('admin template disabled'); ?></span>
                    <?php else : ?>
                       <span class="badge badge-success"><?php echo lang('admin template enabled'); ?></span>
                    <?php endif; ?>
                  </td>

                  <td>
                     <?php echo $view['title']; ?>
                  </td>

                  <td class="-text-center">
                      <a href="<?php echo $this_url; ?>/edit/<?php echo $view['id']; ?>" class="btn btn-sm btn-primary"><i class="icon-eye icons"></i></a>
                  </td>

                </tr>

                <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">
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