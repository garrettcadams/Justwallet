<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
          <?php echo lang('admin pages all'); ?>
        </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
             <thead>
              <th class="-text-center" width="5%">
                 <?php echo lang('admin events id'); ?>  
                </th>
                <th>
                 <?php echo lang('admin pages name'); ?>  
                </th>
                <th class="-text-center" width="10%">
                  <?php echo lang('admin col actions'); ?>  
               </th>
            </thead>
             <tbody>
               <?php if ($total) : ?>
               <?php foreach ($pages as $view) : ?>
               
               <tr>
              
                  <td class="-text-center">
                      <?php echo $view['id']; ?>
                  </td>
                  <td>
                    <?php echo $view['name']; ?>
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
    </div>
  </div>
</div>