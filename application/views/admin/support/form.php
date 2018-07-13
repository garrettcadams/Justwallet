<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-3">
    <li class="list-group-item"><strong><?php echo lang('admin events code'); ?>:</strong> <span class="pull-right"><?php echo $tickets['code']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admin tickets date_info'); ?>:</strong> <span class="pull-right"><?php echo $tickets['date']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admin tickets user'); ?>:</strong> <span class="pull-right"><?php echo $tickets['user']; ?></span></li>
    <li class="list-group-item"><strong><?php echo lang('admin col status'); ?>:</strong> 
      <span class="pull-right">
        <?if($tickets['status']==0){?>
                  <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($tickets['status']==1){?>
                  <span class="badge badge-success"><?php echo lang('admin tickets processed'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($tickets['status']==2){?>
                  <span class="badge badge-danger"><?php echo lang('admin tickets closed'); ?></span>
                 <?}else{?>
                 <?}?>
      </span>
    </li>
  </div>
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-12">
        <div class="card margin-standart">
           <div class="card-title">
              <?php echo $tickets['title']; ?>
           </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php if ($tickets['message'] != NULL) : ?>
                     <div class="card margin-standart">
                       <div class="card-title-mini">
                          <?php echo $tickets['user']; ?>
                       </div>
                       <div class="card-body">
                         <?php echo $tickets['message']; ?>
                       </div>
                       <div class="card-footer-padding">
                         <i class="icon-clock icons"></i> <?php echo $tickets['date']; ?>
                       </div>
                    </div>
                    <?php endif; ?>
                    <?php foreach($log_comment->result() as $view) : ?>
                      <div class="card margin-standart">
                       <div class="card-title-mini">
                         <div class="row">
                           <div class="col-md-10">
                             <?php echo $view->user ?>
                           </div>
                           <div class="col-md-2 -text-right">
                             <i class="icon-user icons <?if($view->role==1){?><?}else{?><?}?><?if($view->role==0){?>text-danger<?}else{?><?}?>"></i>
                           </div>
                         </div>
                       </div>
                       <div class="card-body">
                         <?php echo $view->comment ?>
                       </div>
                       <div class="card-footer-padding">
                         <i class="icon-clock icons"></i> <?php echo $view->date ?>
                       </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-12">
        <?php echo form_open(site_url("admin/support/add_admin_comment/" . $tickets['id']), array("" => "")) ?>
         <div class="card margin-standart">
           <div class="card-body">
              <label for="transaction" class="control-label"><strong><?php echo lang('admin tickets enter'); ?></strong></label>   
              <textarea name="comment" id="comment" class="form-control form-control-sm" rows="10" placeholder="<?php echo lang('admin tickets textarea'); ?>"></textarea>
               <script>
                CKEDITOR.replace( 'comment', { height:['150px'] } );
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.replace('body', {height: 150});
              </script>
           </div>
           <div class="card-footer-padding">
              <?php if ($tickets['status'] != 2) : ?>
              <a class="btn btn-danger btn-sm" href="<?php echo $this_url; ?>/close_ticket/<?php echo $tickets['id']; ?>"><?php echo lang('admin tickets close'); ?></a>
              <button type="submit"  class="btn btn-primary btn-sm"><?php echo lang('admin tickets reply'); ?></button>
              <?php endif; ?>
              <?php if ($tickets['status'] == 2) : ?>
              <a class="btn btn-success btn-sm" href="<?php echo $this_url; ?>/open_ticket/<?php echo $tickets['id']; ?>"><?php echo lang('admin tickets open'); ?></a>
              <?php endif; ?>
           </div>
        </div>
        <?php echo form_close(); ?> 
      </div>
    </div>
    
  </div>
</div>