	<!-- BEGIN #page-header -->
	<div id="page-header" class="section-container page-header-container bg-black">
		<!-- BEGIN page-header-cover -->
		<div class="page-header-cover">
			<img src="<?php echo base_url('assets/img/cover/cover-15.jpg'); ?>" alt="" />
		</div>
		<!-- END page-header-cover -->
		<!-- BEGIN container -->
		<div class="container">
			<h1 class="page-header"><b>Concessionaires </b> [ Sales & Commission ] </h1>
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
			  	<div class="card-header"><i class="fa fa-list-ol"></i> Sales & Commission  </div>
			  	<div class="card-body bg-light">
			  	    <p class="card-text">
						<div class="btn-group btn-group-md">
							<a href='javascript:void(0);' id='sales_<?= $vcodes[0];?>' class='btn btn-danger vcodes'> <?= @$vcodes[0];?></a> 
							<a href='javascript:void(0);' id='sales_<?= $vcodes[1];?>' class='btn btn-primary vcodes'> <?= @$vcodes[1];?> </a> 					
						</div>
					</p>
			  	    <?php
			  	    $vcode = @$this->concession_model->getVendorCode("vendor_id = '".$_SESSION['supplier_id']."' ");	
		  	    	$sales  = @$this->concession_model->getalltblwhere("tbl_item_sales_summary","vendor_code='$vcode'"); 
			  	    ?>
			  	    <div class="table-responsive" id='div_sales'>
    			  		<table class="table table-striped table-bordered table-hover" id='salesDtable' width="100%" style='font-size:13px'>
    			  			<thead>			                
    			  				<tr>
    			  					<th width='5'> NO </th>
    								<th width='30'> CUTOFF </th>
    								<th width='5'> STORE </th>
    								<th width='5'> DEPT </th>			  					
    			  					<th width='30'> NET SALE W/ VAT </th>
    			  					<th width='20'> SALES COMMISSION </th>
    			  					<th width='20'> CONSIGNMENT PAYABLE </th>
    			  					<th width='20'> STATUS </th>
    								<th width='20'> DATE POSTED </th>
    			  					<th width='20'> ACTION </th>
    			  				</tr>
    			  			</thead>
    			  			<tbody>	
    							<?php $i=0; foreach($sales as $row): 	
    							
    							$i++;
    							if($row['status'] == 'UNPOSTED'){
    								$dateposted = "";
    								$label    = "<span class='badge badge-danger' id='status_$row[iss_no]'> $row[status] </span>";
    							}else{
    								$dateposted = $this->concession_model->cDF("m/d/y",$row['date_posted']);	
    								$label    = "<span class='badge badge-success' id='status_$row[iss_no]'> $row[status] </span>";
    							}
    
    							$net_sale 	= $row['net_sale'];
    							$salescomm 	= $row['sales_commission'];
    							$consignpayable = $row['consignment_payable'];						   
    
    							$p_start 	= $this->concession_model->cDF("m/d/y",$row['p_start']);
    							$p_end 		= $this->concession_model->cDF("m/d/y",$row['p_end']);
    
    							//company
    							$company 	= $this->concession_model->getOneField("shortcut","tbl_code_company","company_code ='$row[company_code]' ")->shortcut;
    						   
    							//department
    							$dshortcut  = $this->concession_model->getOneField("shortcut","tbl_code_department","dept_code ='$row[dept_code]' ")->shortcut; 
    							if($dshortcut == ""){					                    	
    								$dshortcut  = $this->concession_model->getOneField("dept_name","tbl_code_department","dept_code ='$row[dept_code]' ")->dept_name;
    							}
    							?>					
    			  				<tr>
    								<td> <?= $i;?></td>
    			  					<td> <?= $p_start;?> .. <?= $p_end;?> </td>
    			  					<td> <?= $company;?> </td>
    								<td> <?= $dshortcut;?> </td>
    			  					<td align='right'> <?php echo "P".number_format($net_sale,2);?> </td>
    								<td align='right'> <?php echo "P".number_format($salescomm,2);?> </td>
    								<td align='right'> <?php echo "P".number_format($consignpayable,2);?> </td>
    								<td> <?= $label;?> </td>
    								<td> <?= $dateposted;?> </td>	
    								<td> <a href='<?php echo base_url('vendor_sales_pdf/'.$row['iss_no']); ?>') target='_blank'> Export PDF </a> </td>
    			  				</tr>		  				
    			  				<?php endforeach; ?>
    			  			</tbody>
    			  		</table>
			  		</div>
			  	</div>
			</div>
		</div>
	</div>

  	<div id="show-sales" class="modal fade">
        <div class="modal-dialog modal-lg" style="width: 80%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Sales Report Details </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body show-sales" id='modal_sales_report_details'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
