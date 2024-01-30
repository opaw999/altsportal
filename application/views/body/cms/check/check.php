	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Concessionaires </b> [ Check Monitoring ]  </h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->

	<div id="product" class="section-container p-t-20">
		<div class="container">
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">  Supplier's Data </li>
			</ul>
			<div class="card">
			  	<div class="card-header"><i class="fa fa-list-ol"></i> Check Monitoring  </div>
			  	<div class="card-body bg-light">
			  	
			  		<p class="card-text">
						<div class="btn-group btn-group-md">
							<a href='javascript:void(0);' id='check_<?= $vcodes[0];?>' class='btn btn-danger vcodes'> <?= @$vcodes[0];?></a> 
							<a href='javascript:void(0);' id='check_<?= $vcodes[1];?>' class='btn btn-primary vcodes'> <?= @$vcodes[1];?> </a> 					
						</div>
					</p>
			  		<?php		
					$vcode = @$this->concession_model->getVendorCode("vendor_id = '".$_SESSION['supplier_id']."' ");	
					$check = @$this->concession_model->getalltblwhere("tbl_check_monitoring","vendor_code='$vcode'"); 
					?>
					<div class="table-responsive" id='div_check'>
			  		<table id='checkDTable' class="table table-striped table-bordered table-hover" width="100%">
			  			<thead>			                
			  				<tr>
								<th>CV No.</th>
								<th>Check No.</th>
								<th>Check Date</th>
								<th>Check Amount</th>
								<th>Bank</th>
								<th>Status</th>
								<th>Date Released</th>
							</tr> 
			  			</thead>
			  			<tbody>	
			  				<?php
							$status = "";
							foreach($check as $row):

								if($row['check_status'] == "CLAIMED"){
									$status = "<span class='badge label-table badge-success'> ".$row['check_status']."</span>";
								}else if($row['check_status'] == "UNCLAIMED"){
									$status = "<span class='badge label-table badge-danger'>".$row['check_status']."</span>";
								}

								$releasedate 	= @$this->concession_model->cDF("m/d/Y",$row['check_release_date']);								
								$checkdetails 	= @$this->concession_model->getfrmtblwhere("tbl_check_details","cv_no='$row[cv_no]'");				
								$checkno 		= $checkdetails->check_no;
								$checkdate 		= $this->concession_model->cDF("m/d/Y",$checkdetails->check_date);	
								$bankname 		= $checkdetails->bank_name;		
								
								echo "
								<tr>
									<td> $row[cv_no]  </td>	
									<td> $checkno </td>
									<td> $checkdate </td>
									<td align='right'> ".number_format($row['total_paid_amt'],2)." </td>
									<td> $bankname </td>
									<td> $status </td>
									<td> $releasedate </td>	
								</tr>";
							endforeach;
							?>			  				
			  			</tbody>
			  		</table>
			  	</div>
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