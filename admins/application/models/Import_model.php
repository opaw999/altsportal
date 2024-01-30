<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_model extends CI_Model {

    public $loginId = '';
    private $db_pis;
    private $db_piscolonnade;
    private $db_tkcolonnade;
    private $db_tktalibon;
    private $db_tktubigon;

	function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];

        $this->db_pis = $this->load->database('pis', TRUE);
        $this->db_piscolonnade = $this->load->database('pis_colonnade', TRUE);
        $this->db_tkcolonnade = $this->load->database('tk_colonnade', TRUE);
        $this->db_tktalibon = $this->load->database('tk_talibon', TRUE);
        $this->db_tktubigon = $this->load->database('tk_tubigon', TRUE);
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

    public function query_this($database, $sql) {

        if ($database == "tk_talibon") {
            
            return $this->db_tktalibon->query($sql);
        }
        else if ($database == "pis") {
            
            return $this->db_pis->query($sql);
        }
        else if ($database == "tk_tubigon") {
            
            return $this->db_tktubigon->query($sql);
        }
        else if ($database == "tk_colonnade") {
            
            return $this->db_tkcolonnade->query($sql);
        }
        else if ($database == "pis_colonnade") {
            
            return $this->db_piscolonnade->query($sql);
        } else {

            return $this->db->query($sql);
        }
    }

    public function fetch_server($user_no) {

        $query = $this->db->select('server')
                            ->get_where('admin_user', array('user_no' => $user_no));
        return $query->row_array();
    }
}