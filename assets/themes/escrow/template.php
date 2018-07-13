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
    <meta name="author" content="Just Digital Tech">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
	  <link rel="icon" type="image/x-icon" href="/favicon.ico?v=<?php echo $this->settings->site_version; ?>">
    <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>
		<meta name="keywords" content="<?php echo $this->settings->meta_keywords; ?>">
    <meta name="description" content="<?php echo $this->settings->meta_description; ?>">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/themes/escrow/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/themes/escrow/css/escrow.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
		<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

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
					<a href="<?php echo base_url('account/transactions'); ?>" class="btn btn-success my-2 my-sm-0"><?php echo lang('core button my_account'); ?></a>
					<?php else : ?>
          <a href="<?php echo base_url('login'); ?>" class="btn btn-outline-light my-2 my-sm-0 mr-3"><?php echo lang('core button sign_in'); ?></a>
          <a href="<?php echo base_url('user/register'); ?>" class="btn btn-success my-2 my-sm-0"><?php echo lang('core button create'); ?></a>
					<?php endif; ?>
        </div>
				
      </div>
		</div>
    </nav>

    <?php // Main body ?>
	<main>
    <?php // Main content ?>
        <?php echo $content; ?>
	</main>
	
	<?php // System messages ?>
        <?php if ($this->session->flashdata('message')) : ?>
				<div class="notify-popup">
					<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
						<div class="container">
						<?php echo $this->session->flashdata('message'); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
					</div>
				</div>
        <?php elseif ($this->session->flashdata('error')) : ?>
					<div class="notify-popup">
						<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
							<div class="container">
							<?php echo $this->session->flashdata('error'); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
						</div>
					</div>
        <?php elseif (validation_errors()) : ?>
					<div class="notify-popup">
						<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
							<div class="container">
							<?php echo validation_errors(); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
						</div>
					</div>
        <?php elseif ($this->error) : ?>
					<div class="notify-popup">
						<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
							<div class="container">
							 <?php echo $this->error; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
						</div>
					</div>
        <?php endif; ?>

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
	
	 <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	
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
