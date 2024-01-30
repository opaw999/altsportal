		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">Agency List</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>Agency</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-12">
									<span class="pull-right">
										<a href="javascript:;" class="btn btn-primary add_agency_btn">Add Agency</a>
									</span>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<table id="dt_agency_list" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Agency Name</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="add_agency">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add Agency</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="add_agency">
							<div class="form-group">
								<label>Agency Name:</label>
								<input type="text" name="agency_name" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary submit_agency">Submit</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="update_agency">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Update Agency</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<form id="updated_agency">
						<div class="modal-body">
							<div class="update_agency">
								
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary sub_updated_agency">Submit</button>
							<button class="btn btn-white" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>