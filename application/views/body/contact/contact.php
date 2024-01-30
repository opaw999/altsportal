	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Contact</b> Us</h1>
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
				<li class="breadcrumb-item active">Contact Us</li>
			</ul>
			<!-- END breadcrumb -->
			<!-- BEGIN row -->
			<div class="row row-space-30">
				<!-- BEGIN col-8 -->
				<div class="col-md-8">
					<h4 class="m-t-0">Contact Form</h4>
					<p class="m-b-30 f-s-13">
						For further information, clarification, suggestion and concerns, please feel free to contact us by sending us message below (Please fill in all required data upon submission). 
						All messages, will be accommodated by our authorized HRD Staff and IT Administrator.
					</p>
					<form class="form-horizontal" name="contact_us_form" action="" method="POST" data-parsley-validate="true">
						<input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>">
						<div class="form-group row">
							<label class="col-form-label col-md-3 text-lg-right">Company/Agency <span class="text-danger">*</span></label>
							<div class="col-md-7">
								<input type="text" class="form-control"  name="sender" value="<?= $supplier->supplier; ?>" readonly=""/>
							</div>
						</div>
						<input type="hidden" name="email" value="<?php echo $this->contact_model->email_add($_SESSION['userId'])['email_address']; ?>"/>
						<div class="form-group row">
							<label class="col-form-label col-md-3 text-lg-right">Subject <span class="text-danger">*</span></label>
							<div class="col-md-7">
								<input type="text" class="form-control" name="subject" data-parsley-required="true" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-md-3 text-lg-right">Message <span class="text-danger">*</span></label>
							<div class="col-md-7">
								<textarea class="form-control" rows="10" name="message" data-parsley-required="true" ></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-md-3"></label>
							<div class="col-md-7">
								<button type="submit" id="submit_btn" class="btn btn-primary btn-lg">Send Message</button>
							</div>
						</div>
					</form>
				</div>
				<!-- END col-8 -->
				<!-- BEGIN col-4 -->
				<div class="col-md-4">
					<h4 class="m-t-0">Our Contacts</h4>
					<div class="embed-responsive embed-responsive-16by9 m-b-15">
						<iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3933.300863864775!2d123.86756191435927!3d9.655313393087972!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aa4c30923688e3%3A0xbf744e652643049b!2sIsland+City+Mall!5e0!3m2!1sen!2sph!4v1540889503220" allowfullscreen></iframe>
					</div>
					<div><b>Head Office</b></div>
					<p class="m-b-15">
						AGC Corporate Center, North Wing ICM Bldg.,<br />
						Dampas District, Tagbilaran City, Bohol<br />
						Telephone: 501-3000<br />
						Cellphone: 09255701710 / 09082048438<br />
					</p>
					<div><b>Email</b></div>
					<p class="m-b-15">
						<a href="mailto:corporatehrd@alturasbohol.com" class="text-inverse">corporatehrd@alturasbohol.com</a><br />
					</p>
					<div class="m-b-5"><b>Social Network</b></div>
					<p class="m-b-15">
						<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-facebook"></i></a>
						<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-twitter"></i></a>
						<a href="mailto:corporatehrd@alturasbohol.com" target="_blank" class="btn btn-icon btn-white btn-circle"><i class="fab fa-google"></i></a>
						<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-instagram"></i></a>
					</p>
				</div>
				<!-- END col-4 -->
			</div>
			<!-- END row -->
		</div>
		<!-- END row -->
	</div>
	<!-- END #product -->