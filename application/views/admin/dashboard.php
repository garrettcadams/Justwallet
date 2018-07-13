<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  
  <div class="col-md-5">
                  <div class="Card DashboardStats">
                    <div class="CardBlock">
                      <div class="TitleBlock">
                        <h4 class="Title"><?php echo lang('admin dashboard stats'); ?></h4>
                        <p class="TitleDescription"><?php echo lang('admin dashboard summary'); ?></p>
                      </div>
                      <div class="row -row-compact -row-minimal-lg">
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-people text-primary"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_user; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_users'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-primary" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-cursor text-success"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_transactions; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_transactions'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-success" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-shield text-danger"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_disputes; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_disputes'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-danger" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-support text-info"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_support; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_tickets'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-info" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-basket text-warning"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_merchants; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_merchants'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-warning" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="StatGroup">
                            <div class="Stat">
                              <div class="Icon">
                                <i class="icon-diamond text-gray"></i>
                              </div>
                              <div class="StatContent">
                                <div class="StatValue"> <?php echo $total_vouchers; ?> </div>
                                <div class="StatName"> <?php echo lang('admin dashboard tottal_vouchers'); ?> </div>
                              </div>
                            </div>
                            <div class="Progress -sm">
                              <div class="Bar bg-gray" style="width: 100%;"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
              <div class="col-md-7 -sameheight">
                  <div class="Card DashboardHistory">
                    <div class="CardHeader -bordered -sm">
                      <div class="HeaderBlock">
                        <h4 class="Title"><?php echo lang('admin dashboard requires'); ?></h4>
                      </div>
                      <ul class="TabNav">
                        <li class="TabNavItem -active">
                          <a href="#transactions">
                            <?php echo lang('admins trans withdrawal'); ?> </a>
                        </li>
                        <li class="TabNavItem">
                          <a href="#disputes">
                            <?php echo lang('admins title disputes'); ?> </a>
                        </li>
                        <li class="TabNavItem">
                          <a href="#tickets">
                            <?php echo lang('admins button tickets'); ?> </a>
                        </li>
                        <li class="TabNavItem">
                          <a href="#verify">
                            <?php echo lang('admin verify user_menu'); ?> </a>
                        </li>
                        <li class="TabNavItem">
                          <a href="#merchant">
                            <?php echo lang('admins merchant title'); ?> </a>
                        </li>
                      </ul>
                    </div>
                    <div class="CardBlock">
                      <div class="TabContent" id="stat">
                        <div class="TabPane -active" id="transactions">
                          <table class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <?php echo lang('admins trans id'); ?>
                                </th>
                                <th>
                                    <?php echo lang('admins trans sender'); ?>
                                </th>
                                <th>
                                    <?php echo lang('admin dashboard method'); ?>
                                </th>
                                <th>
                                    <?php echo lang('admin events date'); ?>
                                </th>
                                <th>
                                    <?php echo lang('admins trans amount'); ?>
                                </th>
                                 <th class="-text-center">
                                    <?php echo lang('admins button currency'); ?>
                                </th>
                            </tr>
                          </thead>
                            
                            <tbody>
                              <?if($transactions->result() == NULL){?>
                              <tr>
                                  <td colspan="6">
                                      <?php echo lang('core error no_results'); ?>
                                  </td>
                              </tr>
                            <?}else{?>
                              <?php foreach($transactions->result() as $view) : ?>
                              
                              <tr>
                                
                                <td><a href="<?php echo base_url();?>admin/transactions/edit/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                                <td><?php echo $view->sender ?></td>
                                <td><?php echo $view->user_comment ?></td>
                                <td><?php echo $view->time ?></td>
                                <td><?php echo $view->amount ?></td>
                                <td class="-text-center">
                                  <?if($view->currency=='debit_base'){?>
                                      <?php echo $this->currencys->display->base_code ?>
                                  <?}else{?>
                                  <?}?>
                                  <?if($view->currency=='debit_extra1'){?>
                                      <?php echo $this->currencys->display->extra1_code ?>
                                  <?}else{?>
                                  <?}?>
                                  <?if($view->currency=='debit_extra2'){?>
                                      <?php echo $this->currencys->display->extra2_code ?>
                                  <?}else{?>
                                  <?}?>
                                  <?if($view->currency=='debit_extra3'){?>
                                      <?php echo $this->currencys->display->extra3_code ?>
                                  <?}else{?>
                                  <?}?>
                                  <?if($view->currency=='debit_extra4'){?>
                                      <?php echo $this->currencys->display->extra4_code ?>
                                  <?}else{?>
                                  <?}?>
                                  <?if($view->currency=='debit_extra5'){?>
                                      <?php echo $this->currencys->display->extra5_code ?>
                                  <?}else{?>
                                  <?}?>
                                
                                </td>
                              </tr>
                              
                              <?php endforeach; ?>
                              
                              <?}?>
                            </tbody>
                         </table>
                        </div>
                        <div class="TabPane" id="disputes">
                          <table class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                                  <?php // sortable headers ?>
                              <tr>
                                      <th>
                                          <?php echo lang('admins trans id'); ?>
                                      </th>
                                      <th>
                                          <?php echo lang('admins disputes id_tran'); ?>
                                      </th>
                                      <th>
                                          <?php echo lang('admins disputes time_dispute'); ?>
                                      </th>
                                      <th>
                                          <?php echo lang('admins disputes claimant'); ?>
                                      </th>
                                      <th>
                                          <?php echo lang('admins disputes defendant'); ?>
                                      </th>

                                  </tr>

                            </thead>
                            <tbody>
                              <?if($disputes->result() == NULL){?>
                              <tr>
                                  <td colspan="5">
                                      <?php echo lang('core error no_results'); ?>
                                  </td>
                              </tr>
                              <?}else{?>
                                <?php foreach($disputes->result() as $view) : ?>
                              
                              <tr>
                                
                                <td><a href="<?php echo base_url();?>admin/disputes/detail/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                                <td><?php echo $view->transaction ?></td>
                                <td><?php echo $view->time_dispute ?></td>
                                <td><?php echo $view->claimant ?></td>
                                <td><?php echo $view->defendant ?></td>

                              </tr>
                              
                              <?php endforeach; ?>
                              <?}?>
                            </tbody>
                          </table>
                        </div>
                        <div class="TabPane" id="tickets">
                          <table class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                          <?php // sortable headers ?>
                            <tr>
                                    <th>  
                                        <?php echo lang('admins trans id'); ?>
                                    </th>
                                    <th>
                                       <?php echo lang('admin tickets date'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('admin tickets user'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('admin tickets title'); ?>
                                    </th>
                                </tr>

                          </thead>
                            
                            <tbody>
                              <?if($tickets->result() == NULL){?>
                              <tr>
                                  <td colspan="4">
                                      <?php echo lang('core error no_results'); ?>
                                  </td>
                              </tr>
                            <?}else{?>
                                <?php foreach($tickets->result() as $view) : ?>
                              
                              <tr>
                                
                                <td><a href="<?php echo base_url();?>admin/support/edit/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                                <td><?php echo $view->date ?></td>
                                <td><?php echo $view->user ?></td>
                                <td><?php echo $view->title ?></td>

                              </tr>
                              
                              <?php endforeach; ?>
                              
                              <?}?>
                            </tbody>
                         </table>
                        </div>
                        <div class="TabPane" id="verify">
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
                                  <?php echo lang('admin events date'); ?>
                              </th>
                             <th>
                                  <?php echo lang('admin user username'); ?>
                              </th>
                              

                            </tr>
                            </thead>
                            <tbody>
                            <?if($verification->result() == NULL){?>
                              <tr>
                                  <td colspan="4">
                                      <?php echo lang('core error no_results'); ?>
                                  </td>
                              </tr>
                            <?}else{?>
                              <?php foreach($verification->result() as $view) : ?>

                              <tr>
                                
                                <td><a href="<?php echo base_url();?>admin/verification/edit/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                                <td><?php echo $view->code ?></td>
                                <td><?php echo $view->date ?></td>
                                <td><?php echo $view->user ?></td>

                              </tr>
                              
                              <?php endforeach; ?>
                            <?}?>
                             
                            </tbody>
                          </table>
                        </div>
                        <div class="TabPane" id="merchant">
                          <table class="table table-responsive-lg table-bordered table-hover">
                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <?php echo lang('admins trans id'); ?>
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
                            </tr>
                          </thead>
                          <tbody>
                            
                            <?if($merchants->result() == NULL){?>
                              <tr>
                                  <td colspan="4">
                                      <?php echo lang('core error no_results'); ?>
                                  </td>
                              </tr>
                            <?}else{?>
                              <?php foreach($merchants->result() as $view) : ?>

                              <tr>
                                <td class="-text-center"><img class="img-circle" src="<?php echo base_url();?>upload/logo/<?php echo $view->logo; ?>"></td>
                                <td><a href="<?php echo base_url();?>admin/merchants/edit_merchant/<?php echo $view->id ?>" target="_blank"><?php echo $view->id ?></a></td>
                                <td><?php echo $view->name ?></td>
                                <td><?php echo $view->link ?></td>
                                <td><?php echo $view->user ?></td>

                              </tr>
                              
                              <?php endforeach; ?>
                            <?}?>
                            
                          </tbody>
                         </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
</div>
