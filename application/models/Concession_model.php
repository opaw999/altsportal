<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concession_model extends CI_Model {

    public $timekeeping2;
    public $pis2;

	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
    }
	
	//reusable table
	public function cDF($changeformatto,$date)
	{	
		if($date != '0000-00-00'){
			$convert_date = new DateTime($date); 		
			return $convert_date->format($changeformatto);
		}else{
			return '';
		}
	}
	
	public function getallfrmtbl($table)
	{		
		$query = $this->db->get($table);
		return $query->result_array();	
	}
	
	public function getalltblwhere($table,$where)
	{		
		$this->db->where($where); 
		$query = $this->db->get($table);
		return $query->result_array();	
	}
	
	public function getfrmtblwhere($table,$where)
	{		
		$this->db->where($where); 
		$query = $this->db->get($table);
		return $query->row();	
	}
	
	public function getOneField($field,$table,$where)
	{
		$this->db->select($field);
		$this->db->where($where); 
		$query = $this->db->get($table);
		return $query->row();
	}  
	
	public function getVendorName($vendorcode)
	{
		$this->db->select("vendor_name");
		$this->db->where("vendor_code",$vendorcode); 
		$query = $this->db->get("tbl_vendor");
		return @$query->row()->vendor_name;
	}
	
	//public function get_sales_division($vendorcode,$datefrom,$dateto)
	public function get_sales_division($where,$datefrom,$dateto)
	{
/*		$this->db->select('distinct(tbl_items.item_division)'); 
		$this->db->from("tbl_items");
		$this->db->join("tbl_item_sales", "tbl_items.item_code = tbl_item_sales.item_code", 'inner');	
		$this->db->where("(period_start = '$datefrom' and period_end = '$dateto') and tbl_item_sales.vendor_code = '$vendorcode'");		
		$query = $this->db->get();
		return $query->result_array();*/
		
		$this->db->select('distinct(item_division)'); 	
		$this->db->where($where);		
		$query = $this->db->get("tbl_items");
		return $query->result_array();
	}
	
	//public function get_item_sales_report($vendorcode,$datefrom,$dateto,$itemdiv,$compcode)
	public function get_item_sales_report($div,$issno,$vcode)
	{
	/*	$this->db->select('is.vendor_code, is.qty, is.item_code, is.item_desc, is.net_sale_with_vat, is.total_disc'); 
		$this->db->from("tbl_items");
		$this->db->join("tbl_item_sales as is", "tbl_items.item_code = is.item_code", 'inner');	
		$this->db->where("is.period_start='$datefrom' and is.period_end = '$dateto' and is.vendor_code = '$vendorcode' and item_division ='$itemdiv' and company_code = '$compcode' ");		
		$query = $this->db->get();
		return $query->result_array();*/
		
		$this->db->select('tis.vendor_code, tis.qty, tis.item_code, tis.item_desc, tis.net_sale_with_vat, tis.total_disc '); 
		$this->db->from("tbl_item_sales as tis");
		$this->db->join("tbl_items", "tbl_items.item_code = tis.item_code", 'inner');	
		$this->db->where("tis.suf_id = '$issno' and item_division = '$div' and tbl_items.vendor_code = '$vcode' ");		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getDivision($code)
	{
		$this->db->select("division_name");
		$this->db->where("division_code",$code); 
		$query = $this->db->get("tbl_item_division");
		return $query->row()->division_name;
	}
	
	public function getVendorCode($where){
		$this->db->where($where); 
		$this->db->limit(1); 
		$query = $this->db->get('tbl_supplier_vendor_codes');
		return $query->row()->vendor_code;	
	}

	public function getVendorCodes($where){
		$this->db->where($where); 
		$query = $this->db->get('tbl_supplier_vendor_codes');
		return $query->result_array();
	}
	
	public function countVendorCode($where){
		$this->db->select("count(vendor_code) as countcode");
		$this->db->where($where); 
		$query = $this->db->get('tbl_supplier_vendor_codes');
		return $query->row()->countcode;	
	}

	public function getstores_concat($vcode)
	{
		$this->db->select(" group_concat(DISTINCT store SEPARATOR ', ') as stores");
		$this->db->from('tbl_vendor_terms_setup');
		$this->db->join('tbl_stores', 'tbl_vendor_terms_setup.store_id = tbl_stores.store_id', 'inner');			
		$this->db->where("vendor_code",$vcode);
		$query = $this->db->get();
		return $query->row()->stores;	
	}
	
	public function getstore_terms($vcode)
	{
		$this->db->select(" aname, terms ");
		$this->db->from('tbl_vendor_terms_setup');
		$this->db->join('tbl_stores', 'tbl_vendor_terms_setup.store_id = tbl_stores.store_id', 'inner');			
		$this->db->where("vendor_code",$vcode);
		$query = $this->db->get();
		return $query->result_array();			
	}
	
	public function insert_table($data,$table){
		$query = $this->db->insert($table, $data);
		if($query){
		  	return $this->db->insert_id();
		}else{ 
			return "FALSE"; 
		}  
	}
	
// 	public function getVendorName($vendorcode)
// 	{
// 		$this->db->select("vendor_name");
// 		$this->db->where("vendor_code",$vendorcode); 
// 		$query = $this->db->get("tbl_vendor");
// 		return @$query->row()->vendor_name;
// 	}
}