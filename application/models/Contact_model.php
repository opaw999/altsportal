<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

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

    public function submit_message($data) {

        $insert = array(
                'userId'    => $data['userId'],
                'sender'    => $data['sender'],
                'email'     => $data['email'],
                'subject'   => $data['subject'],
                'message'   => $data['message'],
                'date_submitted' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('message', $insert);
    }

    public function email_add($userId) {

        $query = $this->db->select('email_address')
                            ->get_where('promo_company_user', array('userId' => $userId));
        return $query->row_array();
    }
}