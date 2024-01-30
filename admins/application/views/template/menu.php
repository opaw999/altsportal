<?php

$user_type = $this->setup_model->adminUser($_SESSION['adminId'])->user_type;
?>
<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<a href="javascript:;" data-toggle="nav-profile">
					<div class="cover with-shadow"></div>
					<div class="image">
						<img src="<?php echo base_url('assets/img/user/user-1.png'); ?>" alt="" />
					</div>
					<div class="info">
						Admin
						<small>AltSPortal</small>
					</div>
				</a>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="has-sub <?php if ($menu == 'email') : echo 'active';
								endif; ?>">
				<a href="javascript:;">
					<i class="fa fa-envelope"></i>
					<span>Email</span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if ($submenu == 'email') : echo 'active';
								endif; ?>"><a href="<?php echo base_url(); ?>">Inbox</a></li>
				</ul>
			</li>

			<li class="has-sub <?php if ($menu == 'setup') : echo 'active';
								endif; ?>">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cog"></i>
					<span>Setup</span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if ($submenu == 'supplier') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/setup/supplier'); ?>">Supplier</a></li>
					<li class="<?php if ($submenu == 'supplier_account') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/setup/supplier_account'); ?>">Supplier Account</a></li>
					<li class="<?php if ($submenu == 'consignor_account') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/setup/consignor_account'); ?>">Consignor Account</a></li>
					<?php if ($user_type == "superadmin") : ?>
						<li class="<?php if ($submenu == 'user') : echo 'active';
									endif; ?>"><a href="<?php echo base_url('page/menu/setup/user'); ?>">User Account</a></li>
					<?php endif; ?>
				</ul>
			</li>
			<?php

			$servers = array('server_tag', 'server_colonnade');

			if (in_array($this->session->userdata('server'), $servers)) { ?>
				<li class="has-sub <?php if ($menu == 'violation') : echo 'active';
									endif; ?>">
					<a href="javascript:;">
						<b class="caret"></b>
						<i class="fa fa-file-archive"></i>
						<span>Violation</span>
					</a>
					<ul class="sub-menu">
						<li class="<?php if ($submenu == 'upload_file') : echo 'active';
									endif; ?>"><a href="<?php echo base_url('page/menu/violation/upload_file'); ?>">Upload File</a></li>
					</ul>
				</li>
			<?php
			}
			?>
		    <li class="has-sub <?= ($menu == 'masterfile') ? 'active' : ''; ?>">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-search fa-fw"></i>
					<span> View Promo Data </span>
				</a>
				<ul class="sub-menu">
					<li class="<?= ($submenu == 'view_masterfile') ? 'active' : ''; ?>">
						<a href="<?php echo base_url('page/menu/masterfile/view_masterfile'); ?>"> Masterfile</a>
					</li>
					<li class="<?= ($submenu == 'view_dtr') ? 'active' : ''; ?>">
						<a href="<?php echo base_url('page/menu/masterfile/view_dtr'); ?>"> DTR</a>
					</li>
				</ul>
		    </li>
			<li class="<?php if ($menu == 'import') : echo 'active';
						endif; ?>"><a href="<?php echo base_url('page/menu/import/data'); ?>"><i class="fas fa-file-import"></i> <span>Import</span></a></li>
			<li class="<?php if ($menu == 'import_violation') : echo 'active';
						endif; ?>"><a href="<?php echo base_url('page/menu/import_violation/data'); ?>"><i class="fas fa-file-import"></i> <span>Import Violation</span></a></li>


			<li class="has-sub <?php if ($menu == 'cms') : echo 'active';
								endif; ?>">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cog"></i>
					<span> CMS </span>
				</a>
				<ul class="sub-menu">
					<li class="<?php if ($submenu == 'vis') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/vis'); ?>">VIS</a></li>
					<li class="<?php if ($submenu == 'cas') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/cas'); ?>"> CAS </a></li>
					<li class="<?php if ($submenu == 'items') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/items'); ?>"> Items</a></li>
					<li class="<?php if ($submenu == 'po') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/po'); ?>"> P.O.</a></li>
					<li class="<?php if ($submenu == 'sales') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/sales'); ?>"> Sales (Items) </a></li>
					<li class="<?php if ($submenu == 'sales_summary') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/sales_summary'); ?>"> Sales Summary </a></li>
					<li class="<?php if ($submenu == 'sales_uploaded') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/sales_uploaded'); ?>"> Sales Uploaded File</a></li>
					<li class="<?php if ($submenu == 'deduction') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/deduction'); ?>"> Deduction </a></li>
					<li class="<?php if ($submenu == 'checks') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/checks'); ?>"> Checks Monitoring </a></li>
					<li class="<?php if ($submenu == 'check_voucher') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/check_voucher'); ?>"> Checks Voucher </a></li>
					<li class="<?php if ($submenu == 'check_details') : echo 'active';
								endif; ?>"><a href="<?php echo base_url('page/menu/cms/check_details'); ?>"> Checks Details </a></li>

				</ul>
			</li>

			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>