<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-title">
        <div class="row">
          <div class="col-md-4">
            <?php echo lang('admin messages all'); ?>
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
                         <label class="control-label"><?php echo lang('contact input name'); ?></label>
                        <?php echo form_input(array('name'=>'name', 'id'=>'name', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('contact input name'), 'value'=>set_value('name', ((isset($filters['name'])) ? $filters['name'] : '')))); ?>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('contact input title'); ?></label>
                        <?php echo form_input(array('name'=>'title', 'id'=>'title', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('contact input title'), 'value'=>set_value('title', ((isset($filters['title'])) ? $filters['title'] : '')))); ?>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('contact input email'); ?></label>
                        <?php echo form_input(array('name'=>'email', 'id'=>'email', 'class'=>'form-control form-control-sm', 'placeholder'=>lang('contact input email'), 'value'=>set_value('email', ((isset($filters['email'])) ? $filters['email'] : '')))); ?>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group"> 
                         <label class="control-label"><?php echo lang('contact input created'); ?></label>
                         <?php echo form_input(array('name'=>'created', 'id'=>'created', 'class'=>'form-control form-control-sm  datepicker-here', 'placeholder'=>lang('contact input created'), 'value'=>set_value('created', ((isset($filters['created'])) ? $filters['created'] : '')))); ?>
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
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-responsive-lg table-bordered table-hover">
              <thead>
                    <?php // sortable headers ?>
                <tr>
                    <th>
                       <?php echo lang('contact col message_id'); ?>
                    </th>
                    <th>
                        <?php echo lang('contact col name'); ?>
                    </th>
                    <th>
                       <?php echo lang('contact col email'); ?>
                    </th>
                    <th>
                       <?php echo lang('contact col title'); ?>
                    </th>
                    <th>
                       <?php echo lang('contact col created'); ?>
                    </th>
                    <th>
                      <div class="-text-center">
                        <?php echo lang('admin col actions'); ?>
                      </div>
                    </th>
                </tr>

              </thead>
              <tbody>
                <?php // data rows ?>
                <?php if ($total) : ?>
                    <?php foreach ($messages as $message) : ?>
                        <tr>
                            <td>
                                <?php echo $message['id']; ?>
                            </td>
                            <td>
                                <?php echo $message['name']; ?>
                            </td>
                            <td>
                                <?php echo $message['email']; ?>
                            </td>
                            <td>
                                <?php echo $message['title']; ?>
                            </td>
                            <td>
                                <?php echo $message['created']; ?>
                            </td>
                            <td>
                                <div class="-text-center">
                                    <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#message<?php echo $message['id']; ?>"><i class="icon-eye icons"></i></button>
                                       
                                     
                                    </div>
                                </div>
                            </td>
                          <tr class="hiddenRow">
                          <td class="hiddenRow" colspan="6" style="padding:0px">
                             <div class="accordian-body collapse" id="message<?php echo $message['id']; ?>"> 
                              <div class="card card-default focuscard" style="padding:20px">
                                  <p class="text-primary">#<?php echo $message['id']; ?> <?php echo $message['title']; ?></p>
                                    <div class="row">
                                      <div class="col-md-12">
                                        <?php echo $message['message']; ?>
                                      </div>
                                    </div>
                              </div>
                             </div> 
                            </td>
                         </tr>

                        </tr>
                <?php // messages modal ?>
                <?php if ($total) : ?>

                  <?php endif; ?>
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