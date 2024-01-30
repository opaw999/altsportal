<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms_model extends CI_Model
{
    // public $loginId = '';
    // private $db_pis;
    // private $db_piscolonnade;
    // private $db_tkcolonnade;
    // public $timestamp = '';

    function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];
        date_default_timezone_set('Asia/Manila');
        $this->timestamp = date("Y-m-d H:i:s");
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
	
	public function getVName($vendorcode)
	{
		$this->db->select("vendor_name");
		$this->db->where("vendor_code",$vendorcode); 
		$query = $this->db->get("tbl_vendor");
		return @$query->row()->vendor_name;
	}
	
}
