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
				<li class="breadcrumb-item active">Supplier Account</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>Supplier Account</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="javascript:;" class="btn btn-primary active" onclick="add_account()">Create Account</a>
							<button class="btn btn-sm btn-success active generate_excel">Generate Excel <img src="<?php echo base_url('assets/img/icon/excel-xls-icon.png'); ?>"></button>
						</div>
						<div class="panel-body">
							<table id="dt_supplier_account" class="table table-bordered" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>Supplier</th>
										<th>Username</th>
										<th>Contract Date</th>
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

		<div class="modal fade" id="supplier_account">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Supplier Account Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="supplier_account_form">
						<div class="modal-body">
							<div class="supplier_account">
								
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="renew_contract">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Renew Contract</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="renew_contract_form">
						<div class="modal-body">
							<div class="renew_contract">
								
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
						</div>
					</form>
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

		<div class="modal fade" id="edit_tag_ac">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Supplier Account Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="edit_tag_ac_form">
						<div class="modal-body">
							<div class="edit_tag_ac">
								
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function add_account() {

				$("div#supplier_account").modal({
				    backdrop: 'static',
				    keyboard: false
				});

				$("div#supplier_account").modal("show");

				$.ajax({
			        url  : "<?php echo site_url('add_supplier_account'); ?>",
			        success : function(result){

			            $("div.supplier_account").html(result);
			        }
			    });
			}

			function setup_supplier(id) {

				$("div.loading").show();
				$.ajax({
					method : "POST",
					data : { id: id },
			        url  : "<?php echo site_url('setup_supplier'); ?>",
			        success : function(result){

			        	$("div.loading").hide();
			            $("div.setup_supplier").html(result);
			        }
			    });
			}
		</script>