<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
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

    public function check_user($data) {

        $query = $this->db->get_where('admin_user', array('username' => $data['username'], 'status' => 'active'));
        if ($query->num_rows() > 0) {

            return $query->row_array();
        }
    }
}