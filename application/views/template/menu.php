<!--BEGIN #page-container -->
<div id="page-container" class="fade">
	<!-- BEGIN #top-nav -->
	<div id="top-nav" class="top-nav">
		<!-- BEGIN container -->
		<div class="container">
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Career</a></li>
					<li><a href="#"><i class="fab fa-facebook-f f-s-14"></i></a></li>
					<li><a href="#"><i class="fab fa-twitter f-s-14"></i></a></li>
					<li><a href="#"><i class="fab fa-instagram f-s-14"></i></a></li>
					<li><a href="mailto:corporatehrd@alturasbohol.com" target="_blank"><i class="fab fa-google f-s-14"></i></a></li>
				</ul>
			</div>
		</div>
		<!-- END container -->
	</div>
	<!-- END #top-nav -->
	
	<!-- BEGIN #header -->
	<div id="header" class="header">
		<!-- BEGIN container -->
		<div class="container">
			<!-- BEGIN header-container -->
			<div class="header-container">
				<!-- BEGIN navbar-header -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="header-logo">
						<a href="<?php echo base_url(); ?>">
							<span class=""><img src="<?php echo base_url('assets/img/logo/asp11.png'); ?>" width="70%"></span>
							
						</a>
					</div>
				</div>
				<!-- END navbar-header -->
				<!-- BEGIN header-nav -->
				<div class="header-nav">
					<div class=" collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav">
							<li <?php if ($title == "about" ) { echo "class = 'active'"; } ?>><a href="<?php echo base_url('page/menu/about'); ?>">Home</a></li>
							<li <?php if ($title == "dtr" ) { echo "class = 'active'"; } ?>><a href="<?php echo base_url('page/menu/dtr'); ?>">DTR</a></li>
							<li class="dropdown dropdown-hover <?php if ($title == "violation") { echo 'active'; } ?>">
								<a href="#" data-toggle="dropdown">
									Violation Monitoring
									<b class="caret"></b>
									<span class="arrow top"></span>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="<?php echo base_url('page/menu/violation/supplier'); ?>">Per Supplier</a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/violation/employee'); ?>">Per Employee</a>
								</div>
							</li>
							<li class="dropdown dropdown-hover">
								<a href="#" data-toggle="dropdown">
									Supplier's Data
									<b class="caret"></b>
									<span class="arrow top"></span>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/vis'); ?>"> Vendor's Information </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/cas'); ?>"> Concessionaires Agreement </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/po'); ?>"> Purchase Order (P.O.) </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/items'); ?>"> Items </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/sales'); ?>"> Sales & Commission </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/deductions'); ?>"> Deductions </a>
									<a class="dropdown-item" href="<?php echo base_url('page/menu/cms/check'); ?>"> Check Monitoring </a>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- END header-nav -->
				<!-- BEGIN header-nav -->
				<div class="header-nav">
					<ul class="nav pull-right">
						<li>
							<a href="<?php echo base_url('page/menu/message'); ?>" class="header-cart">
								<i class="fa fa-envelope"></i>
								<span class="total"><?= $message->count ?></span>
								<span class="arrow top"></span>
							</a>
						</li>
						<li class="divider"></li>
						<li class="dropdown dropdown-hover">
							<a href="#" data-toggle="dropdown">
								<?php 

									if ($supplier->photo == "") {
										
										$supplier->photo = "assets/img/user/user-1.png";
									}
								?>
								<img src="<?php echo base_url("$supplier->photo"); ?>" class="user-img" alt=""> 
								<span class="d-none d-xl-inline">
									<?php 

										if (strlen($supplier->supplier) > 25) {
											
											echo substr($supplier->supplier, 0, 25)."..."; 
										} else {

											echo $supplier->supplier;
										}
									?>
										
								</span>
								<b class="caret"></b>
								<span class="arrow top"></span>
							</a>
							<div class="dropdown-menu">
								<a href="<?php echo base_url('page/menu/account'); ?>" class="dropdown-item">My Account</a>
								<a href="<?php echo base_url('logout'); ?>" class="dropdown-item">Log Out</a>
							</div>
						</li>
					</ul>
				</div>
				<!-- END header-nav -->
			</div>
			<!-- END header-container -->
		</div>
		<!-- END container -->
	</div>