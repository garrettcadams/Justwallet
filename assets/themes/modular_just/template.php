<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Template
 */
?><!doctype html>

<html class="no-js" lang="en" id="Main">
  <head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/modular_just/assets/bundle.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/modular_just/assets/wallet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="<?php echo base_url();?>assets/themes/account/css/datepicker.css" rel="stylesheet" type="text/css">
		<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
	</head>
	
	<?php // Notify support
		$info_support = $this->notice->sum_admin_support();
		if ($info_support > 0) {
			$sample_support = TRUE;
		} else {
			$sample_support = FALSE;
		}
	?>
	
	<?php // Notify disputes
		$info_disputes = $this->notice->sum_admin_disputes();
		if ($info_disputes > 0) {
			$sample_disputes = TRUE;
		} else {
			$sample_disputes = FALSE;
		}
	?>
	
	<?php // Notify verify
		$info_verify = $this->notice->sum_admin_verify();
		if ($info_verify > 0) {
			$sample_verify = TRUE;
		} else {
			$sample_verify = FALSE;
		}
	?>
	
  <body>
		
		<div id="App" class="App sidebar-compact-tablet -sidebar-compact-desktop">
			 <div class="HeaderContainer">
        <header class="AppHeader">
          <div class="HeaderBlock">
            <button class="Button -primary ControlButton" id="HeaderSidebarToggleButton">
              <i class="icon-menu Icon" aria-hidden="true"></i>
            </button>
          </div>
          <div class="HeaderBlock">
            <nav class="ProfileNav">
							
              <div class="Dropdown NavItem Notifications">
								<a href="<?php echo base_url('/'); ?>" target="_blank" aria-expanded="false" class="NavLink NotificationsLink">
                  <i class="fa fa-eye"></i>
                </a>
                <a href="<?php echo base_url('logout'); ?>" aria-expanded="false" class="NavLink NotificationsLink">
                  <i class="fa fa-sign-out"></i>
                </a>
              </div>
              <div class="Dropdown NavItem Profile">
                <a href="" class="DropdownToggle NavLink ProfileLink">
                  <div class="Name"> Language <i class="fa fa-angle-down"></i> </div>
                </a>
                <div class="DropdownContent -end" aria-labelledby="session-language" id="session-language-dropdown">
                  <nav class="Nav">
										<?php foreach ($this->languages as $key=>$name) : ?> 
                    <a href="#" rel="<?php echo $key; ?>" class="DropdownToggle"> <?php if ($key == $this->session->language) : ?> <i class="fa fa-check selected-session-language"></i> <?php endif; ?> <?php echo $name; ?></a>
										<?php endforeach; ?>
                  </nav>
                </div>
              </div>
            </nav>
          </div>
        </header>
      </div>
			<div class="SidebarContainer">
        <aside class="AppSidebar">
          <header class="SidebarHeader">
            <a class="LogoLink" href="<?php echo base_url('admin'); ?>">
              <div class="Logo">
                <title>logo</title>
                <img src="<?php echo base_url();?>assets/themes/modular_just/img/admin_logo.png" class="img-responsive">
              </div>
            </a>
            <h2 class="Title">
              <a class="Link" href="/">
                <span>Just Wallet</span>
              </a>
            </h2>
          </header>
          <div class="SidebarContent">
            <nav class="SidebarNav" id="SidebarNav">
              <a href="<?php echo base_url('/admin'); ?>" class="NavLink <?php echo (uri_string() == 'admin' OR uri_string() == 'admin/dashboard') ? '-active' : ''; ?>">
                <i class="icon-home NavIcon"></i>
                <span> <?php echo lang('admin button dashboard'); ?> </span>
              </a>

              <a href="<?php echo base_url('/admin/users'); ?>" class="NavLink <?php echo (uri_string() == 'admin/users' OR uri_string() == 'admin/users') ? '-active' : ''; ?>">
                <i class="icon-people NavIcon"></i>
                <span> <?php echo lang('admin button users'); ?> </span>
              </a>
							
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/users')) ? '-active' : ''; ?>">
                  <i class="icon-directions NavIcon"></i>
                  <span> <?php echo lang('admins title transactions'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admins title transactions'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
                  <a href="<?php echo base_url('admin/transactions/'); ?>" class="NavLink "> <?php echo lang('admins button all_transactions'); ?> </a>
                  <a href="<?php echo base_url('admin/transactions/pending'); ?>" class="NavLink "> <?php echo lang('admins button pending'); ?> </a>
									<a href="<?php echo base_url('admin/transactions/confirmed'); ?>" class="NavLink "> <?php echo lang('admins button confirmed'); ?> </a>
									<a href="<?php echo base_url('admin/transactions/disputed'); ?>" class="NavLink "> <?php echo lang('admins button disputed'); ?> </a>
									<a href="<?php echo base_url('admin/transactions/blocked'); ?>" class="NavLink "> <?php echo lang('admins button blocked'); ?> </a>
									<a href="<?php echo base_url('admin/transactions/refunded'); ?>" class="NavLink "> <?php echo lang('admins button refunded'); ?> </a>
									<a href="<?php echo base_url('admin/transactions/vouchers'); ?>" class="NavLink "> <?php echo lang('admins vouchers menu'); ?> </a>
                </nav>
              </div>

							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/disputes')) ? '-active' : ''; ?>">
									<?if($sample_disputes == TRUE){?>
									<p class="badge badge-danger"><?php echo $this->notice->sum_admin_disputes(); ?></p>
									<?}else{?>
									<?}?>
                  <i class="icon-shield NavIcon"></i>
									
                  <span> <?php echo lang('admins button disputes'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admins button disputes'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
                  <a href="<?php echo base_url('/admin/disputes'); ?>" class="NavLink "> <?php echo lang('admins button all_dispute'); ?> </a>
                  <a href="<?php echo base_url('/admin/disputes/open_disputes'); ?>" class="NavLink "> <?php echo lang('admins button open_disputes'); ?></a>
									<a href="<?php echo base_url('/admin/disputes/open_claims'); ?>" class="NavLink "> <?php echo lang('admins button open_claims'); ?></a>
									<a href="<?php echo base_url('/admin/disputes/rejected_disputes'); ?>" class="NavLink "> <?php echo lang('admins button rejected_disputes'); ?></a>
									<a href="<?php echo base_url('/admin/disputes/satisfied_disputes'); ?>" class="NavLink "> <?php echo lang('admins button satisfied_disputes'); ?></a>
                </nav>
              </div>
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/verification')) ? '-active' : ''; ?>">
									<?if($sample_verify == TRUE){?>
									<p class="badge badge-danger"><?php echo $this->notice->sum_admin_verify(); ?></p>
									<?}else{?>
									<?}?>
                  <i class="icon-badge NavIcon"></i>
									
                  <span> <?php echo lang('admin verify menu'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admin verify menu'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
                  <a href="<?php echo base_url('/admin/verification/'); ?>" class="NavLink "> <?php echo lang('admin verify all'); ?> </a>
                  <a href="<?php echo base_url('/admin/verification/untreated'); ?>" class="NavLink "> <?php echo lang('admin tickets untreated'); ?></a>
                </nav>
              </div>
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/invoices')) ? '-active' : ''; ?>">
                  <i class="icon-credit-card NavIcon"></i>
                  <span> <?php echo lang('admin invoices menu'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admin invoices menu'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
									<a href="<?php echo base_url('/admin/invoices'); ?>" class="NavLink "> <?php echo lang('admin invoices all'); ?> </a>
                  <a href="<?php echo base_url('/admin/invoices/pending'); ?>" class="NavLink "> <?php echo lang('admins button pending'); ?> </a>
                  <a href="<?php echo base_url('/admin/invoices/confirmed'); ?>" class="NavLink "> <?php echo lang('admins button confirmed'); ?> </a>
									<a href="<?php echo base_url('/admin/invoices/declined'); ?>" class="NavLink "> <?php echo lang('admin invoices declined'); ?> </a>
                </nav>
              </div>
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/merchants')) ? '-active' : ''; ?>">
                  <i class="icon-basket NavIcon"></i>
                  <span> <?php echo lang('admin shops title'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admin shops title'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
									<a href="<?php echo base_url('/admin/merchants'); ?>" class="NavLink "> <?php echo lang('admin shops all'); ?> </a>
                  <a href="<?php echo base_url('/admin/merchants/pending'); ?>" class="NavLink "> <?php echo lang('admin shops pending'); ?> </a>
                  <a href="<?php echo base_url('/admin/merchants/categories'); ?>" class="NavLink "> <?php echo lang('admin shops categories'); ?> </a>
									<a href="<?php echo base_url('/admin/merchants/merchant_items'); ?>" class="NavLink "> <?php echo lang('admin shops items'); ?> </a>
                </nav>
              </div>
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/support')) ? '-active' : ''; ?>">
									<?if($sample_support == TRUE){?>
									<p class="badge badge-danger"><?php echo $this->notice->sum_admin_support(); ?></p>
									<?}else{?>
									<?}?>
                  <i class="icon-support NavIcon"></i>
                  <span> <?php echo lang('admin tickets menu'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admin tickets menu'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
											
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
                  <a href="<?php echo base_url('/admin/support/new_ticket'); ?>" class="NavLink "> <?php echo lang('admin tickets new_ticket'); ?> </a>
                  <a href="<?php echo base_url('/admin/support'); ?>" class="NavLink "> <?php echo lang('admin tickets all'); ?> </a>
									<a href="<?php echo base_url('/admin/support/untreated'); ?>" class="NavLink "> <?php echo lang('admin tickets untreated'); ?> </a>
									<a href="<?php echo base_url('/admin/contact'); ?>" class="NavLink "> <?php echo lang('admin messages menu'); ?> </a>
                </nav>
              </div>
							<a href="<?php echo base_url('admin/profit'); ?>" class="NavLink <?php echo (uri_string() == 'admin/profit') ? '-active' : ''; ?>">
                <i class="icon-chart NavIcon"></i>
                <span> <?php echo lang('admin profit title'); ?> </span>
              </a>
							<a href="<?php echo base_url('admin/events'); ?>" class="NavLink <?php echo (uri_string() == 'admin/events') ? '-active' : ''; ?>">
                <i class="icon-eye NavIcon"></i>
                <span> <?php echo lang('admin events menu'); ?> </span>
              </a>
							<div class="NavGroup ">
                <a href="" class="NavLink <?php echo (strstr(uri_string(), 'admin/settings')) ? '-active' : ''; ?>">
                  <i class="icon-equalizer NavIcon"></i>
                  <span> <?php echo lang('admin button settings'); ?> </span>
                </a>
                <nav class="Nav">
                  <div class="CompactNavGroupHeader">
                    <h4 class="NavTitle"> <?php echo lang('admin button settings'); ?> </h4>
                    <a href="" class="Button -dismiss DismissBtn">
                      <i class="icon-close Icon"></i>
                    </a>
                  </div>
                  <a href="<?php echo base_url('/admin/settings'); ?>" class="NavLink "> <?php echo lang('admin title setings'); ?> </a>
                  <a href="<?php echo base_url('/admin/settings/withdrawal'); ?>" class="NavLink "> <?php echo lang('admin settings withdrawal'); ?> </a>
									<a href="<?php echo base_url('/admin/settings/deposit'); ?>" class="NavLink "> <?php echo lang('admin title deposit_settings'); ?> </a>
									<a href="<?php echo base_url('/admin/settings/currencys'); ?>" class="NavLink "> <?php echo lang('admin settings currency'); ?> </a>
									<a href="<?php echo base_url('/admin/template'); ?>" class="NavLink "> <?php echo lang('admin button notification'); ?> </a>
									<a href="<?php echo base_url('/admin/template/sms'); ?>" class="NavLink "> <?php echo lang('admins template sms'); ?> </a>
									<a href="<?php echo base_url('/admin/pages'); ?>" class="NavLink "> <?php echo lang('admin pages menu'); ?> </a>
                </nav>
              </div>
              
            </nav>
          </div>
          <footer id="SidebarFooter" class="SidebarFooter">
            <nav class="SidebarFooterNav">

              <a href="http://justigniter.io/support" target="_blank" id="SidebarToggleHelpLink" class="NavLink LinkToggleHelp" data-placement="top" data-trigger="hover" title="Help">
                <i class="icon-question Icon" aria-hidden="true"></i>
              </a>
            </nav>
          </footer>
        </aside>
      </div>
			<div class="SidebarOverlay" id="SidebarOverlay"></div>
			<div class="ContentContainer Dashboard">
        <div class="Content">
					<article class="Page Dashboard">
						<div class="PageContainer">
							<header class="PageHeader">
                <h1 class="PageTitle"> <?php echo $page_header; ?></h1>
              </header>
							<?php if ($this->session->flashdata('message')) : ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<?php echo $this->session->flashdata('message'); ?>
								<button type="button" class="close button-close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="icon-close Icon"></i></span>
								</button>
							</div>
							<?php elseif ($this->session->flashdata('error')) : ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<?php echo $this->session->flashdata('error'); ?>
								<button type="button" class="close button-close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="icon-close Icon"></i></span>
								</button>
							</div>
							<?php elseif (validation_errors()) : ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								 <?php echo validation_errors(); ?>
								<button type="button" class="close button-close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="icon-close Icon"></i></span>
								</button>
							</div>
							<?php elseif ($this->error) : ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								  <?php echo $this->error; ?>
								<button type="button" class="close button-close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="icon-close Icon"></i></span>
								</button>
							</div>
							<?php endif; ?>
							<?php // Main content ?>
							<?php echo $content; ?>
						</div>
					</article>
				</div>
			</div>
			<div class="FooterContainer">
        <footer class="Footer AppFooter"> 
					<div class="row">
						<div class="col-md-12 -text-right">
							<?php echo lang('core text page_rendered'); ?> | PHP v<?php echo phpversion(); ?> | MySQL v<?php echo mysqli_get_client_version(); ?> | CodeIgniter v<?php echo CI_VERSION; ?> | Just Wallet v<?php echo $this->settings->site_version; ?>
						</div>
					</div>
				</footer>
      </div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

		<script src="<?php echo base_url();?>assets/themes/modular_just/assets/bundle.js"></script>
		<script src="<?php echo base_url();?>assets/themes/modular_just/assets/form.js"></script>
    <script src="<?php echo base_url();?>assets/themes/account/js/datepicker.js"></script>
<script>

$.fn.datepicker.language['ru'] = {days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    today: 'Today',
    clear: 'Clear',
    dateFormat: 'yyyy-mm-dd',
    timeFormat: 'hh:ii',
    firstDay: 0}
</script>
		<!-- Reference block for JS -->
       <?php // Javascript files ?>
        <?php if (isset($js_files_i18n) && is_array($js_files_i18n)) : ?>
            <?php foreach ($js_files_i18n as $js) : ?>
                <?php if ( ! is_null($js)) : ?>
                    <?php echo "\n"; ?><script type="text/javascript"><?php echo "\n" . $js . "\n"; ?></script><?php echo "\n"; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
		<script>
		$(".modalbttn").click(function() {
  $(".modalcontainer").fadeIn("slow");
  $(".modal").fadeIn("slow");
});

$(".close").click(function() {
  $(".modalcontainer").fadeOut("slow");
  $(".modal").fadeOut("slow");
});

$(".buttons").click(function() {
  $(".modalcontainer").fadeOut("slow");
  $(".modal").fadeOut("slow");
});
		</script>
	</body>
	
</html>