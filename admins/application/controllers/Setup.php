<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('setup_model');
    }

    public function dataTable_script()
    {

        $data['request'] = $this->input->post('request', TRUE);

        $this->load->view('body/modal_response', $data);
    }

    public function supplier_list()
    {

        $fetch_data = $this->setup_model->supplier_list();
        $data = array();
        foreach ($fetch_data as $row) {
            $type = $this->setup_model->supplier_type($row->supplier_type)['type'];
            $action = "";
            if ($row->status == 1) {

                $action .= '<i id="deactivate_' . $row->id . '" class="fa fa-lg fa-fw m-r-2 fa-times text-danger action" title="Click to deactivate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-success">' . $row->status . '</label>';
            } else {

                $action .= '<i id="activate_' . $row->id . '" class="fa fa-lg fa-fw m-r-2 fa-check text-success action" title="Click to activate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-danger">' . $row->status . '</label>';
            }

            $action .= '<i id="update_' . $row->id . '" class="far fa-lg fa-fw m-r-2 fa-edit text-primary action" title="Update Supplier"></i>';

            $sub_array = array();
            $sub_array[] = $row->supplier;
            $sub_array[] = $type;
            $sub_array[] = $row->status == 1 ? "<label class='btn btn-xs btn-block btn-success'>active</label>" : "<label class='btn btn-xs btn-block btn-danger'>inactive</label>";
            $sub_array[] = date("F d, Y h:i A", strtotime($row->created_at));
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function add_supplier_details()
    {

        $data['supplier_types'] = $this->setup_model->supplier_types();

        $data['request'] = "add_supplier_details";
        $this->load->view('body/modal_response', $data);
    }

    public function edit_supplier_details()
    {

        $id = $this->input->get('id', TRUE);
        $data['supplier'] = $this->setup_model->supplier_details($id);
        $data['supplier_types'] = $this->setup_model->supplier_types();

        $data['request'] = "edit_supplier_details";
        $this->load->view('body/modal_response', $data);
    }

    public function create_update_supplier()
    {

        $data = $this->input->post(NULL, TRUE);

        if ($data['action'] == "create") {

            $exist = $this->setup_model->exist_supplier($data['supplier'])['exist'];
            if ($exist > 0) {
                die("exist");
            }

            $create = $this->setup_model->create_supplier($data);
            die("create");
        } else {
            $update = $this->setup_model->update_supplier($data);
            die("update");
        }
    }

    public function supplier_status()
    {


        $data = $this->input->post(NULL, TRUE);

        $this->db->trans_start();
        $supplier = $this->setup_model->supplier_status($data);
        $supplier_user = $this->setup_model->supplier_user_status($data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("success");
    }

    public function supplier_account_list()
    {

        $fetch_data = $this->setup_model->supplier_account_list();

        $data = array();
        foreach ($fetch_data as $row) {
            $action =  '<i id="extend_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fa-calendar-plus text-success action" title="Renew Contract"></i>
                        <i id="cutoff_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fa-bookmark text-info action" title="Setup Cutoff"></i>';

            if ($row->status == 1) {

                $action .= '<i id="deactivate_' . $row->user_id . '" class="fa fa-lg fa-fw m-r-2 fa-times text-danger action" title="Click to deactivate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-success">' . $row->status . '</label>';
            } else {

                $action .= '<i id="activate_' . $row->user_id . '" class="fa fa-lg fa-fw m-r-2 fa-check text-success action" title="Click to activate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-danger">' . $row->status . '</label>';
            }

            $action .= '<i id="reset_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fas fa-undo-alt text-warning action" title="Reset Password"></i>';
            $action .= '<i id="update_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fa-edit text-primary action" title="Update Supplier Account"></i>';

            $sub_array = array();
            $sub_array[] = $row->supplier;
            $sub_array[] = $row->username;
            $sub_array[] = date('M. d, Y', strtotime($row->date_from)) . " - " . date('M. d, Y', strtotime($row->date_to));
            $sub_array[] = $row->status == 1 ? "<label class='btn btn-xs btn-block btn-success'>active</label>" : "<label class='btn btn-xs btn-block btn-danger'>inactive</label>";
            $sub_array[] = $row->first_login != null ? "yes" : "no";
            $sub_array[] = $action;
            $sub_array[] = $row->address;
            $sub_array[] = $row->email_address;
            $sub_array[] = $row->telephone;
            $sub_array[] = $row->cellphone;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function consignor_account_list()
    {

        $fetch_data = $this->setup_model->consignor_account_list();

        $data = array();
        foreach ($fetch_data as $row) {
            $action =  '<i id="extend_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fa-calendar-plus text-success action" title="Renew Contract"></i>';

            if ($row->status == 1) {

                $action .= '<i id="deactivate_' . $row->user_id . '" class="fa fa-lg fa-fw m-r-2 fa-times text-danger action" title="Click to deactivate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-success">' . $row->status . '</label>';
            } else {

                $action .= '<i id="activate_' . $row->user_id . '" class="fa fa-lg fa-fw m-r-2 fa-check text-success action" title="Click to activate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-danger">' . $row->status . '</label>';
            }

            $action .= '<i id="update_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fa-edit text-primary action" title="Update Consignor Account"></i>';
            $action .= '<i id="reset_' . $row->supplier_id . '_' . $row->user_id . '" class="far fa-lg fa-fw m-r-2 fas fa-undo-alt text-warning action" title="Reset Password"></i>';
            $sub_array = array();
            $sub_array[] = $row->supplier;
            $sub_array[] = $row->username;
            $sub_array[] = date('M. d, Y', strtotime($row->date_from)) . " - " . date('M. d, Y', strtotime($row->date_to));
            $sub_array[] = $row->status == 1 ? "<label class='btn btn-xs btn-block btn-success'>active</label>" : "<label class='btn btn-xs btn-block btn-danger'>inactive</label>";
            $sub_array[] = $row->first_login != null ? "yes" : "no";
            $sub_array[] = $action;
            $sub_array[] = $row->address;
            $sub_array[] = $row->email_address;
            $sub_array[] = $row->telephone;
            $sub_array[] = $row->cellphone;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function add_supplier_account()
    {

        $data['supplier'] = $this->setup_model->active_supplier_list();

        $data['request'] = "add_supplier_account";
        $this->load->view('body/modal_response', $data);
    }

    public function setup_supplier()
    {

        $id = $this->input->post('id', TRUE);
        $supplier = $this->setup_model->supplier_details($id);

        if ($supplier->supplier_type == 1) {

            $data['alturas_agency'] = $this->setup_model->alturas_agency();
            $data['colonnade_agency'] = $this->setup_model->colonnade_agency();
        } else {

            $data['alturas_company'] = $this->setup_model->alturas_company();
            $data['colonnade_company'] = $this->setup_model->colonnade_company();
        }

        $data['supplier'] = $supplier;
        $data['year'] = date("Y");
        $data['request'] = "setup_supplier";
        $this->load->view('body/modal_response', $data);
    }

    public function setup_consignor()
    {
        $id = $this->input->post('id', TRUE);

        $data['vendor'] = $this->setup_model->vendor_list();
        $data['year'] = date("Y");
        $data['request'] = "setup_consignor";
        $this->load->view('body/modal_response', $data);
    }

    public function create_supplier_account()
    {

        $data = $this->input->post(NULL, TRUE);

        $exist = $this->setup_model->exist_supplier_username($data['username'])['exist'];
        if ($exist > 0) {
            die("exist");
        }

        $this->db->trans_start();
        $user_id = $this->setup_model->create_supplier_account($data);

        if ($data['supplier_type'] == 1) {

            if ($data['alturas_agency'] != 0) {

                $this->setup_model->create_alturas_ac_code($data, $user_id);
            }

            if ($data['colonnade_agency'] != 0) {
                $this->setup_model->create_colonnade_ac_code($data, $user_id);
            }
        } else {

            if ($data['alturas_company'] != 0) {
                $this->setup_model->create_alturas_ac_code($data, $user_id);
            }

            if ($data['colonnade_company'] != 0) {
                $this->setup_model->create_colonnade_ac_code($data, $user_id);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("created");
    }

    public function create_consignor_account()
    {
        $data = $this->input->post(NULL, TRUE);
        $exist = $this->setup_model->exist_supplier_username($data['username'])['exist'];
        if ($exist > 0) {
            die("exist");
        }

        $this->db->trans_start();
        $user_id = $this->setup_model->create_supplier_account($data);

        // $vendor_ids = explode(",", $data['vendor_ids']);
        $this->setup_model->delete_tag_vendor($data['supplier']);
        foreach ($data['vendor_id'] as $key => $id) {

            $vendor = $this->setup_model->vendor_details($id);
            $this->setup_model->create_tbl_supplier_code($data['supplier'], $vendor);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("created");
    }

    public function supplier_user_status()
    {
        $data = $this->input->post(NULL, TRUE);
        $status = $this->setup_model->supplier_status_account($data);
        die("success");
    }

    public function supplier_reset_password()
    {
        $id = $this->input->post('id', TRUE);
        $status = $this->setup_model->supplier_reset_password($id);
        die("success");
    }

    public function renew_contract()
    {

        $data = $this->input->post(NULL, TRUE);
        $data['contract'] = $this->setup_model->fetch_contract($data['id']);
        $data['request'] = "renew_contract";

        $this->load->view('body/modal_response', $data);
    }

    public function renew_supplier_contract()
    {

        $data = $this->input->post(NULL, TRUE);

        $this->db->trans_start();
        $history = $this->setup_model->insert_supplier_contract_history($data);
        $current = $this->setup_model->update_supplier_contract($data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("success");
    }

    public function edit_tag_ac()
    {

        $fetch_data = $this->input->get(NULL, TRUE);

        $supplier = $this->setup_model->supplier_details($fetch_data['supplier_id']);

        if ($supplier->supplier_type == 1) {

            $data['alturas_agency'] = $this->setup_model->alturas_agency();
            $data['colonnade_agency'] = $this->setup_model->colonnade_agency();
        } else {

            $data['alturas_company'] = $this->setup_model->alturas_company();
            $data['colonnade_company'] = $this->setup_model->colonnade_company();
        }

        $data['supplier'] = $supplier;
        $data['alturas_code'] = $this->setup_model->fetch_alturas_ac($fetch_data['id']);
        $data['colonnade_code'] = $this->setup_model->fetch_colonnade_ac($fetch_data['id']);

        if ($data['alturas_code'] === null) {
            $data['alturas_code'] = (object) [
                'agency_code' => 0,
                'company_code' => 0
            ];
        }

        if ($data['colonnade_code'] === null) {
            $data['colonnade_code'] = (object) [
                'agency_code' => 0,
                'company_code' => 0
            ];
        }

        $data['user_id'] = $fetch_data['id'];
        $data['request'] = "edit_tag_ac";

        $this->load->view('body/modal_response', $data);
    }

    public function edit_tag_vendor()
    {
        $fetch_data = $this->input->get(NULL, TRUE);

        $supplier_vendors = $this->setup_model->get_supplier_code($fetch_data['supplier_id']);
        $vendor_code = array();
        foreach ($supplier_vendors as $sv) {

            array_push($vendor_code, $sv->vendor_code);
        }

        $data['vendors'] = $this->setup_model->vendor_list();
        $data['vendor_code'] = $vendor_code;

        $supplier = $this->setup_model->supplier_details($fetch_data['supplier_id']);
        $data['supplier'] = $supplier;
        $data['user_id'] = $fetch_data['id'];
        $data['request'] = "edit_tag_vendor";

        $this->load->view('body/modal_response', $data);
    }

    function update_supplier_account()
    {

        $data = $this->input->post(NULL, TRUE);

        $this->db->trans_start();
        if ($data['supplier_type'] == 1) {

            if ($data['alturas_agency'] != 0) {

                $this->setup_model->update_alturas_ac_code($data);
            }

            if ($data['colonnade_agency'] != 0) {
                $this->setup_model->update_colonnade_ac_code($data);
            }
        } else {

            if ($data['alturas_company'] != 0) {
                $this->setup_model->update_alturas_ac_code($data);
            }

            if ($data['colonnade_company'] != 0) {
                $this->setup_model->update_colonnade_ac_code($data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("success");
    }

    public function update_consignor_account()
    {
        $data = $this->input->post(NULL, TRUE);

        $this->db->trans_start();

        $this->setup_model->delete_tag_vendor($data['supplier_id']);
        foreach ($data['editvendor_id'] as $key => $id) {

            $vendor = $this->setup_model->vendor_details($id);
            $this->setup_model->create_tbl_supplier_code($data['supplier_id'], $vendor);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            die("error");
            // generate an error... or use the log_message() function to log your error
        }
        die("success");
    }

    public function fetch_user_account()
    {

        $fetch_data = $this->setup_model->users_account();

        $data = array();
        foreach ($fetch_data as $row) {

            if ($row->agency_code != 0) {

                $supplier = $this->setup_model->get_supplier('agency_name', 'promo_locate_agency', 'agency_code', $row->agency_code)['agency_name'];
            } else {

                $supplier = $this->setup_model->get_supplier('company_name', 'promo_locate_company', 'company_code', $row->company_code)['company_name'];
            }

            $date_time = $row->date_create . ' ' . $row->time_create;
            $action =  '<i id="extend_' . $row->userId . '" class="far fa-lg fa-fw m-r-2 fa-calendar-plus text-success extend_user" title="Renew Contract"></i>
                        <i id="cutoff_' . $row->userId . '" class="far fa-lg fa-fw m-r-2 fa-bookmark text-info setup_cutoff" title="Setup Cutoff"></i>
                        <i id="delete_' . $row->userId . '" class="far fa-lg fa-fw m-r-2 fa-trash-alt text-danger delete_user" title="Delete Account"></i>';

            $sub_array = array();
            $sub_array[] = $supplier;
            $sub_array[] = $row->username;
            $sub_array[] = $row->password;
            $sub_array[] = date('m/d/Y h:i A', strtotime($date_time));
            $sub_array[] = $row->status;
            $sub_array[] = $row->login;
            $sub_array[] = $action;
            $sub_array[] = date('m/d/Y', strtotime($row->dateFrom));
            $sub_array[] = date('m/d/Y', strtotime($row->dateTo));
            $sub_array[] = $row->ext_days;
            $sub_array[] = $row->address;
            $sub_array[] = $row->email_address;
            $sub_array[] = $row->telephone;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function delete_user()
    {

        $fetch = $this->input->post('userId', TRUE);

        $delete = $this->setup_model->delete_user($fetch);
        if ($delete) {
            die("success");
        }
    }

    public function extend_contract()
    {

        $data['userId'] = $this->input->post('userId', TRUE);

        $data['request'] = "extend_contract";
        $this->load->view('body/modal_response', $data);
    }

    public function submit_contract()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $insert = $this->setup_model->insert_contract_history($fetch);
        if ($insert) {

            $update = $this->setup_model->update_contract($fetch);
            if ($update) {
                die("success");
            }
        }
    }

    public function setup_cutoff()
    {

        $data['supplier_id'] = $this->input->post('supplier_id', TRUE);

        $data['request'] = "setup_cutoff";
        $this->load->view('body/modal_response', $data);
    }

    public function insertAll_com_cut()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $co = explode("|", $fetch['list_co']);
        for ($i = 0; $i < count($co) - 1; $i++) {

            $insert = $this->setup_model->insertAll_com_cut($fetch['supplier_id'], $co[$i]);
        }

        die("success");
    }

    public function deleteAll_com_cut()
    {

        $supplier_id = $this->input->post('supplier_id', TRUE);

        $delete = $this->setup_model->deleteAll_com_cut($supplier_id);
        if ($delete) {

            die("success");
        }
    }

    public function insert_com_cut()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $insert = $this->setup_model->insert_com_cut($fetch);
        if ($insert) {
            die("success");
        }
    }

    public function delete_com_cut()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $delete = $this->setup_model->delete_com_cut($fetch);
        if ($delete) {
            die("success");
        }
    }

    public function create_account()
    {

        $data['request'] = "create_account";
        $this->load->view('body/modal_response', $data);
    }

    public function create_account_form()
    {

        $data['account_form'] = $this->input->post("account_form", TRUE);

        $data['request'] = "create_account_form";
        $this->load->view('body/modal_response', $data);
    }

    public function submit_account()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $chk_exist = $this->setup_model->check_userpass($fetch['username'], $fetch['password']);

        if ($chk_exist == 0) {

            $userId = $this->setup_model->get_userId()['userId'] + 1;
            $password = md5($fetch['password']);

            if ($fetch['account_form'] == "with_agency") {

                $insert = $this->setup_model->insert_agency_user($fetch, $userId, $password);
                if ($insert) {

                    $list_com = $this->setup_model->com_under_agency($fetch['agency']);
                    foreach ($list_com as $com) {

                        $insert_com = $this->setup_model->insert_user_company($userId, $com->company_code);
                    }

                    die("success");
                } else {

                    die("failure");
                }
            } else {

                $company_code = $this->setup_model->insert_locate_com($fetch['agency'], $fetch['company']);

                $insert = $this->setup_model->insert_company_user($fetch, $userId, $password, $company_code);
                if ($insert) {

                    $insert_com = $this->setup_model->insert_user_company($userId, $company_code);
                    if ($insert_com) {

                        die("success");
                    } else {

                        die("failure");
                    }
                } else {

                    die("failure");
                }
            }
        } else {

            die("exist");
        }
    }

    public function com_for_agency()
    {

        $agencies = $this->setup_model->list_of_agencies();
        $data = array();
        foreach ($agencies as $agency) {

            $agency_code = $agency->agency_code;
            $agency_name = $agency->agency_name;

            $fetch_data = $this->setup_model->company_for_agency($agency_code);
            foreach ($fetch_data as $row) {

                $action =  '<i id="delete_' . $row->company_code . '" class="far fa-lg fa-fw m-r-2 fa-trash-alt text-danger delete_company"></i>';

                $sub_array = array();
                $sub_array[] = $agency_name;
                $sub_array[] = $row->company_name;
                $sub_array[] = $action;
                $data[] = $sub_array;
            }
        }

        echo json_encode(array("data" => $data));
    }

    public function delete_company()
    {

        $company_code = $this->input->post('company_code', TRUE);
        $delete = $this->setup_model->delete_company($company_code);
        if ($delete) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function submit_agency()
    {

        $agency_name = $this->input->post('agency_name', TRUE);

        $insert = $this->setup_model->insert_agency($agency_name);
        if ($insert) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function setupan_agency()
    {

        $data['setupan_agency'] = $this->input->post('setupan_agency', TRUE);

        $data['request'] = "setupan_agency";
        $this->load->view('body/modal_response', $data);
    }

    public function fetch_companies()
    {

        $agency_code = $this->input->post('setupan_agency', TRUE);
        $fetch_data = $this->setup_model->list_of_company();

        $data = array();
        foreach ($fetch_data as $row) {
            $chkCom = $this->setup_model->chk_locate_company($agency_code, $row->pc_name);

            if ($chkCom > 0) {

                $action =  '<input type="checkbox" name="chkCom[]" value="' . $row->pc_name . '" checked="">';
            } else {

                $action =  '<input type="checkbox" name="chkCom[]" value="' . $row->pc_name . '">';
            }

            $sub_array = array();
            $sub_array[] = $row->pc_name;
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function insert_update_locate_company()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $delete = $this->setup_model->delete_locate_company($fetch['agency_code']);
        if ($delete) {

            // $delete_user_com = $this->setup_model->delete_company_user($fetch['agency_code']);

            $chk = explode("|_", $fetch['newCHK']);

            for ($i = 0; $i < count($chk) - 1; $i++) {

                $this->setup_model->insert_locate_company($fetch['agency_code'], $chk[$i]);
            }

            die("success");
        } else {

            die("failure");
        }
    }

    public function fetch_users()
    {

        $fetch_data = $this->setup_model->list_of_users();

        $data = array();
        foreach ($fetch_data as $row) {
            $action =  '<i id="reset_' . $row->user_no . '" class="fa fa-lg fa-fw m-r-2 fa-redo-alt text-warning action" title="Reset password!"></i>';

            if ($row->status == "active") {

                $action .= '<i id="deactivated_' . $row->user_no . '" class="fa fa-lg fa-fw m-r-2 fa-times text-danger action" title="Click to deactivate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-success">' . $row->status . '</label>';
            } else {

                $action .= '<i id="activated_' . $row->user_no . '" class="fa fa-lg fa-fw m-r-2 fa-check text-success action" title="Click to activate account!"></i>';
                $status = '<label class="btn btn-xs btn-block btn-danger">' . $row->status . '</label>';
            }

            if ($_SESSION['adminId'] == "3") {

                $action .= '<i id="update_' . $row->user_no . '" class="fa fa-lg fa-fw m-r-2 fa-user-edit text-primary action" title="Update user account!"></i>';
            }

            $sub_array = array();
            $sub_array[] = $row->fullname;
            $sub_array[] = $row->username;
            $sub_array[] = $row->server_loc;
            $sub_array[] = $status;
            $sub_array[] = date('M. d, Y', strtotime($row->date_added));
            $sub_array[] = $action;
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function reset_password()
    {

        $userId = $this->input->post('userId', TRUE);
        $reset = $this->setup_model->reset_password($userId);
        if ($reset) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function user_status()
    {

        $fetch = $this->input->post(NULL, TRUE);
        $status = $this->setup_model->user_status($fetch);
        if ($status) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function submit_adminUser()
    {

        $fetch = $this->input->post(NULL, TRUE);
        $insert = $this->setup_model->insert_admin_user($fetch);
        if ($insert) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function add_adminUser()
    {

        $data['request'] = "add_adminUser";

        $this->load->view('body/modal_response', $data);
    }

    public function update_adminUser()
    {

        $data['user_no'] = $this->input->post('userId', TRUE);
        $data['request'] = "update_adminUser";

        $this->load->view('body/modal_response', $data);
    }

    public function submit_updated_userAdmin()
    {

        $fetch = $this->input->post(NULL, TRUE);
        $update = $this->setup_model->update_admin_user($fetch);
        if ($update) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function fetch_agency_list()
    {

        $fetch_data = $this->setup_model->list_of_agency();

        $data = array();
        $no = 1;
        foreach ($fetch_data as $row) {
            $action =  '<i id="update_' . $row->agency_code . '" class="fa fa-lg fa-edit text-primary update_agency" title="Update Agency"></i>&nbsp;';
            if ($_SESSION['adminId'] == 3) {

                $action .= '<i id="delete_' . $row->agency_code . '" class="fa fa-lg fa-trash-alt text-danger delete_agency" title="Delete Agency"></i>';
            }

            $sub_array = array();
            $sub_array[] = $no . ".";
            $sub_array[] = $row->agency_name;
            $sub_array[] = $action;
            $data[] = $sub_array;
            $no++;
        }

        echo json_encode(array("data" => $data));
    }

    public function delete_agency()
    {

        $fetch = $this->input->post('agency_code', TRUE);

        $delete = $this->setup_model->delete_agency($fetch);
        if ($delete) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function update_agency()
    {

        $data['agency_code'] = $this->input->post('agency_code', TRUE);
        $data['request'] = "update_agency";

        $this->load->view('body/modal_response', $data);
    }

    public function sub_updated_agency()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $update = $this->setup_model->update_agency($fetch);
        if ($update) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function fetch_company_list()
    {

        $fetch_data = $this->setup_model->list_of_company();

        $data = array();
        $no = 1;
        foreach ($fetch_data as $row) {
            $action =  '<i id="update_' . $row->pc_code . '" class="fa fa-lg fa-edit text-primary update_company" title="Update Company"></i>&nbsp;';
            if ($_SESSION['adminId'] == 3) {

                $action .= '<i id="delete_' . $row->pc_code . '" class="fa fa-lg fa-trash-alt text-danger delete_company" title="Delete Company"></i>';
            }

            $sub_array = array();
            $sub_array[] = $no . ".";
            $sub_array[] = $row->pc_name;
            $sub_array[] = $action;
            $data[] = $sub_array;
            $no++;
        }

        echo json_encode(array("data" => $data));
    }

    public function delete_companies()
    {

        $fetch = $this->input->post('pc_code', TRUE);

        $delete = $this->setup_model->delete_companies($fetch);
        if ($delete) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function sub_added_company()
    {

        $fetch = $this->input->post('company_name', TRUE);

        $insert = $this->setup_model->insert_company($fetch);
        if ($insert) {
            die("success");
        } else {

            die("failure");
        }
    }

    public function update_company()
    {

        $data['pc_code'] = $this->input->post('pc_code', TRUE);
        $data['request'] = "update_company";

        $this->load->view('body/modal_response', $data);
    }

    public function sub_updated_company()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $update = $this->setup_model->update_company($fetch);
        if ($update) {
            die("success");
        } else {

            die("failure");
        }
    }
}
