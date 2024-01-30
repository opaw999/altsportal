		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">Supplier</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>Supplier (Company/Agency)</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="javascript:;" class="btn btn-primary active" onclick="add_details()">Add New Supplier</a>
						</div>
						<div class="panel-body">
							<table id="dt_supplier" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>Supplier</th>
										<th>Type</th>
										<th>Status</th>
										<th>Date Added</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="supplier_details">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Supplier Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="supplier_form">
						<div class="modal-body">
							<div class="supplier_details">
								
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
			function add_details() {

				$("div#supplier_details").modal({
				    backdrop: 'static',
				    keyboard: false
				});

				$("div#supplier_details").modal("show");

				$.ajax({
			        url  : "<?php echo site_url('add_supplier_details'); ?>",
			        success : function(result){

			            $("div.supplier_details").html(result);
			        }
			    });
			}
		</script>