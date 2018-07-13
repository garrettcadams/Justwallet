<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Default Public Template
 */
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Just Digital Tech">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
	  <link rel="icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
    <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>
		<meta name="keywords" content="<?php echo $this->settings->meta_keywords; ?>">
    <meta name="description" content="<?php echo $this->settings->meta_description; ?>">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/themes/account/css/bootstrap.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/themes/account/css/escrow.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/themes/account/css/countrySelect.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
		<link href="<?php echo base_url();?>assets/themes/account/css/datepicker.css" rel="stylesheet" type="text/css">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5a9be2e82326af0013ae4037&product=inline-share-buttons"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
</head>
	
	<?php // Notify invoice
		$info_invoices = $this->notice->sum_user_invoices($user['username']);
		if ($info_invoices > 0) {
			$sample_invoice = TRUE;
		} else {
			$sample_invoice = FALSE;
		}
	?>
	
	<?php // Notify support
		$info_support = $this->notice->sum_user_support($user['username']);
		if ($info_invoices > 0) {
			$sample_support = TRUE;
		} else {
			$sample_support = FALSE;
		}
	?>

<body>
	
	<nav class="navbar navbar-expand-md navbar-dark">
		<div class="container">
      <a class="navbar-brand" href="#">
				<img src="<?php echo base_url();?>assets/themes/account/img/main-logo.png" height="30" alt="">
			</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php echo (uri_string() == '') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/'); ?>"><?php echo lang('core button home'); ?></a>
          </li>
					<li class="nav-item <?php echo (uri_string() == 'how-it-works') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/how-it-works'); ?>"><?php echo lang('core button how_it'); ?></a>
          </li>
					<li class="nav-item <?php echo (uri_string() == 'developers') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/developers'); ?>"><?php echo lang('core button developer'); ?></a>
          </li>
					<li class="nav-item <?php echo (uri_string() == 'help') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/help'); ?>"><?php echo lang('core button help'); ?></a>
          </li>
          <li class="nav-item <?php echo (uri_string() == 'contact') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/contact'); ?>"><?php echo lang('core button contact'); ?></a>
          </li>
         
        </ul>
        <div class="form-inline my-2 my-lg-0">
					<?php if ($this->session->userdata('logged_in')) : ?>
          <?php if ($this->user['is_admin']) : ?>
					<div class="nav-user">
						<a href="<?php echo base_url('admin'); ?>" class="my-2 my-sm-0 mr-3"><?php echo lang('core button admin'); ?></a>
					</div>
					<?php endif; ?>
					<div class="nav-user">
						<a href="<?php echo base_url('logout'); ?>" class="my-2 my-sm-0 mr-3"><?php echo lang('core button logout'); ?></a>
					</div>
					<a href="<?php echo base_url('account/transactions'); ?>" class="btn btn-success my-2 my-sm-0"><?php echo lang('users menu my_account'); ?></a>
					<?php else : ?>
          <a href="<?php echo base_url('login'); ?>" class="btn btn-outline-light my-2 my-sm-0 mr-3"><?php echo lang('core button sign_in'); ?></a>
          <a href="<?php echo base_url('user/register'); ?>" class="btn btn-success my-2 my-sm-0"><?php echo lang('core button create'); ?></a>
					<?php endif; ?>
        </div>
				
      </div>
		</div>
    </nav>
	
		<div class="header-st">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-6 col-xs-6 mt-0">
						<div class="row">
							<div class="col-md-4">
								<small><?php echo lang('users balanve total'); ?></small>
            		<div class="dropdown">
									<button class="btn-ballance btn-link dropdown-toggle btn-block-head" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo $this->notice->hold_balance($user['username'], "debit_base", 1); ?> <?php echo $this->currencys->display->base_code ?>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<?php if($this->currencys->display->extra1_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra1", 1); ?> <?php echo $this->currencys->display->extra1_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra2_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra2", 1); ?> <?php echo $this->currencys->display->extra2_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra3_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra3", 1); ?> <?php echo $this->currencys->display->extra3_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra4_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra4", 1); ?> <?php echo $this->currencys->display->extra4_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra5_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra5", 1); ?> <?php echo $this->currencys->display->extra5_code ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<small><?php echo lang('users balanve hold'); ?></small>
            		<div class="dropdown">
									<button class="btn-ballance btn-link dropdown-toggle btn-block-head" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo $this->notice->hold_balance($user['username'], "debit_base", 2); ?> <?php echo $this->currencys->display->base_code ?>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<?php if($this->currencys->display->extra1_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra1", 2); ?> <?php echo $this->currencys->display->extra1_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra2_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra2", 2); ?> <?php echo $this->currencys->display->extra2_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra3_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra3", 2); ?> <?php echo $this->currencys->display->extra3_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra4_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra4", 2); ?> <?php echo $this->currencys->display->extra4_code ?></a>
										<?php endif; ?>
										<?php if($this->currencys->display->extra5_check) : ?>
										<a class="dropdown-item" href="#"><?php echo $this->notice->hold_balance($user['username'], "debit_extra5", 2); ?> <?php echo $this->currencys->display->extra5_code ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>

					</div>
					
					<div class="col-md-4 col-sm-4 col-xs-4 text-right">
						<div class="btn-group header-bar" role="group" aria-label="Deposit">
							<a href="<?php echo base_url('/account/deposit'); ?>" class="btn btn-outline-light btn-lg min-width-120"><?php echo lang('users dashboard deposit'); ?></a>
							<a href="<?php echo base_url('account/withdrawal'); ?>" class="btn btn-outline-light btn-lg min-width-120"><?php echo lang('users dashboard withdrawal'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>

    <?php // Main body ?>
	<main>
    <div class="container theme-showcase" role="main">
			<div class="row">
				<div class="col-md-6 mt-4">
					<h3><?php echo $page_header; ?></h3>
				</div>
				<div class="col-md-6 mt-4 text-right">
					<div class="btn-group" role="group" aria-label="Basic example">
						<a href="<?php echo base_url('/account/orders'); ?>" class="btn btn-light"><i class="icon-badge icons"></i> My orders</a>
						<a href="<?php echo base_url('/account/cart'); ?>" class="btn btn-light"><i class="icon-basket icons"></i> My cart <span class="badge badge-pill badge-danger"><?php echo $this->notice->sum_items_cart($user['username']); ?></span></a>
					</div>
				</div>
				<div class="col-md-12">
				<hr>
				</div>
				<div class="col-md-3 mt-3">
					<div class="list-group">
						<a href="<?php echo base_url('account/transactions'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/transactions') ? 'active' : ''; ?>">
							<?php echo lang('users title history'); ?><span class="text-right"><i class="icon-hourglass icons"></i>
						</a>
						<a href="<?php echo base_url('account/money_transfer'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/money_transfer') ? 'active' : ''; ?>">
							<?php echo lang('users menu transfer'); ?><span class="text-right"><i class="icon-paper-plane icons"></i>
						</a>
							<a href="<?php echo base_url('account/shops'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/shops') ? 'active' : ''; ?>">
							<?php echo lang('users shops title'); ?><span class="text-right"><i class="icon-handbag icons"></i>
						  </a>
							<a href="<?php echo base_url('account/exchange'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/exchange') ? 'active' : ''; ?>">
							<?php echo lang('users menu exchange'); ?><span class="text-right"><i class="icon-refresh icons"></i>
						 </a>
							<a href="<?php echo base_url('account/invoices'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/invoices') ? 'active' : ''; ?>">
								<?php echo lang('users invoices menu'); ?> <span class="text-right">
								<?if($info_invoices == TRUE){?>
								<span class="notification-badge">
									<?php echo $this->notice->sum_user_invoices($user['username']); ?>
								</span>
								<?}else{?>
								<i class="icon-credit-card icons"></i>
  							<?}?>
							</a>
							<a href="<?php echo base_url('account/vouchers'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/vouchers') ? 'active' : ''; ?>">
							<?php echo lang('users vouchers menu'); ?><span class="text-right"><i class="icon-diamond icons"></i>
							</a>
							<a href="<?php echo base_url('account/disputes'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/disputes') ? 'active' : ''; ?>">
							<?php echo lang('users menu dispute'); ?><span class="text-right"><i class="icon-shield icons"></i>
							</a>
							<a href="<?php echo base_url('account/merchants'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/merchants') ? 'active' : ''; ?>">
							<?php echo lang('users shops merchant'); ?><span class="text-right"><i class="icon-basket icons"></i>
							</a>
							<a href="<?php echo base_url('account/support'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/support') ? 'active' : ''; ?>">
								<?php echo lang('users support title_1'); ?> <span class="text-right">
								<?if($info_support == TRUE){?>
								<span class="notification-badge">
									<?php echo $this->notice->sum_user_support($user['username']); ?>
								</span>
								<?}else{?>
								<i class="icon-support icons"></i>
  							<?}?>
						</a>
						<a href="<?php echo base_url('account/settings'); ?>" class="list-group-item  d-flex justify-content-between align-items-center list-group-item-action <?php echo (uri_string() == 'account/settings') ? 'active' : ''; ?>">
							<?php echo lang('users settings title'); ?><span class="text-right"><i class="icon-settings icons"></i>
						</a>
					</div>
				</div>
				<div class="col-md-9 mt-3">
						<?php // System messages ?>
						<?php if ($this->session->flashdata('message')) : ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<?php echo $this->session->flashdata('message'); ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						<?php elseif ($this->session->flashdata('error')) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo $this->session->flashdata('error'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
						<?php elseif (validation_errors()) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo validation_errors(); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
						<?php elseif ($this->error) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									 <?php echo $this->error; ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
						<?php endif; ?>
						<?php // Main content ?>
        		<?php echo $content; ?>
				</div>
			</div>
        

    </div>
	</main>
								

    <?php // Footer ?>
    <footer>
			
			<div class="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-10">
							<ul class="list-inline">
								<li class="list-inline-item mr-4"><a href="<?php echo base_url('agreement'); ?>"><?php echo lang('core button terms'); ?></a></li>
								<li class="list-inline-item mr-4"><a href="<?php echo base_url('privacy'); ?>"><?php echo lang('core button privacy'); ?></a></li>
								<li class="list-inline-item mr-4"><a href="<?php echo base_url('instructions'); ?>"><?php echo lang('core button instructions'); ?></a></li>
							</ul>
						</div>
						<div class="col-md-2">
							<div class="dropdown dropup text-right">
								<button id="session-language" class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php echo lang('core button language'); ?>
								</button>
								<div id="session-language-dropdown" class="dropdown-menu" aria-labelledby="session-language">
									<?php foreach ($this->languages as $key=>$name) : ?>
									<a class="dropdown-item" href="#" rel="<?php echo $key; ?>">
											<?php if ($key == $this->session->language) : ?>
													<i class="icon-arrow-right icons"></i>
											<?php endif; ?>
											<?php echo $name; ?>
									</a>
									<?php endforeach; ?>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
        
    </footer>
	
	 <!-- Placed at the end of the document so the pages load faster 
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="<?php echo base_url();?>assets/themes/account/js/countrySelect.min.js"></script>
<script>
  $("#country").countrySelect();
</script>

<script>
	var position = 0;
	var scrollHeight = Math.max(
  document.body.scrollHeight, document.documentElement.scrollHeight,
  document.body.offsetHeight, document.documentElement.offsetHeight,
  document.body.clientHeight, document.documentElement.clientHeight
);

$(window).scroll(function(e) {
  var $element = $('.header-st');
  var scrollTop = $(this).scrollTop();
  if( scrollTop <= 10 ) { 
    $element.removeClass('hide').removeClass('scrolling');
  } else if( scrollTop < position ) {
    $element.removeClass('hide');
  } else if( scrollTop > position && scrollHeight > 1000) {
    $element.addClass('scrolling');
    if( scrollTop + $(window).height() >=  $(document).height() - $element.height() ){
      $element.removeClass('hide');
    } else if(Math.abs($element.position().top) < $element.height()) {
      $element.addClass('hide');
    }
  }
  position = scrollTop;
})			
</script>
-->	
							
	
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script>
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
</script>
<script src="<?php echo base_url();?>assets/themes/account/js/countrySelect.min.js"></script>
<script>
  $("#country").countrySelect();
</script>
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

<?php // Javascript files ?>
    <?php if (isset($js_files) && is_array($js_files)) : ?>
        <?php foreach ($js_files as $js) : ?>
            <?php if ( ! is_null($js)) : ?>
                <?php $separator = (strstr($js, '?')) ? '&' : '?'; ?>
                <?php echo "\n"; ?><script type="text/javascript" src="<?php echo $js; ?><?php echo $separator; ?>v=<?php echo $this->settings->site_version; ?>"></script><?php echo "\n"; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (isset($js_files_i18n) && is_array($js_files_i18n)) : ?>
        <?php foreach ($js_files_i18n as $js) : ?>
            <?php if ( ! is_null($js)) : ?>
                <?php echo "\n"; ?><script type="text/javascript"><?php echo "\n" . $js . "\n"; ?></script><?php echo "\n"; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
							
</body>
</html>
