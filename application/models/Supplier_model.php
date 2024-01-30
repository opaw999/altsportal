<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    public $timekeeping2;
    public $pis2;

	function __construct()
    {
        parent::__construct();

        $this->timekeeping2 = $this->load->database('timekeeping2', TRUE);
        $this->pis2 = $this->load->database('pis2', TRUE);
        date_default_timezone_set('Asia/Manila');
    }

    public function penalty_details($vendor_code, $store, $category_id, $date_from, $date_to) {

        $array = array('vendor_id' => $vendor_code, 'store' => $store, 'category_id' => $category_id, 'date_from' => $date_from, 'date_to' => $date_to);
        $query = $this->timekeeping2->from('concessionaires_penalties')
                        ->where($array)
                        ->get();
        return $query->row();
    }

    public function penalty_perday($id)
    {
        $query = $this->timekeeping2->get_where('concessionaires_penalty_perdays', array('penalty_id' => $id));
        return $query->result();
    }

    public function supplier_name($vendor_code)
    {
        $query = $this->pis2->get_where('promo_vendor_lists', array('vendor_code' => $vendor_code));
        return $query->row();
    }

    public function business_unit($store)
    {
        $query = $this->pis2->get_where('locate_promo_business_unit', array('bunit_field' => $store));
        return $query->row();
    }

    public function category($category_id)
    {
        $query = $this->timekeeping2->get_where('vendor_categories', array('id' => $category_id));
        return $query->row();
    }
}