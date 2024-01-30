	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Violation</a></li>
			<li class="breadcrumb-item active">Upload File</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Violation <small>Upload Promo Violation</small></h1>
		<!-- end page-header -->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span><i class="fa fa-list-ol"></i> List of Cut-offs</span>
						<br>
						<br>
						<?php 

							$count = 1;
							foreach ($cutoffs as $row) {
								
			  					if ($row['endFC'] == '') {
			  					  	
			  					  	$endFC = "Last";

			  					} else {
			  					  
			  					  	$endFC = $row['endFC'];   
			  					}

			  					$cutoff = $row['statCut'];
			  					$promo_cutOff = $row['startFC']."-".$endFC." / ".$row['startSC']."-".$row['endSC'];

		  						
		  						if ($count == 1) {
		  							
		  							$first_cutoff = $cutoff;
			  						echo "<a href='javascript:void(0);' id='cutoff_".$cutoff."' class='btn btn-danger cutoff'>".$promo_cutOff."</a> ";
			  					} else {
			  						
			  						echo "<a href='javascript:void(0);' id='cutoff_".$cutoff."' class='btn btn-info cutoff'>".$promo_cutOff."</a> ";
			  					}

			  					$count++;
							}
						?>
					</div>
					<div class="panel-body">
						<input type="hidden" name="first_cutoff" value="<?= $first_cutoff; ?>">
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
	</div>

	<!-- The Modal -->
  	<div class="modal fade" id="view_employee">
  	  	<div class="modal-dialog modal-lg" style="max-width: 1200px;">
  	    	<div class="modal-content">
  	    		<div class="modal-header">
  	    	  	  	<h4 class="modal-title">Upload Employee's Violation <b>( <span id="emp_cutoff"></span> )</b></h4>
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
  	<div class="modal fade" id="upload_violation">
  	  	<div class="modal-dialog modal-lg">
  	    	<div class="modal-content">
  	    		<form id="upload_pv" action="" method="post" enctype="multipart/form-data">
	  	    	  	<div class="modal-header">
	  	    	  	  	<h4 class="modal-title">Upload Employee's Violation <b>( <span id="emp_cutoff"></span> )</b></h4>
	  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	  	    	  	</div>
	  	    	  	<div class="modal-body upload_violation">
	  	    	  	  	
	  	    	  	</div>
	  	    	  	<div class="modal-footer">
	  	    	  		<button type="submit" class="btn btn-primary upload_violation">Upload File</button>
	  	    	  	  	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  	    	  	</div>
	  	    	</form>
  	    	</div>
  	  	</div>
  	</div>

  	<!-- The Modal -->
  	<div class="modal fade" id="view_violation">
  	  	<div class="modal-dialog modal-lg">
  	    	<div class="modal-content">
  	    		<form id="delete_pv" action="" method="post">
	  	    	  	<div class="modal-header">
	  	    	  	  	<h4 class="modal-title">Employee's Violation <b>( <span id="emp_cutoff"></span> )</b></h4>
	  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	  	    	  	</div>
	  	    	  	<div class="modal-body view_violation">
	  	    	  	  	
	  	    	  	</div>
	  	    	  	<div class="modal-footer">
	  	    	  		<button type="submit" class="btn btn-warning delete_violation">Delete Uploaded File</button>
	  	    	  	  	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  	    	  	</div>
	  	    	</form>
  	    	</div>
  	  	</div>
  	</div>