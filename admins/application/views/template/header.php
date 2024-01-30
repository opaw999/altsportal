<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>AltSPortal | <?php echo ucwords(strtolower($menu)); ?></title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link rel="shortcut icon" href="<?php echo base_url('favicon (1).ico'); ?>" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/css/all.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/default/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/default/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/default/theme/default.css'); ?>" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo base_url('assets/plugins/parsley/src/parsley.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-content-full-height">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="<?php echo base_url(); ?>" class="navbar-brand"><span class=""><img src="<?php echo base_url('assets/img/logo/tklogo.png'); ?>" width="168" height="28"></span></a>
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end navbar-header -->
			
			<!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				<li>
					<a href="<?php echo base_url(); ?>">
						<i class="fa fa-envelope"></i>
						<span class="label count_unread_msg"><?php echo $this->email_model->count_unread_msg(); ?></span>
					</a>
				</li>
				<li class="dropdown navbar-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url('assets/img/user/user-1.png'); ?>" alt="" /> 
						<span class="d-none d-md-inline"><?php echo $_SESSION['admin_username']; ?></span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="<?php echo base_url('page/menu/admin/account'); ?>" class="dropdown-item">Change Account Details</a>
						<div class="dropdown-divider"></div>
						<a href="<?php echo base_url('logout'); ?>" class="dropdown-item">Log Out</a>
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->