<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>AltSPortal | <?php if($title == 'dtr'): echo strtoupper($title); else: echo ucwords(strtolower($title)); endif; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta content="Timekeeping Portal" name="description" />
	<meta content="altsportal,timekeeping,portal,timekeeping portal,dtr" name="keywords">
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link rel="shortcut icon" href="<?php echo base_url('favicon (1).ico'); ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url('favicon (1).ico'); ?>" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/css/all.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/e-commerce/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/e-commerce/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/e-commerce/theme/default.css'); ?>" id="theme" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/dataTables/datatables.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/parsley/src/parsley.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>