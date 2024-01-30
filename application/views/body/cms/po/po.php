	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Concessionaires </b> [ Purchase Order ] </h1>
		</div>
		<!-- END container -->
	</div>
	<!-- BEGIN #page-header -->

	<div id="product" class="section-container p-t-20">
		<div class="container">
			<ul class="breadcrumb m-b-10 f-s-12">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active"> Concessionaires </li>
			</ul>
			<div class="card">
			  	<div class="card-header"><i class="fa fa-list-ol"></i> Purchase Order (P.O.) </div>
			  	<div class="card-body bg-light">
			  		
			  		<p class="card-text">
						<div class="btn-group btn-group-md">
							<a href='javascript:void(0);' id='ded_<?= $vcodes[0];?>' class='btn btn-danger vcodes'> <?= @$vcodes[0];?></a> 
							<a href='javascript:void(0);' id='ded_<?= $vcodes[1];?>' class='btn btn-primary vcodes'> <?= @$vcodes[1];?> </a> 					
						</div>
					</p>
			  		<?php		
					$vcode      = @$this->concession_model->getVendorCode("vendor_id = '".$_SESSION['supplier_id']."' ");					
					$po         = @$this->concession_model->getalltblwhere("tbl_po_requisition","vendor_code='$vcode'");
					$columns    = array("PO #","Vendor Code","Store","Department","Date Requested","Status","Print","Received","View");
					?>
					<div class="table-responsive" id='div_po'>
    			  		<table id="deDTable" class="table table-bordered table-sm dt-responsive nowrap" style='font-size:13px'>
    			  			<thead>	
    			  				<tr> <?php
    			  				    foreach($columns as $key => $value):
    			  				        echo "<th> $value </th>";
    			  				    endforeach; ?>
    			  				</tr>
    			  			</thead>
    			  			<tbody>	
    							<?php 
    							if(!empty($po)){
    							foreach($po as $row):
    							
    								$company = $this->concession_model->getOneField("name","tbl_code_company","company_code='$row[compcode]' ")->name;
    								$dept    = $this->concession_model->getOneField("dept_name","tbl_code_department","company_code='$row[compcode]' and dept_code='$row[deptcode]' ")->dept_name;
                                    
                                    $receivedstat = @$this->concession_model->getOneField("received_status","tbl_po_receiving","ref_no='$row[ref_no]' ")->received_status;
                                    if($receivedstat == 'RECEIVED'){	$rlabel = "<span class='badge badge-success'>$receivedstat</span>"; }else{	$rlabel = "";	}
    								if($row['status'] == 'POSTED'){	$label = "success"; }else{	$label = "warning";	} 
    									
    								$refno = trim($row['ref_no']);
    								if($receivedstat !=""){ $view="<a href='#show-receiveditems' data-toggle='modal' onclick=show_received('$refno')> View </a>";}else{ $view=""; }	
    								
    								echo "	
    								<tr>	
    									<td> ".$row['ref_no']." </td>
    									<td> ".$row['vendor_code']." </td>
    									<td> $company </td>
    									<td> $dept </td>
    									<td> ".$this->concession_model->cDF("m/d/Y",$row['date_requested'])." </td>
    									<td> <span class='badge badge-".$label."'> ".$row['status']."</span> </td>";?>
    									<td> <a href='<?php echo base_url('vendor_po_pdf/'.$row['ref_no']); ?>') target='_blank'> PDF </a> </td> <?php echo "
    									<td> $rlabel </td>
    									<td> $view </td>
    								</tr>";
    							endforeach;
    							}?>
    			  			</tbody>
    			  		</table>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>
	
	<div id="show-receiveditems" class="modal fade">
        <div class="modal-dialog modal-lg" style="width: 70%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Received Items </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body show-cas" id='receiveditems'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->