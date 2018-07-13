<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-md-3">
    <ul class="list-group">
      <li class="list-group-item"><strong><?php echo lang('admin events code'); ?>:</strong> <span class="pull-right"><?php echo $request['code']; ?></span></li>
      <li class="list-group-item"><strong><?php echo lang('admin tickets date_info'); ?>:</strong> <span class="pull-right"><?php echo $request['date']; ?></span></li>
      <li class="list-group-item"><strong><?php echo lang('admin tickets user'); ?>:</strong> <span class="pull-right"><?php echo $request['user']; ?></span></li>
      <li class="list-group-item"><strong><?php echo lang('admin col status'); ?>:</strong> 
         <span class="pull-right">
                 <?if($request['status']==0){?>
                  <span class="badge badge-warning"><?php echo lang('admin tickets untreated'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($request['status']==1){?>
                  <span class="badge badge-success"><?php echo lang('admin verify confirmed'); ?></span>
                 <?}else{?>
                 <?}?>
                 <?if($request['status']==2){?>
                  <span class="badge badge-danger"><?php echo lang('admin verify rejected'); ?></span>
                 <?}else{?>
                 <?}?>
         </span></li>
      <li class="list-group-item">
        <div class="dropdown">
          <button class="btn btn-warning btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo lang('admin col actions'); ?>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php if ($request['status'] != 1) : ?>
            <a class="dropdown-item" href="<?php echo $this_url; ?>/confirm_request/<?php echo $request['id']; ?>"><?php echo lang('admin verify confirm'); ?></a>
            <?php endif; ?>
            <?php if ($request['status'] != 2) : ?>
            <a href="#0" data-toggle="modal" data-target="#0" class="dropdown-item modalbttn"><?php echo lang('admin verify reject'); ?></a>
            <?php endif; ?>
            <a href="<?php echo base_url();?>admin/verification/delete/<?php echo $request['id']; ?>" class="dropdown-item"><?php echo lang('admin verify del_req'); ?></a>
          </div>
        </div>
      </li>
    </ul>
  </div>
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-12">
        <div class="card margin-standart">
          <div class="card-title">
            <div class="row">
              <div class="col-md-10">
                <?php echo lang('admin verify id_card'); ?>
              </div>
              <div class="col-md-2 -text-right">
                <a href="<?php echo base_url();?>upload/verify/<?php echo $request['id_card']; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="icon-size-fullscreen icons"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <img class="img-responsive" src="<?php echo base_url();?>upload/verify/<?php echo $request['id_card']; ?>">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card margin-standart">
          <div class="card-title">
            <div class="row">
              <div class="col-md-9">
                <?php echo lang('admin verify id_address'); ?>
              </div>
              <div class="col-md-3 -text-right">
                <a data-toggle="collapse" href="#address" role="button" aria-expanded="false" aria-controls="search" class="btn btn-primary btn-sm"><i class="icon-location-pin icons"></i></a>
                <a href="<?php echo base_url();?>upload/verify/<?php echo $request['id_address']; ?>" target="_blank" class="btn btn-primary btn-sm"><i class="icon-size-fullscreen icons"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="collapse" id="address">
              <div class="card card-search">
                <div class="card-body">
                  <strong><?php echo lang('admin verify id_info'); ?>:</strong> <?php echo $user['country']; ?>, <?php echo $user['zip']; ?>, <?php echo $user['city']; ?>, <?php echo $user['address_1']; ?>, <?php echo $user['address_2']; ?>
                </div>
              </div>
            </div>
            <img class="img-responsive" src="<?php echo base_url();?>upload/verify/<?php echo $request['id_address']; ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo form_open('admin/verification/reject_request/'. $request['id'] . '', array('role'=>'form')); ?>
<div class="modalcontainer">
    <div class="flex">
      <div class="modal">
        <div class="close"><span>&#43;</span></div>
        <div class="content">
          <h5 class="mb-1"><?php echo lang('admin verify reject'); ?> <?php echo $request['code']; ?> - <?php echo $request['user']; ?></h5>
          <div class="row">
            <div class="form-group col-sm-12">
                          <?php echo form_label(lang('admin settings comment'), 'comment', array('class'=>'control-label')); ?>
                          <span class="required">*</span>
                          <?php echo form_textarea(array('name'=>'comment', 'class'=>'form-control underlined', 'rows'=>'4', 'placeholder'=>lang('admin verify reason'))); ?>
                        </div>
            
            <div class="col-md-12 -text-right mt-3">
                <button class="btn btn-success" type="submit">
                  <?php echo lang('admin disputes accept'); ?>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php echo form_close(); ?>