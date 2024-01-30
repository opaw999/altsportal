	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Masterfile</b></h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->
	
	<!-- BEGIN #product -->
	<div class="section-container">
		<!-- BEGIN container -->
		<div class="container">
			<!-- BEGIN breadcrumb -->
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">Masterfile</li>
			</ul>
			<!-- END breadcrumb -->
			<div class="checkout">
				<div class="checkout-header">
					<div class="row">
						<?php if (isset($alturas)) { ?>
							<div class="col-md-3 col-sm-3">
								<div class="step active step_tagbilaran">
									<a href="javascript:void(0);" id="tagbilaran" class="server">
										<div class="number">1</div>
										<div class="info">
											<div class="title">Tagbilaran, Bohol</div>
											<div class="desc">Alturas Mall, ICM , Plaza Marcela & Alta Citta</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="step step_tubigon_">
									<!-- <a href="javascript:void(0);" id="tubigon" class="server_"> -->
										<div class="number">2</div>
										<div class="info">
											<div class="title">Tubigon, Bohol</div>
											<div class="desc">Alturas Tubigon</div>
										</div>
									<!-- </a> -->
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="step step_talibon">
									<a href="javascript:void(0);" id="talibon" class="server">
										<div class="number">3</div>
										<div class="info">
											<div class="title">Talibon, Bohol</div>
											<div class="desc">Alturas Talibon</div>
										</div>
									</a>
								</div>
							</div>
						<?php } else { ?>
							<div class="col-md-3 col-sm-3">
								<div class="step active step_tagbilaran">
									<div class="number">1</div>
									<div class="info">
										<div class="title">Tagbilaran, Bohol</div>
										<div class="desc">Alturas Mall, ICM , Plaza Marcela & Alta Citta</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="step step_tubigon_">
									<div class="number">2</div>
									<div class="info">
										<div class="title">Tubigon, Bohol</div>
										<div class="desc">Alturas Tubigon</div>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="step step_talibon">
									<div class="number">3</div>
									<div class="info">
										<div class="title">Talibon, Bohol</div>
										<div class="desc">Alturas Talibon</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<div class="col-md-3 col-sm-3">
							<div class="step step_colonnade">
								<?php if (isset($colonnade)) { ?>
									<a href="javascript:void(0);" id="colonnade" class="server">
										<div class="number">4</div>
										<div class="info">
											<div class="title">Cebu</div>
											<div class="desc">Colonnade Colon & Mandaue</div>
										</div>
									</a>
								<?php } else { ?>
									<div class="number">4</div>
									<div class="info">
										<div class="title">Cebu</div>
										<div class="desc">Colonnade Colon & Mandaue</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="checkout-body">
					<input type="hidden" name="server" value="tagbilaran">
					<input type="hidden" name="year" value="<?php echo date("Y"); ?>">
					<input type="hidden" name="month" value="<?php echo date("m"); ?>">
					<input type="hidden" name="emp_id" value="">
					<input type="hidden" name="emp_type" value="">
					<div class="table-responsive">
						<table id="dt_masterfile" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th> Fullname</th>
									<th> Company</th>
									<th> BusinessUnit</th>
									<th> Position</th>
									<th> PromoType</th>
									<th> CutOff</th>
									<th> Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal fade" id="view_schedule">
	  	<div class="modal-dialog modal-lg" style="max-width: 1100px;">
	    	<div class="modal-content">
	    		<div class="modal-header">
	    	  	  	<h4 class="modal-title">View Schedule</b></h4>
	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	    	  	</div>
	    	  	<div class="modal-body view_schedule">
	    	  	  	
	    	  	</div>
	    	  	<div class="modal-footer">
	    	  		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	    	  	</div>
	    	</div>
	  	</div>
	</div>