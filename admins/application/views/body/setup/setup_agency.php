		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setup</a></li>
				<li class="breadcrumb-item active">Agency</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setup <small>company for agency</small></h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-12">
									<span class="pull-right">
										<a href="javascript:;" class="btn btn-primary setup_company_btn">Setup Company for Agency</a>
									</span>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<table id="dt_company" class="table table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>Agency/Supplier Name</th>
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

		<div class="modal fade" id="setup_company">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Setup Company for Agency</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="setup_company">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Agency Name:</label>
										<select name="setupan_agency" class="form-control">
											<option value="">Select Agency</option>
											<?php 

												$agencies = $this->setup_model->list_of_agencies();
												foreach ($agencies as $agency) {
													
													echo '<option value="'.$agency->agency_code.'">'.$agency->agency_name.'</option>';
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<br>
							<div class="companies" style="overflow-y: auto; max-height: 350px;">
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary submit_company">Submit</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>