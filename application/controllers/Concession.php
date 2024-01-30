<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Concession extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('concession_model');
        $this->datetime = date("Y-m-d H:i:s");
        $this->date     = date("Y-m-d");
    }
	
	public function post_toportal()
	{
	    $tbl   = $this->input->post('tbl');
	    $data  = $this->input->post('tbl_data');
	    
	    $id1   = "";
	    
	   // print_r($data);
	   // die();
	    
	    if($tbl == "tbl_cas")
	    {
    	    foreach ($data as $key => $value)
    	    {
                $data  = array(
                    "vendor_code"                       => $this->security->xss_clean($value['vcode']),
                    "cas_no"                            => $this->security->xss_clean($value['cas_no']),
                    "dated"                             => $this->security->xss_clean($value['dated']),
                    "brand"                             => $this->security->xss_clean($value['brand']),
                    "period_start"                      => $this->security->xss_clean($value['p_start']),
                    "period_end"                        => $this->security->xss_clean($value['p_end']), 
                    "merchandise_category"              => $this->security->xss_clean($value['merch_cat']),
                    "area_covered"                      => $this->security->xss_clean($value['area_covered']),
                    "monthly_utilities"                 => $this->security->xss_clean($value['monthly_u']), 
                    "monthly_utilities_details"         => $this->security->xss_clean($value['monthly_ud']), 
                    "monthly_supply_charge"             => $this->security->xss_clean($value['monthly_sc']), 
                    "monthly_supply_charge_details"     => $this->security->xss_clean($value['monthly_scd']), 
                    "monthly_gross_sales"               => $this->security->xss_clean($value['monthly_gs']), 
                    "monthly_gross_sales_details"       => $this->security->xss_clean($value['monthly_gsd']), 
                    "commission_percentage"             => $this->security->xss_clean($value['comm_prct']), 
                    "salesforce_peak"                   => $this->security->xss_clean($value['salesforce_peak']), 
                    "salesforce_normal"                 => $this->security->xss_clean($value['salesforce_normal']), 
                    "check_issuance_date"               => $this->security->xss_clean($value['check_isdate']), 
                    "scanned_cas"                       => $this->security->xss_clean($value['scanned_cas']),
                    "date_uploaded"                     => $this->security->xss_clean($value['date_uploaded']),
                    "uploaded_by"                       => $this->security->xss_clean($value['uploaded_by']),
                    "date_created"                      => $this->security->xss_clean($value['date_created']),
                    "created_by"                        => $this->security->xss_clean($value['created_by']),
                    "cas_status"                        => $this->security->xss_clean($value['cas_status']),
                    "approved_by"                       => $this->security->xss_clean($value['approved_by'])
                );
                $result = $this->concession_model->insert_table($data,$tbl);
    	    }
	    }
	    else if($tbl == "tbl_vis")
	    {
	        foreach ($data as $key => $value)
    	    {
                $data = array(
                    "vis_id"                => $this->security->xss_clean($value['vis_id']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "structure"             => $this->security->xss_clean($value['structure']),
                    "sole_name"             => $this->security->xss_clean($value['sole_name']),
                    "sole_address"          => $this->security->xss_clean($value['sole_address']),
                    "sole_tin"              => $this->security->xss_clean($value['sole_tin']),
                    "business_name"         => $this->security->xss_clean($value['business_name']),
                    "business_address"      => $this->security->xss_clean($value['business_address']),
                    "business_ownership"    => $this->security->xss_clean($value['business_ownership']),
                    "date_established"      => $this->security->xss_clean($value['date_established']),
                    "years_operation"       => $this->security->xss_clean($value['years_operation']),
                    "nature_of_business"    => $this->security->xss_clean($value['nature_of_business']),
                    "tin"                   => $this->security->xss_clean($value['tin']),
                    "dti_regno"             => $this->security->xss_clean($value['dti_regno']),
                    "vat_regno"             => $this->security->xss_clean($value['vat_regno']),
                    "mun_licenseno"         => $this->security->xss_clean($value['mun_licenseno']),
                    "sec_regno"             => $this->security->xss_clean($value['sec_regno']),
                    "tel_no"                => $this->security->xss_clean($value['tel_no']),
                    "mobile_no"             => $this->security->xss_clean($value['mobile_no']),
                    "fax_no"                => $this->security->xss_clean($value['fax_no']),
                    "email_add"             => $this->security->xss_clean($value['email_add']),
                    "product_line"          => $this->security->xss_clean($value['product_line']),
                    "regular_disc"          => $this->security->xss_clean($value['regular_disc']),
                    "volume_disc"           => $this->security->xss_clean($value['volume_disc']),
                    "prompt_disc"           => $this->security->xss_clean($value['prompt_disc']),
                    "intro_disc"            => $this->security->xss_clean($value['intro_disc']),
                    "shelf_life"            => $this->security->xss_clean($value['shelf_life']),
                    "trading_terms"         => $this->security->xss_clean($value['trading_terms']),
                    "consignment_type"      => $this->security->xss_clean($value['consignment_type']),
                    "po_transmittal"        => $this->security->xss_clean($value['po_transmittal']),
                    "shipment_details"      => $this->security->xss_clean($value['shipment_details']),
                    "freight_subsidy"       => $this->security->xss_clean($value['freight_subsidy']),
                    "date_added"            => $this->security->xss_clean($value['date_added']),
                    "added_by"              => $this->security->xss_clean($value['added_by']),
                    "vis_status"            => $this->security->xss_clean($value['vis_status']),
                    "date_approved"         => $this->security->xss_clean($value['date_approved']),
                    "approved_by"           => $this->security->xss_clean($value['approved_by'])         
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
    	    }
	    }
	    else if($tbl == "tbl_vendor")
	    {
	        foreach($data as $key => $value):   
                $data = array(
                    "vendor_id"                 => $this->security->xss_clean($value['vendor_id']),
                    "vendor_code"               => $this->security->xss_clean($value['vendor_code']),
                    "vendor_name"               => $this->security->xss_clean($value['vendor_name']),
                    "grp"                       => $this->security->xss_clean($value['grp']),
                    "status"                    => $this->security->xss_clean($value['status']),
                    "bu_id"                     => $this->security->xss_clean($value['bu_id']),
                    "vendor_posting_group"      => $this->security->xss_clean($value['vendor_posting_group']),
                    "address"                   => $this->security->xss_clean($value['address']),
                    "address2"                  => $this->security->xss_clean($value['address2']),
                    "city"                      => $this->security->xss_clean($value['city']),
                    "contact"                   => $this->security->xss_clean($value['contact']),
                    "currency_code"             => $this->security->xss_clean($value['currency_code']),
                    "gen_bus_posting_group"     => $this->security->xss_clean($value['gen_bus_posting_group']),
                    "VAT_bus_posting_group"     => $this->security->xss_clean($value['VAT_bus_posting_group']),
                    "WHT_bus_posting_group"     => $this->security->xss_clean($value['WHT_bus_posting_group']),
                    "vat_reg"                   => $this->security->xss_clean($value['vat_reg']),
                    "date_created"              => $this->security->xss_clean($value['date_created']),
                    "added_by"                  => $this->security->xss_clean($value['added_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
	    }
	    else if($tbl == "tbl_deductions")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "ded_no"                => $this->security->xss_clean($value['ded_no']),
                    "doc_no"                => $this->security->xss_clean($value['doc_no']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "grp"                   => $this->security->xss_clean($value['grp']),
                    "deduction_type"        => $this->security->xss_clean($value['deduction_type']),
                    "d_vendor"              => $this->security->xss_clean($value['d_vendor']),
                    "deduction_details"     => $this->security->xss_clean($value['deduction_details']),
                    "amount"                => $this->security->xss_clean($value['amount']),
                    "posting_date"          => $this->security->xss_clean($value['posting_date']),
                    "comp_code"             => $this->security->xss_clean($value['comp_code']),
                    "dept_code"             => $this->security->xss_clean($value['dept_code']),
                    "status"                => $this->security->xss_clean($value['status']),
                    "void_remarks"          => $this->security->xss_clean($value['void_remarks']),
                    "void_by"               => $this->security->xss_clean($value['void_by']),
                    "date_voided"           => $this->security->xss_clean($value['date_voided']),
                    "date_added"            => $this->security->xss_clean($value['date_added']),
                    "added_by"              => $this->security->xss_clean($value['added_by']),
                    "audit_status"          => $this->security->xss_clean($value['audit_status']),
                    "audited_by"            => $this->security->xss_clean($value['audited_by']),
                    "audited_date"          => $this->security->xss_clean($value['audited_date'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_items")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "item_no"               => $this->security->xss_clean($value['item_no']),
                    "item_code"             => $this->security->xss_clean($value['item_code']),
                    "ext_desc"              => $this->security->xss_clean($value['ext_desc']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "comm_rate"             => $this->security->xss_clean($value['comm_rate']),
                    "item_division"         => $this->security->xss_clean($value['item_division']),
                    "item_dept_code"        => $this->security->xss_clean($value['item_dept_code']),
                    "item_group_code"       => $this->security->xss_clean($value['item_group_code']),
                    "inventory_posting_group"   => $this->security->xss_clean($value['inventory_posting_group']),
                    "date_uploaded"         => $this->security->xss_clean($value['date_uploaded']),
                    "uploaded_by"           => $this->security->xss_clean($value['uploaded_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_check_details")
        {
            foreach($data as $key => $value):   
        
                $data = array(
                    "check_id"              => $this->security->xss_clean($value['check_id']),
                    "check_no"              => $this->security->xss_clean($value['check_no']),
                    "cv_no"                 => $this->security->xss_clean($value['cv_no']),
                    "check_date"            => $this->security->xss_clean($value['check_date']),
                    "bank_acct"             => $this->security->xss_clean($value['bank_acct']),
                    "bank_name"             => $this->security->xss_clean($value['bank_name']),
                    "clearing_date"         => $this->security->xss_clean($value['clearing_date']),
                    "uploaded_by"           => $this->security->xss_clean($value['uploaded_by']),
                    "date_uploaded"         => $this->security->xss_clean($value['date_uploaded'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_check_voucher_line")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "checkv_id"             => $this->security->xss_clean($value['checkv_id']),
                    "cv_no"                 => $this->security->xss_clean($value['cv_no']),
                    "line_no"               => $this->security->xss_clean($value['line_no']),
                    "crf_no"                => $this->security->xss_clean($value['crf_no']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "doc_no"                => $this->security->xss_clean($value['doc_no']),
                    "gl_entry"              => $this->security->xss_clean($value['gl_entry']),
                    "forwarded_amt"         => $this->security->xss_clean($value['forwarded_amt']),
                    "paid_amt"              => $this->security->xss_clean($value['paid_amt']),
                    "balance"               => $this->security->xss_clean($value['balance']),
                    "cv_status"             => $this->security->xss_clean($value['cv_status']),
                    "doc_type"              => $this->security->xss_clean($value['doc_type']),
                    "applies_doc_no"        => $this->security->xss_clean($value['applies_doc_no']),
                    "invoice_no"            => $this->security->xss_clean($value['invoice_no']),
                    "account_name"          => $this->security->xss_clean($value['account_name']),
                    "com_dimension_code"    => $this->security->xss_clean($value['com_dimension_code']),
                    "dept_dimension_code"   => $this->security->xss_clean($value['dept_dimension_code']),
                    "payment_type"          => $this->security->xss_clean($value['payment_type']),
                    "date_uploaded"         => $this->security->xss_clean($value['date_uploaded']),
                    "uploaded_by"           => $this->security->xss_clean($value['uploaded_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_check_monitoring")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "cv_id"                 => $this->security->xss_clean($value['cv_id']),
                    "cv_no"                 => $this->security->xss_clean($value['cv_no']),
                    "cv_date"               => $this->security->xss_clean($value['cv_date']),                                        
                    "cv_status"             => $this->security->xss_clean($value['cv_status']),
                    "collector_name"        => $this->security->xss_clean($value['collector_name']),
                    "total_crf_amt"         => $this->security->xss_clean($value['total_crf_amt']),
                    "total_paid_amt"        => $this->security->xss_clean($value['total_paid_amt']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "batch_name"            => $this->security->xss_clean($value['batch_name']),
                    "bal_acct_type"         => $this->security->xss_clean($value['bal_acct_type']),
                    "bal_acct_no"           => $this->security->xss_clean($value['bal_acct_no']),
                    "gl_doc_no"             => $this->security->xss_clean($value['gl_doc_no']),    
                    "remarks"               => $this->security->xss_clean($value['remarks']),
                    "no_series"             => $this->security->xss_clean($value['no_series']),
                    "vendor_name"           => $this->security->xss_clean($value['vendor_name']),
                    "cv_type"               => $this->security->xss_clean($value['cv_type']),
                    "no_printed"            => $this->security->xss_clean($value['no_printed']),
                    "cancelled_by"          => $this->security->xss_clean($value['cancelled_by']),
                    "cancelled_date"        => $this->security->xss_clean($value['cancelled_date']),
                    "checked_by"            => $this->security->xss_clean($value['checked_by']),
                    "approved_by"           => $this->security->xss_clean($value['approved_by']),
                    "check_status"          => $this->security->xss_clean($value['check_status']),
                    "check_release_date"    => $this->security->xss_clean($value['check_release_date']),
                    "claimed_by"            => $this->security->xss_clean($value['claimed_by']),
                    "relation_to"           => $this->security->xss_clean($value['relation_to']),
                    "signature"             => $this->security->xss_clean($value['signature']),
                    "date_added"            => $this->security->xss_clean($value['date_added']),
                    "released_by"           => $this->security->xss_clean($value['released_by']),
                    "added_by"              => $this->security->xss_clean($value['added_by']),
                    "audit_status"          => $this->security->xss_clean($value['audit_status']),
                    "audited_by"            => $this->security->xss_clean($value['audited_by']),
                    "audited_date"          => $this->security->xss_clean($value['audited_date'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_item_sales_summary")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "iss_no"                => $this->security->xss_clean($value['iss_no']),
                    "suf_id"                => $this->security->xss_clean($value['suf_id']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "grp"                   => $this->security->xss_clean($value['grp']),                    
                    "commission_percentage" => $this->security->xss_clean($value['commission_percentage']),
                    "net_sale"              => $this->security->xss_clean($value['net_sale']),
                    "vat_input"             => $this->security->xss_clean($value['vat_input']),
                    "sales_commission"      => $this->security->xss_clean($value['sales_commission']),                    
                    "consignment_payable"   => $this->security->xss_clean($value['consignment_payable']),
                    "status"                => $this->security->xss_clean($value['status']),
                    "audit_status"          => $this->security->xss_clean($value['audit_status']),
                    "audited_by"            => $this->security->xss_clean($value['audited_by']),
                    "date_audited"          => $this->security->xss_clean($value['date_audited']),
                    "date_posted"           => $this->security->xss_clean($value['date_posted']),
                    "posted_by"             => $this->security->xss_clean($value['posted_by']),
                    "p_start"               => $this->security->xss_clean($value['p_start']),
                    "p_end"                 => $this->security->xss_clean($value['p_end']),
                    "store_id"              => $this->security->xss_clean($value['store_id']),
                    "company_code"          => $this->security->xss_clean($value['company_code']),
                    "dept_code"             => $this->security->xss_clean($value['dept_code']),
                    "date_generated"        => $this->security->xss_clean($value['date_generated']),
                    "generated_by"          => $this->security->xss_clean($value['generated_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_item_sales_uploaded_file")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "suf_id"                => $this->security->xss_clean($value['suf_id']),
                    "terms"                 => $this->security->xss_clean($value['terms']),
                    "cutoff_start"          => $this->security->xss_clean($value['cutoff_start']),
                    "cutoff_end"            => $this->security->xss_clean($value['cutoff_end']),
                    "store_id"              => $this->security->xss_clean($value['store_id']),
                    "bu_id"                 => $this->security->xss_clean($value['bu_id']),
                    "file_name"             => $this->security->xss_clean($value['file_name']),
                    "date_uploaded"         => $this->security->xss_clean($value['date_uploaded']),
                    "uploaded_by"           => $this->security->xss_clean($value['uploaded_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
        else if($tbl == "tbl_item_sales")
        {
            foreach($data as $key => $value):   
                $data = array(
                    "isr_no"                => $this->security->xss_clean($value['isr_no']),
                    "suf_id"                => $this->security->xss_clean($value['suf_id']),                    
                    "store_id"              => $this->security->xss_clean($value['store_id']),
                    "company_code"          => $this->security->xss_clean($value['company_code']),
                    "dept_code"             => $this->security->xss_clean($value['dept_code']),
                    "vendor_code"           => $this->security->xss_clean($value['vendor_code']),
                    "period_start"          => $this->security->xss_clean($value['period_start']),
                    "period_end"            => $this->security->xss_clean($value['period_end']),
                    "commission_percentage" => $this->security->xss_clean($value['commission_percentage']),
                    "item_code"             => $this->security->xss_clean($value['item_code']),
                    "item_desc"             => $this->security->xss_clean($value['item_desc']),
                    "qty"                   => $this->security->xss_clean($value['qty']),
                    "net_sale_with_vat"     => $this->security->xss_clean($value['net_sale_with_vat']),
                    "total_disc"            => $this->security->xss_clean($value['total_disc']),
                    "status"                => $this->security->xss_clean($value['status']),
                    "date_added"            => $this->security->xss_clean($value['date_added']),
                    "added_by"              => $this->security->xss_clean($value['added_by'])
                ); 
                $result = $this->concession_model->insert_table($data,$tbl);
            endforeach;
        }
                    
	   
        if($result){
            echo TRUE;
        }
	}
	
	
	public function receive_po()
	{
	    $flag   = 1;
	    $refno  = "";
	    $qty    = 0;
	    $data   = $this->input->post('porequest');
	    foreach ($data as $key => $value){
	        $data  = array(		
	            'ref_no'			=> $this->security->xss_clean($value['refno']),
                'vendor_code'		=> $this->security->xss_clean($value['vcode']),
                'compcode'			=> $this->security->xss_clean($value['compcode']),
                'deptcode'			=> $this->security->xss_clean($value['deptcode']),	
                'grp'			    => $this->security->xss_clean($value['grp']),	
                'date_requested'	=> $this->security->xss_clean($this->datetime),	
                'requested_by'		=> $this->security->xss_clean($value['reqby']),
                'status'		    => $this->security->xss_clean('POSTED')
            );
            $result_refno = $this->concession_model->getOneField("ref_no","tbl_po_requisition","ref_no = '".$value['refno']."'")->ref_no;
            if($result_refno){ //check if naa nay na save na refno if naa dli dapat mo insert
                $flag = 0;
            }else{
                echo "PO Request already exist!";
            }
            
            //for email
            $refno = $value['refno'];
            $vcode = $value['vcode'];
	    }
	    
	    if($flag == 1)
	    {
	        
    	    $result = $this->concession_model->insert_table($data,"tbl_po_requisition");
    	    if($result)
    	    {
    	         $datas = $this->input->post('porequestdetails');
    	         foreach ($datas as $key => $value){
        	        $data  = array(		
        	            'ref_no'			=> $this->security->xss_clean($value['refno']),
                        'item_code'		    => $this->security->xss_clean($value['itemcode']),
                        'item_desc'			=> $this->security->xss_clean($value['itemdesc']),
                        'qty'			    => $this->security->xss_clean($value['qty']),	
                        'vendor_code'	    => $this->security->xss_clean($value['vcode']),	
                        'date_requested'	=> $this->security->xss_clean($this->datetime)
                    );
                    $result = $this->concession_model->insert_table($data,"tbl_po_requisition_details");
                    $qty += $value['qty'];
    	        }
    	        if($result){
    	           
    	            $vname = $this->concession_model->getVendorName($vcode);
                    $msg   = "Hi $vname,\n\nGood Day! \n\nPlease be informed that a PO# $refno dated ". $this->concession_model->cDF("F d, Y",$this->date)." with quantity $qty has been sent to your Altsportal account. Thanks! \n\n\n- ASC Buyer";  
                   // $email = "mirianncaliao@gmail.com";
                    
                    $vendordet = $this->concession_model->getfrmtblwhere("tbl_vis","vendor_code = '$vcode'");
                    $email = $vendordet->email_add;
                    if($email == ""){
                        $email = "mirianncaliao@gmail.com";
                    }else{
                        $email = $vendordet->email_add;
                    }   
                    
                    $array_email = array("itsysdev@alturasbohol.com",$email);
                    foreach($array_email as $key => $value){
                        $this->sendMail("CMS - Purchase Order", $msg, $value, "cms@altsportal.com");
                    }
    	            
    	            echo TRUE;
    	        }
    	    }
	    }
	}
	
    public function sendMail($subject, $message, $email, $source)
    {
        $this->load->library('email');
        $this->email->from($source);
        $this->email->to($email);
        $this->email->set_header('From', 'cms@altsportal.com');
        $this->email->subject($subject);
        $this->email->message($message);
        
        if($this->email->send()) 
        {
            return 'Sent'; 
        } 
        else 
        {   
            return 'Error'; 
        }
    }
	
	public function view_items_sales() //per vendor
    {  
        $vendorcode = $_POST['vcode'];
        $compcode   = $_POST['compcode'];
        $datefrom   = $_POST['date1']; 
        $dateto     = $_POST['date2'];
        
        $vendorname = $this->concession_model->getVendorName($vendorcode);
        $division   = $this->concession_model->get_sales_division($vendorcode,$datefrom,$dateto);

        $date1      = $this->concession_model->cDF("m/d/Y",$datefrom);
        $date2      = $this->concession_model->cDF("m/d/Y",$dateto);
    
        if($division)
        {
            echo "
                <b> Item Vendor Filter: </b>".strtoupper($vendorcode)." $vendorname <br>
                <b> Date Filter: </b> ".$date1." .. ". $date2."
                <br> <br>

                <table id='reportDatatable' class='table table-bordered table-sm dt-responsive nowrap' style='font-size:13px'>
                    <thead>
                        <tr align='center'>
                            <th  width='2%'> No. </th>
                            <th  width='5%'> Item Code </th>
                            <th  width='30%'> Description </th>
                            <th> Qty </th>
                            <th> Net Sale w/ VAT </th>
                            <th> Commission Rate </th>
                            <th> Sales Commission </th>
                            <th> Consignment Payable </th>
                        </tr>
                    </thead>
                    <tbody>";
                    $ctr = 0;
                    $gt_qty = 0;
                    $gt_netsales = 0;                   
                    $gt_salescommission      = 0;
                    $gt_consignmentpayable   = 0;

                    foreach($division as $rows):
                        
                        //$itemsales  = $this->concession_model->get_item_sales_report($vendorcode,$datefrom,$dateto,$rows['item_division'],$compcode);
                        $itemsales  = $this->report_model->get_item_sales_report($rows['item_division'],$sufid,$vendorcode);
                        $itemdivname= $this->concession_model->getDivision($rows['item_division']);

                        //totals
                        $total_qty  = 0;
                        $total_netsales = 0;                       
                        $total_salescommission      = 0;
                        $total_consignmentpayable   = 0;


                        foreach($itemsales as $row):

                            $ctr++;

                            $tbl_isr    = "tbl_item_sales_report";
                         
                            $itemcode   = $row['item_code'];   
                            $itemdesc   = $row['item_desc'];
                            $qty        = $row['qty'];
                            $netsales   = $row['net_sale_with_vat'];

                            $comm_rate  = $this->concession_model->getOneField("comm_rate","tbl_items"," item_code = '$itemcode' ")->comm_rate;    

                           
                            $commission             = $comm_rate / 100;                           
                            $salescommission        = $netsales * $commission;
                            $consignmentpayable     = $netsales - $salescommission;
                            
                            //count total per division
                            $total_qty += $qty;
                            $total_netsales += $netsales;                          
                            $total_salescommission += $salescommission;
                            $total_consignmentpayable += $consignmentpayable;

                            if($comm_rate == ""){ $bg="style='background-color:#ff9999;color:white'";} else { $bg=""; }

                            //                   $qty                  $ext_desc        $netsales
                            // is.vendor_code, is.qty, is.item_code, is.item_desc, is.net_sale_with_vat, is.total_disc
                            echo "
                                <tr $bg>
                                    <td> $ctr </td>
                                    <td> $itemcode </td>
                                    <td> $itemdesc </td>
                                    <td align='right'> ".number_format($qty,0)."</td>
                                    <td align='right'> ".number_format($netsales,2)."</td>
                                    <td align='right'> $comm_rate </td>
                                    <td align='right'>".number_format($salescommission,2)." </td>
                                    <td align='right'> ".number_format($consignmentpayable,2)." </td>
                                </tr>";
                        endforeach;

                        echo "
                                <tr style='color:green; font-weight:bold'>
                                    <td colspan='3'> Total for Item Division ".$rows['item_division']." - $itemdivname  </td>
                                    <td  align='right'> $total_qty </td>
                                    <td  align='right'> ".number_format($total_netsales,2)."</td>
                                    <td  align='right'>  </td>
                                    <td  align='right'>".number_format($total_salescommission,2)." </td>
                                    <td  align='right'>".number_format($total_consignmentpayable,2)."  </td>
                                </tr>";

                        $gt_qty += $total_qty; 
                        $gt_netsales += $total_netsales;                       
                        $gt_salescommission      += $total_salescommission;
                        $gt_consignmentpayable   += $total_consignmentpayable;    
                        $concession_sales = $gt_netsales;

                    endforeach;

                        echo "
                        <tr>
                            <td colspan='9'> &nbsp; </td>
                        </tr>
                        <tfooter>
                        <tr align='center'>
                            <th>  </th>
                            <th> Item Code </th>
                            <th> Description </th>
                            <th> Qty </th>
                            <th> Net Sale w/ VAT </th>
                            <th> Commission Rate </th>                           
                            <th> Sales Commission </th>
                            <th> Consignment Payable </th>
                        </tr>
                        </tfooter>
                        <tr style='color:red; font-weight:bold'>
                            <td colspan='3'> Total for Vendor No. $vendorcode $vendorname  </td>
                            <td  align='right'> $gt_qty </td>
                            <td  align='right'><input type='hidden' name='netsales' value='$gt_netsales'>".number_format($gt_netsales,2)." </td>
                            <td>  </td>
                            <td align='right'> <input type='hidden' name='salescommission' value='$gt_salescommission'> ".number_format($gt_salescommission,2)."  </td>
                            <td align='right'> <input type='hidden' name='consignmentpayable' value='$gt_consignmentpayable'> ".number_format($gt_consignmentpayable,2)."  </td>
                        </tr>
                    </tbody> 
                </table>   

                <input type='hidden' name='compcode' value='$compcode'>
                <input type='hidden' name='datefrom' value='$datefrom'>
                <input type='hidden' name='dateto' value='$dateto'> ";

               /* if($this->report_model->check_if_sales_has_PI($vendorcode,$store,$datefrom,$dateto)==0){
                    echo "
                    <button class='btn btn-success' onclick=reviewed('$vendorcode')> Reviewed </button>";
                }else{
                    echo "<b style='color:red'> Note: This Report has already been reviewed and processed for PI. </b>";
                }   */             
        } else {
            echo "<div class='alert alert-danger fade show'> No Result Found! </div>";
        }  
    } 
	
	public function view_items_masterfile()
	{
		$vcode = "S4607";
		$items = $this->concession_model->getalltblwhere("tbl_items","vendor_code='$vcode'");
		?>
		<table id="concessionaireDatatable" class="table table-bordered table-sm dt-responsive nowrap" style='font-size:13px'>
			<thead>
				<tr>
					<th class="text-nowrap"> Code </th>
					<th class="text-nowrap"> Description </th>
					<th class="text-nowrap"> Comm Rate </th>
					<th class="text-nowrap"> Division </th>
					<th class="text-nowrap"> Dept Code </th>
					<th class="text-nowrap"> Group Code</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($items as $row)
			{														
				echo "
				<tr>
					<td> $row[item_code] </td>
					<td> $row[ext_desc] </td>
					<td> $row[comm_rate]% </td>
					<td> $row[item_division] </td>
					<td> $row[item_dept_code] </td>
					<td> $row[item_group_code] </td>
				</tr>";
			} ?>
			</tbody>
		</table><?php
	}	
	
	public function show_cas(){
	    
		$casid 	 = $_POST['casid'];
		$cas_det = $this->concession_model->getfrmtblwhere('tbl_cas',"cas_id = '$casid'");
		//<a href='#show-cas' data-toggle='modal'> <button class="btn btn-primary btn-sm" > CAS </button> </a>					
		
		if($cas_det->dated=="" || $cas_det->dated=="0000-00-00"){ $dated = ""; }else{ $dated=$this->concession_model->cDF("F d, Y",$cas_det->dated); }
		if($cas_det->period_start=="" || $cas_det->period_start=="0000-00-00"){ $pstart=""; }else{ $pstart=$this->concession_model->cDF("m/d/Y",$cas_det->period_start); }
		if($cas_det->period_end=="" || $cas_det->period_end=="0000-00-00"){ $pend = ""; }else{ $pend=$this->concession_model->cDF("m/d/Y",$cas_det->period_end); }
		
		$location 	= $this->concession_model->getstores_concat($cas_det->vendor_code);
		$terms 		= $this->concession_model->getstore_terms($cas_det->vendor_code);
		$newterms 	= "";
		foreach($terms as $row){
			$newterms .= $row['aname']."-".$row['terms'].", ";
		}
	
		?>
		<center> (Per Concessionaire Agreement No.<?= $cas_det->cas_id;?> )  <br>
		<?= $dated;?>
		</center>
		<table class="table-bordered" cellpadding="10">
			<tr>
				<td align="right"> <b> Brand </b> </td>
				<td> <?= $cas_det->brand;?>  </td>
			</tr>
			<tr>
				<td align="right"> <b>Concessionaire </b></td>
				<td> <?= $cas_det->brand;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Period Covered</b> </td>
				<td> <?=  $pstart." .. ".$pend;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Merchandise Category</b> </td>
				<td> <?= $cas_det->merchandise_category;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Location</b> </td>
				<td> <?= @$location;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Area Covered</b> </td>
				<td> <?= $cas_det->area_covered;?>  </td>
			</tr>
			<tr>
				<td align="right"> <b>Freight Charges </b></td>
				<td> 100% chargeable to Concessionaire including stocks/merchandise returned or pulled - out from the store </td>
			</tr>
			<tr>
				<td align="right"> <b>Monthly Utilities/Rental Expense Charge</b> </td>
				<td> <?= $cas_det->monthly_utilities;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Monthly Store Supply Charge </b></td>
				<td> <?= $cas_det->monthly_supply_charge;?> </td>
			</tr>
			<tr>
				<td align="right" > <b>Minimum Monthly Gross Sales Requirement </b></td>
				<td> N/A </td>
			</tr>
			<!--<tr>
				<td align="right" > <b>Minimum Half Month Sales Requirement (per category) </b></td>
				<td> 
					Fresh Seafood 	:	P 1,600,000.00 <br>
					Frozen Seafoods : 	P 150,000.00 <br>
					Fruits & Veggies:   P 250,000.00
				</td>
			</tr>
			<tr>
				<td align="right" > <b>Minimum Daily Sales Requirements (per category/per cutoff) </b></td>
				<td> 
					Fresh Seafood 	:	P 106,666.67 <br>
					Frozen Seafoods : 	P 10,000.00 <br>
					Fruits & Veggies:   P 16,666.67
				</td>
			</tr>-->
			<tr>
				<td align="right"> <b>Commission Percentage </b></td>
				<td> <?= $cas_det->monthly_supply_charge;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Additional Sales Force  </b></td>
				<td> <?= $cas_det->salesforce_peak;?> </td>
			</tr>
			<tr>
				<td align="right"> <b>Sales Force on Normal Operations </b></td>
				<td> <?= $cas_det->salesforce_normal;?> </td>
			</tr>
			<tr>
				<td align="right"><b> Sales Cut-off Period</b> </td>
				<td> <?= substr_replace($newterms," ", -1);?> </td>
			</tr>
			<tr>
				<td align="right"><b> Check Issuance </b></td>
				<td> every 20<sup>th</sup> and 5<sup>th</sup> day of the month </td>
			</tr>
		</table> 
		<?php
	}
	
	public function vendor_sales_pdf($issno)
	{			
		$sales 				= $this->concession_model->getfrmtblwhere("tbl_item_sales_summary","iss_no = '$issno' ");
		
		$data['issno']      = $issno;	
		$data['sufid']      = $sales->suf_id;	
		$data['vendorcode'] = $sales->vendor_code;	
		$data['compcode'] 	= $sales->company_code;
		$data['datefrom'] 	= $sales->p_start;
		$data['dateto'] 	= $sales->p_end;		
		
		$data['vendorname']	= $this->concession_model->getVendorName($sales->vendor_code);
		
		$deptcode           = $this->concession_model->getOneField("dept_code","tbl_item_sales_summary","iss_no = '$issno' ")->dept_code;
        if($deptcode =="01.03.1.04" || $deptcode =="01.01.1.04" || $deptcode =="06.03" || $deptcode =="01.01.1.09" || $deptcode =="01.04.1.04" || $deptcode == "01.02.1.04"){
        	$where 		        = "vendor_code = '".$sales->vendor_code."' and item_division like 'X%' and item_dept_code like 'Y%'";
        	$data['division']   = $this->concession_model->get_sales_division($where,$sales->p_start,$sales->p_end);
        }else{
        	$where 		        = "vendor_code = '".$sales->vendor_code."' and item_division not like 'X%' and item_dept_code not like 'Y%' ";
       	 	$data['division']   = $this->concession_model->get_sales_division($where,$sales->p_start,$sales->p_end);
        }
		//$data['division']   = $this->concession_model->get_sales_division($sales->vendor_code,$sales->p_start,$sales->p_end);
		  
		$data['company']    = $this->concession_model->getOneField("name","tbl_code_company","company_code ='".$sales->company_code."' ")->name;
		$data['dept']       = $this->concession_model->getOneField("dept_name","tbl_code_department","dept_code ='".$sales->dept_code."' ")->dept_name;
						
		$this->load->view("body/cms/sales/sales_pdf", $data);
	}	
	
	
	public function view_vis()
	{
	    $vcode   = $_POST['vcode'];
	    $vis_tbl = $this->concession_model->getfrmtblwhere('tbl_vis', "vendor_code='$vcode'");
	    ?>
	    <table class="table">
			<tbody>
				<tr class="highlight">
					<td colspan="3"><h4><i class="fab fa-gitlab fa-fw text-primary"></i> Company Profile [<?= $vcode;?>]  </h4> </td>
				</tr>
				<tr>
					<td width="3%"> &nbsp; </td>
					<th width="20%"> <div style="text-align: right"> Structure </div>  </th>
					<td> <?= @$vis_tbl->structure;?> </td>
				</tr>									
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Business Name </div>  </th>
					<td> <?= @$vis_tbl->business_name;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Business Address </div>  </th>
					<td> <?= @$vis_tbl->business_address;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Business Ownership </div>  </th>
					<td> <?= @$vis_tbl->business_ownership;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Date Established </div>  </th>
					<td> <?= @$vis_tbl->date_established;?> </td>
				</tr>
				
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Years in Operation </div>  </th>
					<td> <?= @$vis_tbl->years_operation;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Nature of Business </div>  </th>
					<td> <?= @$vis_tbl->nature_of_business;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> TIN No.</th>
					<td> <?= @$vis_tbl->tin;?> </td>
				</tr>
				<tr class="highlight">
					<td colspan="3">
						<h4><i class="fab fa-gitlab fa-fw text-primary"></i> Contact Details & Business Registration Numbers </h4> 
					</td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Telephone Number </div> </th>
					<td> <?= @$vis_tbl->tel_no;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right">  Mobile Number </div> </th>
					<td> <?= @$vis_tbl->mobile_no;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Fax Number </div> </th>
					<td> <?= @$vis_tbl->fax_no;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Email Address </div> </th>
					<td>  <?= @$vis_tbl->email_add;?></td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> DTI Registration No. </div> </th>
					<td>  <?= @$vis_tbl->dti_regno;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right">  VAT Registration No. </div> </th>
					<td>  <?= @$vis_tbl->vat_regno;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Municipal License No.</div> </th>
					<td>  <?= @$vis_tbl->mun_licenseno;?>  </td>
				</tr>
				<tr class="highlight">
					<td colspan="3"> <h4><i class="fab fa-gitlab fa-fw text-primary"></i> Product Details </h4> </td>
				</tr>								
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Product Line </div> </th>
					<td> <?= @$vis_tbl->product_line;?> </td>
				</tr>		
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Discounts  </div> </th>
					<td> <?= @$vis_tbl->regular_disc;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Trading Terms  </div> </th>
					<td> <?= @$vis_tbl->trading_terms;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> PO Transmittal  </div>  </th>
					<td> <?= @$vis_tbl->po_transmittal;?>  </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Shipment Details  </div>  </th>
					<td> <?= @$vis_tbl->shipment_details;?> </td>   
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Freight Subsidy  </div> </th>
					<td> <?= @$vis_tbl->freight_subsidy;?> </td>
				</tr>										
		    	<tr class="highlight">
					<td colspan="3">  <h4><i class="fab fa-gitlab fa-fw text-primary"></i> For Single Proprietorship </h4>   </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Name </div> </th>
					<td> <?= @$vis_tbl->sole_name;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> Address </div> </th>
					<td> <?= @$vis_tbl->sole_address;?> </td>
				</tr>
				<tr>
					<td> &nbsp; </td>
					<th> <div style="text-align: right"> TIN No. </div> </th>
					<td> <?= @$vis_tbl->sole_tin;?> </td>
				</tr>				
			</tbody>
		</table>
	    <?php
	}
	
	public function view_cas()
	{   
	    $vcode   = $_POST['vcode'];
	    $cas_tbl = $this->concession_model->getalltblwhere('tbl_cas', "vendor_code='$vcode'");
	    ?>
	    <table class="table table-striped table-bordered table-hover" width="100%">
  			<thead>			                
  				<tr>
  					<th> CAS No. </th>
  					<th><i class="fa fa-fw fa-calendar hidden-md hidden-sm hidden-xs"></i> Date </th>
  					<th> Brand </th>
  					<th> Merchandise </th>
					<th> Commission Rate </th>
  					<th><i class="fa fa-fw fa-calendar hidden-md hidden-sm hidden-xs"></i> Period Start </th>
  					<th><i class="fa fa-fw fa-calendar hidden-md hidden-sm hidden-xs"></i> Period End </th>
  					<th> Action</th>
  				</tr>
  			</thead>
  			<tbody>	
				<?php foreach($cas_tbl as $row): ?>
  				<tr>
  					<td> <?= $row['cas_id'];?> </td>
					<td> <?= $row['dated'];?> </td>
  					<td> <?= $row['brand'];?> </td>
  					<td> <?= $row['merchandise_category'];?> </td>
  					<td> <?= $row['commission_percentage'];?> </td>
  					<td> <?= $row['period_start'];?> </td>
  					<td> <?= $row['period_end'];?> </td>
  					<td> <a href='#show-agreement' data-toggle='modal' title="View Details"  onclick="show_cas('<?= $row['cas_id'];?>')"> <i class="fa fa-fw fa-list txt-color-blue hidden-md"></i> </a>  
					<!-- <a href='#show-items' data-toggle='modal'  title="View Items" onclick="view_items()"> <img src="<?php echo base_url();?>assets/img/items-icon.png" width="16" height="16"> </a>-->
					</td>
  				</tr>
				<?php endforeach;?>	
  			</tbody>
  		</table>
	    <?php  
	}
	
	public function view_items()
	{
		$vcode   = $_POST['vcode'];
		$items = $this->concession_model->getalltblwhere("tbl_items","vendor_code='$vcode'");
		?> Vendor Code : <?= $vcode;?>
		
		<table id="itemDTable" class="table table-bordered table-sm dt-responsive nowrap" style='font-size:13px'>
			<thead>
				<tr>
					<th class="text-nowrap"> Code </th>
					<th class="text-nowrap"> Description </th>
					<th class="text-nowrap"> Comm Rate </th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($items as $row)
			{														
				echo "
				<tr>
					<td> $row[item_code] </td>
					<td> $row[ext_desc] </td>
					<td> $row[comm_rate]% </td>
				</tr>";
			} ?>
			</tbody>
		</table>
		<script type="text/javascript">
        	$(document).ready(function() {
        		var dataTable = $('#itemDTable').DataTable({});
        	});
        </script>
		<?php
	}
	
	public function view_deductions()
	{
	   	$vcode      = $_POST['vcode'];				
		$deductions = $this->concession_model->getalltblwhere("tbl_deductions","vendor_code='$vcode'");
		?>
  		<table id="deDTable" class="table table-bordered table-sm dt-responsive nowrap" style='font-size:13px'>
  			<thead>	
  				<tr>
  					<th> Doc No. </th>
  					<th> Vendor </th>
					<th> Store </th>
					<th> Posting Date </th>
					<th> Deduction Type </th>
					<th> Details </th>
					<th> Amount </th>
  				</tr>
  			</thead>
  			<tbody>	
				<?php 
				if(!empty($deductions)){
    				foreach($deductions as $row):
    				
    					$postingDate = $this->concession_model->cDF("m/d/Y",$row['posting_date']);
    					$dedtype 	 = $this->concession_model->getOneField("description","tbl_deduction_types","accountno='$row[deduction_type]' ")->description;
    					$company 	 = $this->concession_model->getOneField("name","tbl_code_company","company_code='$row[comp_code]' ")->name;
    
    					if($row['status'] == 'Downloaded'){
    						$label    = "<span class='badge badge-success' id='status_$row[ded_no]'> $row[status] </span>";
    					}else if($row['status'] == 'Paid'){
    						$label    = "<span class='badge badge-warning' id='status_$row[ded_no]'> $row[status] </span>";									
    					}
    						
    					echo "	
    					<tr>	
    						<td> ".$row['doc_no']." </td>
    						<td> ".$row['vendor_code']." </td>
    						<td> $company </td>
    						<td> $postingDate </td>
    						<td> $dedtype </td>
    						<td> ".$row['deduction_details']." </td>
    						<td> ".$row['amount']." </td>
    					</tr>";
    				
    				endforeach;
				}?>
  			</tbody>
  		</table>     
  		<script type="text/javascript">
        	$(document).ready(function() {
        		var dataTable = $('#deDTable').DataTable({});
        	});
        </script> <?php
	}
	
	public function view_check()
	{
    	$vcode      = $_POST['vcode'];
		$check = $this->concession_model->getalltblwhere("tbl_check_monitoring","vendor_code='$vcode'"); 
		?>
		
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
  		<script type="text/javascript">
        	$(document).ready(function() {
        		var dataTable = $('#checkDTable').DataTable({});
        	});
        </script> <?php
	}

	
	public function view_sales()
	{
	    $vcode = $_POST['vcode'];
		$sales = $this->concession_model->getalltblwhere("tbl_item_sales_summary","vendor_code='$vcode'"); 
	    ?>
    	<table class="table table-striped table-bordered table-hover" id='salesDtable' width="100%" style='font-size:13px'>
  			<thead>			                
  				<tr>
  					<th width='5'> NO </th>
					<th width='30'> CUTOFF </th>
					<th width='5'> STORE </th>
					<th width='5'> DEPT </th>			  					
  					<th width='25'> NET SALE W/ VAT </th>
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
					<td> <a href='<?php echo base_url('vendor_sales_pdf/'.$row['iss_no']); ?>') target='_blank'> PDF </a> </td>
  				</tr>		  				
  				<?php endforeach; ?>
  			</tbody>
  		</table>
  		
  		<script type="text/javascript">
        	$(document).ready(function() {
        		var dataTable = $('#salesDtable').DataTable({});
        	});
        </script> <?php
	}
	
	public function view_po()
	{
	    $vcode      = $_POST['vcode'];
		$po         = $this->concession_model->getalltblwhere("tbl_po_requisition","vendor_code='$vcode'");
		$columns    = array("PO #","Vendor Code","Store","Department","Date Requested","Status","Received","Action");
	    ?>
    	<table class="table table-striped table-bordered table-hover" id='poDtable' width="100%" style='font-size:13px'>
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

					if($row['status'] == 'POSTED'){	$label = "success"; }else{	$label = "warning";	} 
						
					echo "	
					<tr>	
						<td> ".$row['ref_no']." </td>
						<td> ".$row['vendor_code']." </td>
						<td> $company </td>
						<td> $dept </td>
						<td> ".$this->concession_model->cDF("m/d/Y",$row['date_requested'])." </td>
						<td> <span class='badge badge-".$label."'> ".$row['status']."</span> </td>
						<td> </td>";?>
						<td> <a href='<?php echo base_url('vendor_po_pdf/'.$row['ref_no']); ?>') target='_blank'> PDF </a> </td> <?php echo "
					</tr>";
				endforeach;
				}?>
  			</tbody>
  		</table>
  		
  		<script type="text/javascript">
        	$(document).ready(function() {
        		var dataTable = $('#poDtable').DataTable({});
        	});
        </script> <?php
	}
	public function vendor_po_pdf($refno)
	{		
	    $popdf      = $this->concession_model->getfrmtblwhere("tbl_po_requisition"," ref_no = '$refno' ");
        $company    = $this->concession_model->getOneField("name","tbl_code_company","company_code ='$popdf->compcode' ")->name;
        $dshortcut  = $this->concession_model->getOneField("dept_name","tbl_code_department","dept_code ='$popdf->deptcode' ")->dept_name; //department                   
        $data['popdf']    = $this->concession_model->getfrmtblwhere("tbl_po_requisition"," ref_no = '$refno' ");

        //GET THE DATA NEEDED   
        $data['daterequested']  = $this->concession_model->cDF("m/d/Y",$popdf->date_requested); 
        $data['vcode']  = $popdf->vendor_code;
        $data['vendor'] = $this->concession_model->getVendorName($popdf->vendor_code);
        $requested_by   = explode("*",$popdf->requested_by);
        
        //$data['receivedby'] = @$this->vendor_model->getOneField("concat(firstname,' ',lastname) as name","tbl_users_admin","user_id='$requested_by[0]' ")->name;
        //$data['approvedby'] = @$this->vendor_model->getOneField("concat(firstname,' ',lastname) as name","tbl_users_admin","user_id='$approved_by[0]' ")->name;
        $data['poitems']    = $this->concession_model->getalltblwhere("tbl_po_requisition_details"," ref_no = '$refno' ");
        $data['refno']   = $refno;
        $data['company'] = $company;
        $data['dept']    = $dshortcut;        
		$this->load->view("body/cms/po/po_pdf", $data);
	}
	
	public function view_received_po()
	{
        $refno          = @$_POST['refno'];
        $receive        = @$_POST['receive']; //receive is for tbl_po_requisition_details //received is for tbl_po_receiving_details
    
        $podetails      = $this->concession_model->getfrmtblwhere("tbl_po_requisition","ref_no='$refno'"); 
        $daterequested  = $this->concession_model->cDF("m/d/y H:i:sa",$podetails->date_requested);         
      
        $poreceived     = $this->concession_model->getfrmtblwhere("tbl_po_receiving","ref_no='$refno'"); 
      
        $vendorname     = $this->concession_model->getVendorName($podetails->vendor_code);
        $company        = $this->concession_model->getOneField("name","tbl_code_company","company_code ='$podetails->compcode' ")->name; //company        
        $dshortcut      = $this->concession_model->getOneField("dept_name","tbl_code_department","dept_code ='$podetails->deptcode' ")->dept_name; //department
        
        $items          = $this->concession_model->getalltblwhere("tbl_po_receiving_details","ref_no='$refno'");
        $datereceived   = $this->concession_model->cDF("m/d/y H:i:sa",@$poreceived->date_received);
       
                
        echo "
        <center> 
            <b style='font-size:18px;font-weight:bold'> $company - $dshortcut </b> <br> 
            PO No.: $refno <br>
            $vendorname <br><br>
        </center>
        <table class='table-bordered' width='100%' cellpadding='3'>
            <tr> 
                <td width='15%' align='right'> Date Requested : </td>
                <td width='40%'> $daterequested </td>
                <td width='15%' align='right'> Date Received : </td>
                <td width='20%'> $datereceived </td>                
            </tr>
        </table>   
        
        <center> <h4> ITEM DETAILS </h4> </center>
        <table class='table-bordered' width='100%' cellpadding='3'>
            <tr align='center'>
                <th> ITEM CODE </th>
                <th> ITEM DESCRIPTION </th> 
                <th> PO QUANTITY </th> 
                <th> QUANTITY RECEIVED</th>
                <th> QUANTITY VARIANCE </th>
            </tr>";
        
            $totpoqty = $totrecqty = $totvar = 0;
            foreach ($items as $row){      
                                    
                $po_qty = $this->concession_model->getOneField("qty","tbl_po_requisition_details","ref_no='$refno' and item_code = '$row[item_code]' and vendor_code = '$podetails->vendor_code' ")->qty;
                $qty_var = abs($po_qty-$row['received_qty']);
                $totpoqty += $po_qty;
                $totrecqty +=  $row['received_qty'];
                $totvar += $qty_var;

                echo "
                <tr>
                    <td align='center'> $row[item_code] </td>
                    <td> &nbsp; $row[item_desc] </td>
                    <td align='center'> $po_qty </td>
                    <td align='center'> $row[received_qty] </td>
                    <td align='center'> <b style='color:red'> $qty_var </b> </td>
                </tr>";
            }
            
           
            echo " 
            <tr>
                <td colspan='2' align='right'> TOTAL </td>
                <td align='center'> $totpoqty </td>
                <td align='center'> $totrecqty </td>
                <td align='center'> <b style='color:red'> $totvar </b> </td>
            </tr>
        </table> 
        <br> <i> Note: Excess goods must be return to Supplier. </i>";
       
    }
	
	public function items_pdf($vcode)
	{			
		$data['item']      = $this->concession_model->getfrmtblwhere("tbl_items","vendor_code = '$vcode' ");
		$data['items']     = $this->concession_model->getalltblwhere("tbl_items","vendor_code = '$vcode' "); 
		$this->load->view("body/cms/items/items_pdf", $data);
	}	
	
	
	
}