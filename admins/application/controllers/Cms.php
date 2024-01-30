<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('cms_model');
    }

    public function dataTable_script()
    {
        $data['request'] = $this->input->post('request', TRUE);
        $this->load->view('body/modal_response', $data);
    }

    public function fetch_vis()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_vis');
        $data       = array();
        
        foreach ($fetch_data as $row)
        {
            $sub_array = array();
            $sub_array[] = $row['vis_id'];
            $sub_array[] = $row['vendor_code'];
            $sub_array[] = $row['sole_name'];
            $sub_array[] = $row['business_name'];
            $sub_array[] = $row['business_address'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['date_established']); 
            $sub_array[] = $this->cms_model->cDF("m/d/Y H:i:s",$row['date_added']); 
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_cas()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_cas');
        $data       = array();
        
        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['cas_id'];
            $sub_array[] = $row['vendor_code'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['dated']);  
            $sub_array[] = $row['brand'];
            $sub_array[] = $row['concessionaire'];
            $sub_array[] = $row['period_start'];
            $sub_array[] = $row['period_end'];
            $sub_array[] = $row['merchandise_category'];
            $sub_array[] = $row['area_covered'];
            $sub_array[] = $row['commission_percentage'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['date_created']); 
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_po()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_po_requisition');
        $data       = array();
        
        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['ref_no'];
            $sub_array[] = $row['vendor_code'];
            $sub_array[] = $row['compcode'];
            $sub_array[] = $row['deptcode'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['date_requested']);
            $sub_array[] = $row['status'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_deduction()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_deductions');
        $data       = array();
        
        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['ded_no'];
            $sub_array[] = $row['doc_no'];
            $sub_array[] = $row['vendor_code'] ." - ".$this->cms_model->getVName($row['vendor_code']);
            $sub_array[] = $row['comp_code'];
            $sub_array[] = $row['dept_code'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['posting_date']);
            $sub_array[] = $row['deduction_details'];
            $sub_array[] = $row['amount'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_items()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_items');
        $data       = array();
        
        //commission_percentage
        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['item_no'];
            $sub_array[] = $row['item_code'];
            $sub_array[] = $row['ext_desc'];
            $sub_array[] = $row['vendor_code'];
            $sub_array[] = $row['comm_rate'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y H:i:s",$row['date_uploaded']);
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
	public function fetch_check_voucher()
	{
		$fetch_data = $this->cms_model->getallfrmtbl('tbl_check_voucher_line');
        $data       = array();

        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['checkv_id'];
            $sub_array[] = $row['cv_no'];
            $sub_array[] = $row['crf_no'];
            $sub_array[] = $row['vendor_code'];
            $sub_array[] = $row['doc_no'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
	}
	
	public function fetch_check_details()
	{
		$fetch_data = $this->cms_model->getallfrmtbl('tbl_check_details');
        $data       = array();

        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['check_id'];
            $sub_array[] = $row['check_no'];
            $sub_array[] = $row['cv_no'];
            $sub_array[] = $row['check_date'];
            $sub_array[] = $row['bank_acct'];
            $sub_array[] = $row['bank_name'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
	}
	
	public function fetch_check_monitoring()
	{
		$fetch_data = $this->cms_model->getallfrmtbl('tbl_check_monitoring');
        $data       = array();

        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['cv_id'];
            $sub_array[] = $row['cv_no'];
            $sub_array[] = $row['cv_date'];
            $sub_array[] = $row['cv_status'];
            $sub_array[] = $row['collector_name'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
	}
	
	public function fetch_sales()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_item_sales');
        $data       = array();
        
        //commission_percentage
        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['isr_no'];
            $sub_array[] = $row['suf_id'];
            $sub_array[] = $row['vendor_code'] ." - ".$this->cms_model->getVName($row['vendor_code']);
            $sub_array[] = $row['company_code'];
            $sub_array[] = $row['dept_code'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['p_start']);
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['p_end']); 
            $sub_array[] = $row['net_sale'];
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_sales_uploaded()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_item_sales_uploaded_file');
        $data       = array();

        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['suf_id'];
            $sub_array[] = $row['terms'];
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['cutoff_start']); 
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['cutoff_end']);
            $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['date_uploaded']);
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
    
    public function fetch_sales_summary()
    {
        $fetch_data = $this->cms_model->getallfrmtbl('tbl_item_sales_summary');
        $data       = array();

        foreach ($fetch_data as $row) 
        {
            $sub_array = array();
            $sub_array[] = $row['iss_no'];
            $sub_array[] = $row['vendor_code']."".$this->cms_model->getVName($row['vendor_code']);
            $sub_array[] = $row['commission_percentage'];
            $sub_array[] = $row['net_sale'];
            $sub_array[] = $row['sales_commission'];
            // $sub_array[] = $this->cms_model->cDF("m/d/Y",$row['date_posted']);
            $data[] = $sub_array;
        }
        echo json_encode(array("data" => $data));
    }
}
