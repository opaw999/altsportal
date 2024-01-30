<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup_model extends CI_Model
{

    public $loginId = '';
    private $db_pis;
    private $db_piscolonnade;
    private $db_tkcolonnade;
    public $timestamp = '';

    function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];

        $this->db_pis = $this->load->database('pis', TRUE);
        $this->db_piscolonnade = $this->load->database('pis_colonnade', TRUE);
        $this->db_tkcolonnade = $this->load->database('tk_colonnade', TRUE);
        $this->db_tktalibon = $this->load->database('tk_talibon', TRUE);
        $this->db_tktubigon = $this->load->database('tk_tubigon', TRUE);

        date_default_timezone_set('Asia/Manila');
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function return_result_array($sql)
    {

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function return_row_array($sql)
    {

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function return_num_rows($sql)
    {

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function return_result($sql)
    {

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function return_row($sql)
    {

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function get_supplier_code($supplier_id)
    {
        $query = $this->db->get_where('tbl_supplier_vendor_codes', array('vendor_id' => $supplier_id));
        return $query->result();
    }

    public function supplier_list()
    {

        $query = $this->db->get('promo_supplier');
        return $query->result();
    }

    public function supplier_type($id)
    {
        $query = $this->db->get_where('promo_supplier_type', array('id' => $id));
        return $query->row_array();
    }

    public function supplier_types()
    {
        $query = $this->db->get('promo_supplier_type');
        return $query->result();
    }

    public function create_supplier($data)
    {

        $insert = array(
            'supplier'   => $data['supplier'],
            'supplier_type' => $data['supplier_type'],
            'created_at'    => $this->timestamp,
            'updated_at'    => $this->timestamp
        );

        return $this->db->insert('promo_supplier', $insert);
    }

    public function update_supplier($data)
    {

        $update = array(
            'supplier'   => $data['supplier'],
            'supplier_type' => $data['supplier_type'],
            'updated_at'    => $this->timestamp
        );

        $this->db->where('id', $data['id']);
        return $this->db->update('promo_supplier', $update);
    }

    public function supplier_details($id)
    {
        $query = $this->db->get_where('promo_supplier', array('id' => $id));
        return $query->row();
    }

    public function vendor_list()
    {
        $query = $this->db->get('tbl_vendor');
        return $query->result();
    }

    public function exist_supplier($supplier)
    {
        $query = $this->db->select('COUNT(id) AS exist')
            ->get_where('promo_supplier', array('supplier' => $supplier));
        return $query->row_array();
    }

    public function supplier_status($data)
    {

        if ($data['action'] == "deactivate") {

            $update = array(
                'status'  => 0
            );
        } else {

            $update = array(
                'status'  => 1
            );
        }

        $this->db->where('id', $data['id']);
        return $this->db->update('promo_supplier', $update);
    }

    public function supplier_user_status($data)
    {

        if ($data['action'] == "deactivate") {

            $update = array(
                'status'  => 0
            );
        } else {

            $update = array(
                'status'  => 1
            );
        }

        $this->db->where('supplier_id', $data['id']);
        return $this->db->update('promo_supplier_user', $update);
    }

    public function supplier_status_account($data)
    {

        if ($data['action'] == "deactivate") {

            $update = array(
                'status'  => 0
            );
        } else {

            $update = array(
                'status'  => 1
            );
        }

        $this->db->where('id', $data['id']);
        return $this->db->update('promo_supplier_user', $update);
    }

    public function supplier_reset_password($id)
    {
        $password = password_hash('Altsportal2019', PASSWORD_DEFAULT);

        $update = array(
            'password'  => $password
        );
        $this->db->where('id', $id);
        return $this->db->update('promo_supplier_user', $update);
    }

    public function supplier_account_list()
    {
        $query = $this->db->select('promo_supplier_user.id AS user_id, supplier_id, supplier, username, date_from, date_to, promo_supplier_user.status, first_login, address, email_address, telephone, cellphone')
            ->from('promo_supplier_user')
            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
            ->where('promo_supplier.supplier_type !=', 3)
            ->get();
        return $query->result();
    }

    public function consignor_account_list()
    {
        $query = $this->db->select('promo_supplier_user.id AS user_id, supplier_id, supplier, username, date_from, date_to, promo_supplier_user.status, first_login, address, email_address, telephone, cellphone')
            ->from('promo_supplier_user')
            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
            ->get();
        return $query->result();
    }

    public function active_supplier_list()
    {
        $this->db->order_by('supplier', 'ASC');
        $query = $this->db->get_where('promo_supplier', array('status' => true));
        return $query->result();
    }

    public function alturas_agency()
    {
        $query = $this->db->from('promo_locate_agency')
            ->order_by('agency_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function colonnade_agency()
    {
        $query = $this->db_tkcolonnade->from('promo_locate_agency')
            ->order_by('agency_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function alturas_company()
    {
        $query = $this->db_pis->from('locate_promo_company')
            ->order_by('pc_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function colonnade_company()
    {
        $query = $this->db_piscolonnade->from('locate_promo_company')
            ->order_by('pc_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function exist_supplier_username($username)
    {
        $query = $this->db->select('COUNT(id) AS exist')
            ->get_where('promo_supplier_user', array('username' => $username));
        return $query->row_array();
    }

    public function create_supplier_account($data)
    {

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $insert = array(
            'supplier_id'   => $data['supplier'],
            'username'      => $data['username'],
            'password'      => $password,
            'date_from'     => date("Y-m-d", strtotime($data['dateFrom'])),
            'date_to'       => date("Y-m-d", strtotime($data['dateTo'])),
            'created_at'    => $this->timestamp,
            'updated_at'    => $this->timestamp
        );

        $this->db->insert('promo_supplier_user', $insert);
        return $this->db->insert_id();
    }

    public function vendor_details($id)
    {
        $query = $this->db->get_where('tbl_vendor', array('vendor_id' => $id));
        return $query->row();
    }

    public function create_tbl_supplier_code($vendor_id, $vendor)
    {
        $insert = array(
            'vendor_id'   => $vendor_id,
            'vendor_code' => $vendor->vendor_code,
            'vendor_name' => $vendor->vendor_name,
            'created_at'  => $this->timestamp,
            'updated_at'  => $this->timestamp
        );
        return $this->db->insert('tbl_supplier_vendor_codes', $insert);
    }

    public function delete_tag_vendor($supplier_id)
    {
        return $this->db->delete('tbl_supplier_vendor_codes', array('vendor_id' => $supplier_id));
    }

    public function fetch_contract($id)
    {
        $query = $this->db->select('supplier_id, supplier, date_from, date_to')
            ->from('promo_supplier_user')
            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
            ->where('promo_supplier_user.id', $id)
            ->get();
        return $query->row();
    }

    public function insert_supplier_contract_history($data)
    {

        $insert = array(
            'supplier_id'   => $data['supplier_id'],
            'date_from'     => $data['previous_datefrom'],
            'date_to'       => $data['previous_dateto'],
            'created_at'    => $this->timestamp,
            'updated_at'    => $this->timestamp
        );

        return $this->db->insert('promo_supplier_contract_hist', $insert);
    }

    public function update_supplier_contract($data)
    {

        $update = array(
            'date_from'  => date('Y-m-d', strtotime($data['fromDate'])),
            'date_to'    => date('Y-m-d', strtotime($data['toDate']))
        );

        $this->db->where('supplier_id', $data['supplier_id']);
        return $this->db->update('promo_supplier_user', $update);
    }

    public function create_alturas_ac_code($data, $user_id)
    {

        $insert = array(
            'user_id'       => $user_id,
            'supplier_id'   => $data['supplier'],
            'agency_code'   => $data['alturas_agency'],
            'company_code'  => $data['alturas_company'],
            'created_at'    => $this->timestamp,
            'updated_at'    => $this->timestamp
        );

        return $this->db->insert('promo_supplier_ac_code', $insert);
    }

    public function create_colonnade_ac_code($data, $user_id)
    {

        $insert = array(
            'user_id'       => $user_id,
            'supplier_id'   => $data['supplier'],
            'agency_code'   => $data['colonnade_agency'],
            'company_code'  => $data['colonnade_company'],
            'created_at'    => $this->timestamp,
            'updated_at'    => $this->timestamp
        );

        return $this->db_tkcolonnade->insert('promo_supplier_ac_code', $insert);
    }

    public function update_alturas_ac_code($data)
    {

        $update = array(
            'agency_code'   => $data['alturas_agency'],
            'company_code'  => $data['alturas_company'],
            'updated_at'    => $this->timestamp
        );

        $insert = array(
            'user_id' => $data['user_id'],
            'supplier_id' => $data['supplier_id'],
            'agency_code'   => $data['colonnade_agency'],
            'company_code'  => $data['colonnade_company'],
            'updated_at'    => $this->timestamp
        );
        $array = array('user_id' => $data['user_id'], 'supplier_id' => $data['supplier_id']);

        $query = $this->db->get_where('promo_supplier_ac_code', $array);
        $count = $query->row_array();

        if (is_array($count) && !empty($count)) {
            $this->db->where($array);
            return $this->db->update('promo_supplier_ac_code', $update);
        } else {

            return $this->db->insert('promo_supplier_ac_code', $insert);
        }
    }

    public function update_colonnade_ac_code($data)
    {

        $update = array(
            'agency_code'   => $data['colonnade_agency'],
            'company_code'  => $data['colonnade_company'],
            'updated_at'    => $this->timestamp
        );

        $insert = array(
            'user_id' => $data['user_id'],
            'supplier_id' => $data['supplier_id'],
            'agency_code'   => $data['colonnade_agency'],
            'company_code'  => $data['colonnade_company'],
            'updated_at'    => $this->timestamp
        );
        $array = array('user_id' => $data['user_id'], 'supplier_id' => $data['supplier_id']);

        $query = $this->db_tkcolonnade->get_where('promo_supplier_ac_code', $array);
        $count = $query->row_array();

        if (is_array($count) && !empty($count)) {
            $this->db_tkcolonnade->where($array);
            return $this->db_tkcolonnade->update('promo_supplier_ac_code', $update);
        } else {

            return $this->db_tkcolonnade->insert('promo_supplier_ac_code', $insert);
        }
    }

    public function fetch_alturas_ac($user_id)
    {
        $query = $this->db->get_where('promo_supplier_ac_code', array('user_id' => $user_id));
        return $query->row();
    }

    public function fetch_colonnade_ac($user_id)
    {
        $query = $this->db_tkcolonnade->get_where('promo_supplier_ac_code', array('user_id' => $user_id));
        return $query->row();
    }

    public function users_account()
    {

        $query = $this->db->from('promo_supplier_user')
            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
            ->get();
        return $query->result();
    }

    public function get_supplier($field, $table, $where, $code)
    {

        $query = $this->db->select($field)
            ->get_where($table, array($where => $code));
        return $query->row_array();
    }

    public function delete_user($userId)
    {

        // return $this->db->delete('promo_company_user', array('userId' => $userId));

        $update = array(
            'status'  => 'inactive'
        );

        $this->db->where('userId', $userId);
        return $this->db->update('promo_company_user', $update);
    }

    public function update_contract($data)
    {

        $update = array(
            'dateFrom'  => date('Y-m-d', strtotime($data['fromDate'])),
            'dateTo'    => date('Y-m-d', strtotime($data['toDate'])),
            'ext_days'  => 3
        );

        $this->db->where('userId', $data['userId']);
        return $this->db->update('promo_company_user', $update);
    }

    public function list_of_cutoffs()
    {

        $query = $this->db->get_where('promo_schedule', array('remark' => 'active'));
        return $query->result_array();
    }

    public function chk_cutoff($supplier_id, $statCut)
    {

        $query = $this->db->select('pcId')
            ->get_where('promo_supplier_cutoff', array('statCut' => $statCut, 'supplier_id' => $supplier_id));
        return $query->num_rows();
    }

    public function insertAll_com_cut($supplier_id, $statCut)
    {

        $insert = array(
            'statCut'   => $statCut,
            'supplier_id'    => $supplier_id
        );

        return $this->db->insert('promo_supplier_cutoff', $insert);
    }

    public function deleteAll_com_cut($supplier_id)
    {

        return $this->db->delete('promo_supplier_cutoff', array('supplier_id' => $supplier_id));
    }

    public function insert_com_cut($data)
    {

        $insert = array(
            'statCut'   => $data['cutoff'],
            'supplier_id'    => $data['supplier_id']
        );

        return $this->db->insert('promo_supplier_cutoff', $insert);
    }

    public function delete_com_cut($data)
    {

        return $this->db->delete('promo_supplier_cutoff', array('statCut' => $data['cutoff'], 'supplier_id' => $data['supplier_id']));
    }

    public function list_of_agency()
    {

        $query = $this->db->select('agency_code, agency_name')
            ->from('promo_locate_agency')
            ->order_by('agency_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function list_of_company()
    {

        $query = $this->db_pis->select('pc_code, pc_name')
            ->from('locate_promo_company')
            ->order_by('pc_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function check_userpass($username, $password)
    {

        $query = $this->db->select('cuId')
            ->get_where('promo_company_user', array('username' => $username, 'password' => $password));
        return $query->num_rows();
    }

    public function get_userId()
    {

        $query = $this->db->select('userId')
            ->from('promo_company_user')
            ->order_by('userId', 'DESC')
            ->limit(1)
            ->get();
        return $query->row_array();
    }

    public function insert_agency_user($data, $userId, $password)
    {

        $insert = array(
            'userId'        => $userId,
            'username'      => $data['username'],
            'pass'          => $password,
            'password'      => $data['password'],
            'agency_code'   => $data['agency'],
            'company_code'  => $data['company'],
            'dateFrom'      => date('Y-m-d', strtotime($data['dateFrom'])),
            'dateTo'        => date('Y-m-d', strtotime($data['dateTo'])),
            'group3'        => $data['group3'],
            'ext_days'      => 3,
            'status'        => 'active',
            'date_create'   => date('Y-m-d'),
            'time_create'   => date('H:i:s')
        );

        return $this->db->insert('promo_company_user', $insert);
    }

    public function insert_company_user($data, $userId, $password, $company_code)
    {

        $insert = array(
            'userId'        => $userId,
            'username'      => $data['username'],
            'pass'          => $password,
            'password'      => $data['password'],
            'agency_code'   => $data['agency'],
            'company_code'  => $company_code,
            'dateFrom'      => date('Y-m-d', strtotime($data['dateFrom'])),
            'dateTo'        => date('Y-m-d', strtotime($data['dateTo'])),
            'group3'        => $data['group3'],
            'ext_days'      => 3,
            'status'        => 'active',
            'date_create'   => date('Y-m-d'),
            'time_create'   => date('H:i:s')
        );

        return $this->db->insert('promo_company_user', $insert);
    }

    public function com_under_agency($agency_code)
    {

        $query = $this->db->select('company_code')
            ->get_where('promo_locate_company', array('agency_code' => $agency_code));
        return $query->result();
    }

    public function insert_user_company($userId, $company_code)
    {

        $insert = array(
            'userId'        => $userId,
            'company_code'  => $company_code,
            'status'        => 'active'
        );

        return $this->db->insert('promo_user_company', $insert);
    }

    public function insert_locate_com($agency, $company)
    {

        $insert = array(
            'agency_code'   => $agency,
            'company_name'  => $company
        );

        $this->db->insert('promo_locate_company', $insert);
        return $this->db->insert_id();
    }

    public function promo_company_user_details($userId)
    {

        $query = $this->db->get_where('promo_company_user', array('userId' => $userId));
        return $query->row();
    }

    public function insert_contract_history($data)
    {

        $insert = array(
            'userId'    => $data['userId'],
            'dateFrom'  => $data['prev_dateFrom'],
            'dateTo'    => $data['prev_dateTo']
        );

        return $this->db->insert('promo_company_user_history', $insert);
    }

    public function company_for_agency($agency_code)
    {

        $query = $this->db->select('company_code, agency_code, company_name')
            ->from('promo_locate_company')
            ->where('agency_code', $agency_code)
            ->get();
        // ->get_where('promo_locate_company', array('agency_code' => $agency_code));
        return $query->result();
    }

    public function list_of_agencies()
    {

        $query = $this->db->select('agency_code, agency_name, acroname')
            ->from('promo_locate_agency')
            ->order_by('agency_name', 'ASC')
            ->get();
        return $query->result();
    }

    public function delete_company($company_code)
    {

        return $this->db->delete('promo_locate_company', array('company_code' => $company_code));
    }

    public function insert_agency($agency_name)
    {

        $insert = array(
            'agency_name'    => $agency_name
        );

        return $this->db->insert('promo_locate_agency', $insert);
    }

    public function chk_locate_company($agency_code, $company)
    {

        $query = $this->db->select('company_code')
            ->get_where('promo_locate_company', array('agency_code' => $agency_code, 'company_name' => $company));
        return $query->num_rows();
    }

    public function delete_locate_company($agency_code)
    {

        return $this->db->delete('promo_locate_company', array('agency_code' => $agency_code));
    }

    public function insert_locate_company($agency_code, $company)
    {

        $insert = array(
            'agency_code'    => $agency_code,
            'company_name'    => $company
        );

        return $this->db->insert('promo_locate_company', $insert);
    }

    public function list_of_users()
    {

        $query = $this->db->order_by('fullname', 'ASC')
            ->get('admin_user');
        return $query->result();
    }

    public function reset_password($user_no)
    {

        $password = password_hash('Hrms2014', PASSWORD_DEFAULT);

        $update = array(
            'password'  => $password
        );

        $this->db->where('user_no', $user_no);
        return $this->db->update('admin_user', $update);
    }

    public function user_status($data)
    {

        if ($data['action'] == "deactivated") {

            $update = array(
                'status'  => 'inactive'
            );
        } else {

            $update = array(
                'status'  => 'active'
            );
        }

        $this->db->where('user_no', $data['userId']);
        return $this->db->update('admin_user', $update);
    }

    public function insert_admin_user($data)
    {

        $password = password_hash('Hrms2014', PASSWORD_DEFAULT);

        if ($data['server_loc'] == "server_tal") {

            $location = "Alturas Talibon";
        } else if ($data['server_loc'] == "server_tub") {

            $location = "Alturas Tubigon";
        } else if ($data['server_loc'] == "server_colonnade") {

            $location = "Colonnade";
        } else {

            $location = "Corporate";
        }

        $insert = array(
            'username'      => $data['username'],
            'password'      => $password,
            'fullname'      => ucwords(strtolower($data['fullname'])),
            'server'        => $data['server_loc'],
            'server_loc'    => $location,
            'status'        => 'active',
            'date_added'    => date('Y-m-d H:i:s')
        );

        return $this->db->insert('admin_user', $insert);
    }

    public function update_admin_user($data)
    {

        if ($data['server_loc'] == "server_tal") {

            $location = "Alturas Talibon";
        } else if ($data['server_loc'] == "server_tub") {

            $location = "Alturas Tubigon";
        } else if ($data['server_loc'] == "server_colonnade") {

            $location = "Colonnade";
        } else {

            $location = "Corporate";
        }

        $update = array(
            'username'  => $data['username'],
            'fullname'  => ucwords(strtolower($data['fullname'])),
            'server'    => $data['server_loc'],
            'server_loc' => $location
        );

        $this->db->where('user_no', $data['user_no']);
        return $this->db->update('admin_user', $update);
    }

    public function adminUser($user_no)
    {

        $query = $this->db->get_where('admin_user', array('user_no' => $user_no));
        return $query->row();
    }

    public function delete_agency($agency_code)
    {

        return $this->db->delete('promo_locate_agency', array('agency_code' => $agency_code));
    }

    public function fetch_agency_name($agency_code)
    {

        $query = $this->db->select('agency_name')
            ->get_where('promo_locate_agency', array('agency_code' => $agency_code));
        return $query->row_array();
    }

    public function update_agency($data)
    {

        $update = array(
            'agency_name'  => $data['agencyName']
        );

        $this->db->where('agency_code', $data['agency_code']);
        return $this->db->update('promo_locate_agency', $update);
    }

    public function delete_companies($pc_code)
    {

        return $this->db_pis->delete('locate_promo_company', array('pc_code' => $pc_code));
    }

    public function insert_company($company_name)
    {

        $insert = array(
            'pc_name'   => $company_name
        );

        return $this->db_pis->insert('locate_promo_company', $insert);
    }

    public function fetch_company_name($pc_code)
    {

        $query = $this->db_pis->select('pc_name')
            ->get_where('locate_promo_company', array('pc_code' => $pc_code));
        return $query->row_array();
    }

    public function update_company($data)
    {

        $update = array(
            'pc_name'  => $data['companyName']
        );

        $this->db_pis->where('pc_code', $data['pc_code']);
        return $this->db_pis->update('locate_promo_company', $update);
    }
}
