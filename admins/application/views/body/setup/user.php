		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">User</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>user</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-12">
									<span class="pull-left">
										<a href="javascript:;" class="btn btn-primary add_user_btn">Add User</a>
									</span>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<table id="dt_users" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>Fullname</th>
										<th>Username</th>
										<th>Server</th>
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

		<div class="modal fade" id="add_adminUser">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Add</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="add_adminUser">
							
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary submit_adminUser">Submit</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="update_adminUser">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Update</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="update_adminUser">
							
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary update_adminUser">Submit</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>