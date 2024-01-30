<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
    }

    public function return_result_array($sql) {

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function return_row_array($sql) {

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function return_num_rows($sql) {

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function return_result($sql) {

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function supplier_details($user_id) {
        $query = $this->db->select('supplier, photo')
                            ->from('promo_supplier_user')
                            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
                            ->where('promo_supplier_user.id', $user_id)
                            ->get();
        return $query->row();
    }

    public function update_promo_supplier_user($userId, $first_login, $last_login) {

        if ($first_login == "") {
            
            $update = array(
                    'last_login' => $last_login
            );

        } else {

           $update = array(
                   'first_login' => $first_login,
                   'last_login' => $last_login
           ); 
        }
        

        $this->db->where('id', $userId);
        return $this->db->update('promo_supplier_user', $update);
    }

    public function check_user($data) {

        $query = $this->db->get_where('promo_supplier_user', array('username' => $data['username'], 'status' => 1));
        if ($query->num_rows() > 0) {

            return $query->row_array();
        }
    }
}