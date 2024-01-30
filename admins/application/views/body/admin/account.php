		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Admin</a></li>
				<li class="breadcrumb-item active">Change Account Details</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Change Account Details</h1>
			<!-- end page-header -->

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">Username</h4>
						</div>
						<form id="data_username" data-parsley-validate="true">
							<div class="panel-body">
								<p>
									<i><span class="text-danger">Note:</span> <code>Username should be unique</code>, must contain only letters, numbers and underscores and at least 5 or more characters.</i>
								</p>
								<input type="hidden" name="user_no" value="<?php echo $_SESSION['adminId']; ?>">
								<div class="form-group">
									<label>Current Username</label>
									<input type="text" name="current_username" class="form-control" data-parsley-minlength="5" data-parsley-required="true" autocomplete="off">
								</div>
								<div class="form-group">
									<label>New Username</label>
									<input type="text" name="new_username" class="form-control" data-parsley-minlength="5" data-parsley-required="true" autocomplete="off">
								</div>
								<div class="form-group">
									<label>Re-type New Username</label>
									<input type="text" name="retype_username" class="form-control" data-parsley-minlength="5" data-parsley-equalto="[name = 'new_username']" data-parsley-required="true" autocomplete="off">
								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-md-12">
										<span class="pull-right"><button type="submit" class="active btn btn-primary">Submit</button></span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">Password</h4>
						</div>
						<form id="data_password" data-parsley-validate="true">
							<div class="panel-body">
								<p>
									<i><span class="text-danger">Note:</span> <code>Password is alphanumeric</code>. Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters. </i>
								</p>
								<input type="hidden" name="user_no" value="<?php echo $_SESSION['adminId']; ?>">
								<div class="form-group">
									<label>Current Password</label>
									<input type="password" name="current_password" class="form-control" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-parsley-type="alphanum" data-parsley-required="true" data-parsley-minlength="8">
								</div>
								<div class="form-group">
									<label>New Password</label>
									<input type="password" name="new_password" class="form-control" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-parsley-type="alphanum" data-parsley-required="true" data-parsley-minlength="8">
								</div>
								<div class="form-group">
									<label>Re-type New Password</label>
									<input type="password" name="retype_password" class="form-control" data-parsley-pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-parsley-type="alphanum" data-parsley-required="true" data-parsley-minlength="8" data-parsley-equalto="[name = 'new_password']">
								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-md-12">
										<span class="pull-right"><button type="submit" class="active btn btn-primary">Submit</button></span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>