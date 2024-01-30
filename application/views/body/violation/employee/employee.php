	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Employee's</b> Violation</h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->

	<div id="product" class="section-container p-t-20">
		<div class="container">
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">Employee's Violation</li>
			</ul>
			<div class="card">
			  	<div class="card-header"><i class="fa fa-list-ol"></i> List of Cut-offs</div>
			  	<div class="card-body bg-light">
			  		<p class="card-text">
			  			<div class="btn-group btn-group-md">
				  			<?php 
				  				// echo $_SESSION['userId'];
				  				$cutoffs = $this->dtr_model->list_of_cutoffs();
				  				$count = 0;
				  				$first_cutoff = '';
				  				foreach ($cutoffs as $row) {
				  					
				  					if ($row['endFC'] == '') {
				  					  	
				  					  	$endFC = "Last";

				  					} else {
				  					  
				  					  	$endFC = $row['endFC'];   
				  					}

				  					$cutoff = $row['statCut'];
				  					$promo_cutOff = $row['startFC']."-".$endFC." / ".$row['startSC']."-".$row['endSC'];

				  					$enabled_cutoff = $this->dtr_model->check_user_cutoff($_SESSION['supplier_id'], $cutoff)['row'];
				  					if ($enabled_cutoff > 0) {
				  						
				  						$count++;
				  						if ($count == 1) {
				  							
				  							$first_cutoff = $cutoff;
					  						echo "<a href='javascript:void(0);' id='cutoff_".$cutoff."' class='btn btn-danger cutoff'>".$promo_cutOff."</a> ";
					  					} else {
					  						
					  						echo "<a href='javascript:void(0);' id='cutoff_".$cutoff."' class='btn btn-primary cutoff'>".$promo_cutOff."</a> ";
					  					}
					  				}
				  				}
				  			?>
			  			</div>
			  		</p>
			  		<input type="hidden" name="first_cutoff" value="<?php echo $first_cutoff; ?>">
			  		<table id="dt_dtr" class="table table-bordered table-hover" width="100%">
			  			<thead>			                
			  				<tr>
			  					<th><i class="fa fa-fw fa-calendar hidden-md hidden-sm hidden-xs"></i> Date From</th>
			  					<th><i class="fa fa-fw fa-calendar hidden-md hidden-sm hidden-xs"></i> Date To</th>
			  					<th> Action</th>
			  				</tr>
			  			</thead>
			  		</table>
			  	</div>
			</div>
		</div>
	</div>

	<!-- The Modal -->
  	<div class="modal fade" id="view_employee">
  	  	<div class="modal-dialog modal-lg" style="max-width: 1200px;">
  	    	<div class="modal-content">
  	    		<div class="modal-header">
  	    	  	  	<h4 class="modal-title">Employee's Violation <b>( <span id="emp_cutoff"></span> )</b></h4>
  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
  	    	  	</div>
  	    	  	<div class="modal-body view_employee">
  	    	  	  	
  	    	  	</div>
  	    	  	<div class="modal-footer">
  	    	  	  	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  	    	  	</div>
  	    	</div>
  	  	</div>
  	</div>

  	<!-- The Modal -->
  	<div class="modal fade" id="view_violation">
  	  	<div class="modal-dialog" style="max-width:900px;">
  	    	<div class="modal-content">
  	    	  	<div class="modal-header">
  	    	  	  	<h4 class="modal-title">Employee's Violation <b>( <span id="emp_cutoff"></span> )</b></h4>
  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
  	    	  	</div>
  	    	  	<form action="<?php echo base_url('print/print_employee_violation') ?>" method="get" target="_blank">
      	    	  	<div class="modal-body view_violation">
      	    	  	  	
      	    	  	</div>
      	    	  	<div class="modal-footer">
      	    	  	    <button type="submit" class="btn btn-primary">
    						Print to PDF
    					</button>
      	    	  		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      	    	  	</div>
      	    	</form>
  	    	</div>
  	  	</div>
  	</div>