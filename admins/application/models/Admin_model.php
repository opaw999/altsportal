<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public $loginId = '';

	function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];
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

    public function return_row($sql) {

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function chk_username($username) {

        $query = $this->db->select('user_no')
                            ->get_where('admin_user', array('username' => $username));
        return $query->num_rows();
    }

    public function chk_ur_username($user_no, $username) {

        $query = $this->db->select('user_no')
                            ->get_where('admin_user', array('user_no' => $user_no, 'username' => $username));
        return $query->num_rows();
    }

    public function update_admin_username($user_no, $username) {

        $update = array(
                'username'  => $username
        );

        $this->db->where('user_no', $user_no);
        return $this->db->update('admin_user', $update);
    }

    public function ur_password($user_no) {

        $query = $this->db->select('password')
                            ->get_where('admin_user', array('user_no', $user_no));
        return $query->row();
    }

    public function update_admin_password($user_no, $password) {

        $update = array(
                'password'  => $password
        );

        $this->db->where('user_no', $user_no);
        return $this->db->update('admin_user', $update);
    }
}