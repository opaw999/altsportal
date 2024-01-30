	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Chat</b> Message</h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->
	
	<!-- BEGIN #product -->
	<div id="product" class="section-container p-t-20">
		<!-- BEGIN container -->
		<div class="container">
			<!-- BEGIN breadcrumb -->
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">Chat Message</li>
			</ul>
			<!-- END breadcrumb -->
			<!-- BEGIN row -->
			<style>
				.sudlanan {
				  	border: 2px solid #dedede;
				  	background-color: #f1f1f1;
				  	border-radius: 5px;
				  	padding: 10px;
				  	margin: 10px 0;
				}

				.darker {
				  	border-color: #ccc;
				  	background-color: #ddd;
				}

				.sudlanan::after {
				  	content: "";
				  	clear: both;
				  	display: table;
				}

				.sudlanan img {
				  	float: left;
				  	max-width: 60px;
				  	width: 100%;
				  	margin-right: 20px;
				  	border-radius: 50%;
				}

				.sudlanan > img.right {
				  	float: right;
				  	margin-left: 20px;
				  	margin-right:0;
				}

				.time-right {
				  	float: right;
				  	color: #aaa;
				}

				.time-left {
				  	float: left;
				  	color: #999;
				}

				#msg_history {
				    height: 350px;
				    overflow-y: auto;
				    margin-right: -15px;
				}
			</style>
			<div class="row row-space-30">
				<div class="col-md-12" id="msg_history"></div>
			</div>
			<!-- END row -->
			<div class="row row-space-30" style="margin-top: 15px;">
				<div class="col-md-12">
					<div class="form-group">
						<label>Message</label>
						<textarea class="write_msg form-control" rows="4"></textarea>
					</div>
				</div>
			</div>
			<div class="row row-space-30">
				<div class="col-md-12">
					<button class="btn btn-success msg_send_btn pl-5 pr-5">Send</button>
				</div>
			</div>
		</div>
		<!-- END row -->
	</div>
	<!-- END #product -->