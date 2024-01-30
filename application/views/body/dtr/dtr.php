	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Daily</b> Time Record</h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->

	<div id="product" class="section-container p-t-20">
		<div class="container">
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">Daily Time Record</li>
			</ul>
			<div class="row">
      	        <div class="col-md-12">
      	            <div class="alert alert-info" role="alert">
                      <h4 class="alert-heading">Important Notice!</h4>
                      <p>For all DTR concerns, kindly contact Corporate HRD c/o Maam Coney Yelen Cornito and Maam Antonia Salamat 
                      through their company mobile #09190794826 and #09088152975 or email them at 
                      corporatehrd@alturasbohol.com to facilitate your concerns. Thank you.</p>
      	            </div>
      	        </div>
      	    </div>
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
			  		<table id="dt_dtr" class="table table-striped table-bordered table-hover" width="100%">
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
  	    		<form id="data_print_dtr" action="<?php echo base_url('print/print_dtr') ?>" method="get" target="_blank">
	  	    	  	<div class="modal-header">
	  	    	  	  	<h4 class="modal-title">Employee's DTR <b>( <span id="emp_cutoff"></span> )</b></h4>
	  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	  	    	  	</div>
	  	    	  	<div class="modal-body view_employee">
	  	    	  	  	
	  	    	  	</div>
	  	    	  	<div class="modal-footer">
	  	    	  		<button type="submit" class="btn btn-primary" id="print_dtr" disabled="">
							Print to PDF
						</button>
	  	    	  	  	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  	    	  	</div>
	  	    	</form>
  	    	</div>
  	  	</div>
  	</div>

  	<!-- The Modal -->
  	<div class="modal fade" id="view_dtr">
  	  	<div class="modal-dialog modal-lg" style="max-width: 1200px;">
  	    	<div class="modal-content">
  	    		<form id="data_print_dtr" action="<?php echo base_url('print/print_dtr') ?>" method="get" target="_blank">
	  	    		<div class="modal-header">
	  	    	  	  	<h4 class="modal-title">Employee's DTR <b>( <span id="emp_cutoff"></span> )</b></h4>
	  	    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
	  	    	  	</div>
	  	    	  	<div class="modal-body view_dtr">
	  	    	  	  	
	  	    	  	</div>
	  	    	  	<div class="modal-footer">
	  	    	  		<span class="pull-left" style="font-size: 9px;">
                            <span style="margin-right:27px;"><label readonly=""><span style="color:black;">LEGEND :</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">A</span><span style="color:black;"> - Alturas Mall</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">B</span><span style="color:black;"> - Alturas Talibon</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">C</span><span style="color:black;"> - Alturas Tubigon</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">D</span><span style="color:black;"> - Island City Mall</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">E</span><span style="color:black;"> - Plaza Marcela Discounted Store</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">F</span><span style="color:black;"> - Colonnade Colon</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">G</span><span style="color:black;"> - Collonade Mandaue</span></label></span>
                            <span style="margin-right:27px;"><label readonly=""><span style="color:#F10A0A;">H</span><span style="color:black;"> - Alta Citta</span></label></span>
                        </span>
	  	    	  		<button type="submit" class="btn btn-primary" id="print_dtr">
							Print to PDF
						</button>
	  	    	  		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  	    	  	</div>
  	    	  	</form>
  	    	</div>
  	  	</div>
  	</div>

  	<div id="show-entry" class="modal fade">
        <div class="modal-dialog" style="width: 45%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Time Entry</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body show-entry">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->