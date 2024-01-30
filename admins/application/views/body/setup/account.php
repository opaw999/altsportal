		<style type="text/css">
			
			td.details-control {
		        background: url('<?php echo base_url('assets/img/datatables/details_open.png'); ?>') no-repeat center center;
		        cursor: pointer;
		    }

		    tr.shown td.details-control {
		        background: url('<?php echo base_url('assets/img/datatables/details_close.png'); ?>') no-repeat center center;
		    }
		</style>
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">Account</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>user account</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="javascript:;" class="btn btn-primary active create_account_btn">Create Account</a>
							<button class="btn btn-sm btn-success active generate_excel">Generate Excel <img src="<?php echo base_url('assets/img/icon/excel-xls-icon.png'); ?>"></button>
						</div>
						<div class="panel-body">
							<table id="dt_userAccount" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>Agency/Company Name</th>
										<th>Username</th>
										<th>Password</th>
										<th>Date Created</th>
										<th>Status</th>
										<th>Login</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="extend_contract">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Renew Contract</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="extend_contract">
							
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary submit_contract">Submit</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="setup_cutoff">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Setup Cut-off</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="setup_cutoff">
							
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="create_account">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Create Account</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form>
						<div class="modal-body">
							<div class="create_account">
								
							</div>
						</div>
						<div class="modal-footer">
							<a href="javascript:;" class="btn btn-primary submit_account">Submit</a>
							<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
						</div>
					</form>
				</div>
			</div>
		</div>