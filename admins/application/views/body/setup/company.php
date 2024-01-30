		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">Company List</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>Company</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-12">
									<span class="pull-right">
										<a href="javascript:;" class="btn btn-primary add_company_btn">Add Company</a>
									</span>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<table id="dt_company_list" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Company Name</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="add_companies">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Company</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="added_company">
						<div class="modal-body">
							<div class="add_companies">
								<div class="form-group">
									<label>Company Name:</label>
									<input type="text" name="company_name" class="form-control">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary submit_companies">Submit</button>
							<button href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="update_company">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Update Company</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="updated_company">
						<div class="modal-body">
							<div class="update_company">
								
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary sub_updated_company">Submit</button>
							<button class="btn btn-white" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>