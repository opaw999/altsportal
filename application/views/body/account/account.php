    <style type="text/css">
		
		.upload-btn-wrapper {
		  	position: relative;
		  	overflow: hidden;
		  	display: inline-block;
		}

		.btn_image {
		  	border: 2px solid blue;
		  	color: gray;
		  	background-color: white;
		  	padding: 8px 20px;
		  	border-radius: 8px;
		  	font-size: 15px;
		  	font-weight: bold;
		}

		.upload-btn-wrapper input[type=file] {
		  	font-size: 100px;
		  	position: absolute;
		  	left: 0;
		  	top: 0;
		  	opacity: 0;
		}

		.modf {

		    float: right;
		    margin-top: -8px;
		}

		.text_color {

			color: rgb(0, 172, 172);
		}

		.profilePhoto {
		  
		    background-image: url("<?php echo base_url('assets/img/user/images.png'); ?>");
		    background-size:contain;
		    width:270px;
		    height:270px;
		    border:2px solid #BBD9EE;
		}
	</style>
	<div id="page-header" class="section-container page-header-container bg-black">
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<div class="container">
			<h1 class="page-header"><b>My</b> Account </h1>
		</div>
	</div>

	<input type="hidden" name="supplier_name" value="<?php echo $supplier->supplier; ?>">
	<div id="search-results" class="section-container bg-silver">
		<div class="container">
			<div class="search-container">
				<div class="search-content">
					<div class="search-toolbar">
						<div class="row">
							<div class="col-md-12 content_">
								
							</div>
						</div>
					</div>
				</div>
				<div class="search-sidebar">
					<h4 class="title">My Account</h4>
					<input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>">
					<ul class="search-category-list">
						<li><a href="javascript:;" class="profile text_color" id="basic_info"><i class="fa fa-user"></i>&nbsp; Profile </a></li>
						<li><a href="javascript:;" class="profile" id="change_username"><i class="fa fa-user-circle"></i>&nbsp; Change Username </a></li>
						<li><a href="javascript:;" class="profile" id="change_password"><i class="fa fa-lock"></i>&nbsp; Change Password </a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal fade" id="profilePic">
	  	<div class="modal-dialog" style="width: 35%;">
	    	<div class="modal-content">
	    		<form action="" id="dataProfilePic" method="post" enctype="multipart/form-data">
		    		<div class="modal-header">
		    	  	  	<h4 class="modal-title">Upload Photo</b></h4>
		    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
		    	  	</div>
		    	  	<div class="modal-body profilePic">
		    	  	  	
		    	  	</div>
		    	  	<div class="modal-footer">
		    	  		<button type="submit" class="btn btn-primary">Upload</button>
		    	  		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		    	  	</div>
	    	  	</form>
	    	</div>
	  	</div>
	</div>