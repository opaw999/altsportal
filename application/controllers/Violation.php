<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Violation extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('violation_model');
        $this->load->model('dtr_model');
    }

    public function company_list() {

        $data['fetch'] = $this->input->post(NULL, TRUE);
        $data['alturas'] = $this->dtr_model->supplier_ac_code("alturas");
        $data['colonnade'] = $this->dtr_model->supplier_ac_code("colonnade");

        $data['request'] = "company_list";
        $this->load->view('body/modal_response', $data);
    }

    public function emp_violation_list() {

        $data['fetch'] = $this->input->post(NULL, TRUE);
        $data['alturas'] = $this->dtr_model->supplier_ac_code("alturas");
        $data['colonnade'] = $this->dtr_model->supplier_ac_code("colonnade");

        $data['request'] = "emp_violation_list";
        $this->load->view('body/modal_response', $data);
    }

    public function view_employee_list() {

        $fetch = $this->input->post(NULL, TRUE);

        $supplier_type = $this->dtr_model->supplier_type()['supplier_type'];
        if ($fetch['server'] == "colonnade") {

            $pis = "pis_colonnade";
            $tk  = "tk_colonnade";
            
            $colonnade_code = $this->dtr_model->supplier_ac_code('colonnade');
            if ($supplier_type == 1) {
                
                $agency_code = $colonnade_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('colonnade', $agency_code);
                $employees = $this->dtr_model->promo_under_agency($fetch, $companies, $agency_code);
            } else {

                $company_code = $colonnade_code->company_code;
                $company_name = $this->dtr_model->company_name('colonnade', $company_code)['pc_name'];
                $employees = $this->dtr_model->promo_under_company($fetch, $company_name);
            }

        } else {

            $pis = "pis";

            if ($fetch['server'] == "talibon") {
                $tk = "tk_talibon";
            } else if ($fetch['server'] == "tubigon") {
                $tk = "tk_tubigon";
            } else {
                $tk = "timekeeping";
            }

            $alturas_code = $this->dtr_model->supplier_ac_code('alturas');
            if ($supplier_type == 1) {
                
                $agency_code = $alturas_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('alturas', $agency_code);
                $employees = $this->dtr_model->promo_under_agency($fetch, $companies, $agency_code);
            } else {

                $company_code = $alturas_code->company_code;
                $company_name = $this->dtr_model->company_name('alturas', $company_code)['pc_name'];
                $employees = $this->dtr_model->promo_under_company($fetch, $company_name);
            }
        }
        
        $data = array();
        foreach ($employees as $emp) {

            $action = "";

            // get store name
            $storeName = "";
            $ctr = 0;
            $bunit = "SELECT bunit_field, bunit_name FROM locate_promo_business_unit";
            $business = $this->violation_model->return_data_result_array($pis, $bunit);
            foreach ($business as $str) {
            
                $promo = "SELECT promo_id, promo_company, promo_type FROM promo_record WHERE ".$str['bunit_field']." = 'T' AND emp_id = '".$emp->emp_id."' AND record_no = '".$emp->record_no."'";
                if($this->violation_model->return_data_num_rows($pis, $promo) > 0) {

                    if($ctr == 0){
    
                        $storeName = $str['bunit_name'];

                    } else {
    
                        $storeName .= ", ".$str['bunit_name'];
                    }
                    $ctr++;
                }
            }
            
            $pd = $this->violation_model->promo_details($pis, $emp->emp_id, $emp->record_no);
            $check_violation = $this->violation_model->promo_violation($emp->emp_id, $fetch);

            if ($check_violation->exist > 0) {

                $action .= '<a href="javascript:void(0);" class="view_emp_violation" id="view_'.$emp->emp_id.'" title="View Violation"><img src="'.base_url().'/assets/img/icon/folder.png" width="20px;"></img></a>';
            } else {

                $action .= '<a href="javascript:void(0);" title="No Uploaded Violation"><img src="'.base_url().'/assets/img/icon/no folder.png" width="20px;"></img></a>';
            }

            $sub_array = array();
            $sub_array[] = ucwords(strtolower($emp->name));
            $sub_array[] = $pd->promo_company;
            $sub_array[] = $storeName;
            $sub_array[] = ucwords(strtolower($emp->position));
            $sub_array[] = ucwords(strtolower($pd->promo_type));
            $sub_array[] = $action;
            $data[] = $sub_array; 
        }

        echo json_encode(array("data" => $data));
    }

    public function view_company_list() {

        $fetch = $this->input->post(NULL, TRUE);

        $supplier_type = $this->dtr_model->supplier_type()['supplier_type'];
        if ($fetch['server'] == "colonnade") {
            
            $colonnade_code = $this->dtr_model->supplier_ac_code('colonnade');
            if ($supplier_type == 1) {
                
                $agency_code = $colonnade_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('colonnade', $agency_code);
            } else {

                $company_code = $colonnade_code->company_code;
                $companies = $this->dtr_model->company_name('alturas', $company_code);
            }

        } else {

            $alturas_code = $this->dtr_model->supplier_ac_code('alturas');
            if ($supplier_type == 1) {
                
                $agency_code = $alturas_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('alturas', $agency_code);
            } else {

                $company_code = $alturas_code->company_code;
                $companies = $this->dtr_model->company_name('alturas', $company_code);
            }
        }
        
        $data = array();
        if ($supplier_type == 1) {
            
            foreach ($companies as $row) {

                $action = "";
                $company = base64_encode($row->company_name);
                $id = base64_encode($row->company_name.'|'.$agency_code);

                $check_violation = $this->violation_model->promo_violation_agency($agency_code, $company, $fetch);
                if ($check_violation->exist > 0) {

                    $action .= '<a href="javascript:void(0);" class="view_violation" id="view_'.$id.'" title="View Violation"><img src="'.base_url().'/assets/img/icon/folder.png" width="20px;"></img></a>';
                } else {

                    $action .= '<a href="javascript:void(0);" title="No Uploaded Violation"><img src="'.base_url().'/assets/img/icon/no folder.png" width="20px;"></img></a>';
                }

                $sub_array = array();
                $sub_array[] = $row->company_name;
                $sub_array[] = $action;
                $data[] = $sub_array; 
            }

        } else {

                $action = "";
                $company = base64_encode($companies['pc_name']);
                $id = base64_encode($companies['pc_name'].'|');
                
                $check_violation = $this->violation_model->promo_violation_company($company, $fetch);
                if ($check_violation->exist > 0) {

                    $action .= '<a href="javascript:void(0);" class="view_violation" id="view_'.$id.'" title="View Violation"><img src="'.base_url().'/assets/img/icon/folder.png" width="20px;"></img></a>';
                } else {

                    $action .= '<a href="javascript:void(0);" title="No Uploaded Violation"><img src="'.base_url().'/assets/img/icon/no folder.png" width="20px;"></img></a>';
                }

                $sub_array = array();
                $sub_array[] = $companies['pc_name'];
                $sub_array[] = $action;
                $data[] = $sub_array; 

        }
        
        echo json_encode(array("data" => $data));
    }

    public function view_violation() {

        $fetch = $this->input->post(NULL, TRUE);

        $data['fetch'] = $fetch;
        $data['violation'] = $this->violation_model->promo_violation_details($fetch);
        $data['request'] = "view_violation";

        $this->load->view('body/modal_response', $data);
    }

    public function view_company_violation()
    {
        $fetch = $this->input->post(NULL, TRUE);

        $data['fetch'] = $fetch;
        $data['violation'] = $this->violation_model->get_promo_violation($fetch);
        $data['request'] = "view_company_violation";

        $this->load->view('body/modal_response', $data);
    }

    public function view_image() {

        $fetch = $this->input->get(NULL, TRUE);
        $image = $this->violation_model->view_image($fetch);

        $data[] = [
            'image_path' => $image->image_path,
            'created_at' => date('F d, Y h:i A', strtotime($image->created_at))
        ];
        echo json_encode($data);
    }

    public function display_cutoff() {

        $cutoff = $this->input->post('cutoff', TRUE);

        $x = 0;
        $fetch_data = $this->dtr_model->display_1stcutoff($cutoff);
        $data = array();
        foreach ($fetch_data as $row) {
            
            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
                            <input type="hidden" id="cut_'.$x.'" value="1">
                            <input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
                            <input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
                            <a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array; 
        }

        $fetch = $this->dtr_model->display_2ndcutoff($cutoff);
        foreach ($fetch as $row) {
            
            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
                            <input type="hidden" id="cut_'.$x.'" value="2">
                            <input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
                            <input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
                            <a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array; 
        }

        echo json_encode(array("data" => $data));
    }

    public function display_supplier_cutoff() {

        $cutoff = $this->input->post('cutoff', TRUE);

        $x = 0;
        $fetch_data = $this->dtr_model->display_1stcutoff($cutoff);
        $data = array();
        foreach ($fetch_data as $row) {
            
            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
                            <input type="hidden" id="cut_'.$x.'" value="1">
                            <input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
                            <input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
                            <a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array; 
        }

        $fetch = $this->dtr_model->display_2ndcutoff($cutoff);
        foreach ($fetch as $row) {
            
            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
                            <input type="hidden" id="cut_'.$x.'" value="2">
                            <input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
                            <input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
                            <a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array; 
        }

        echo json_encode(array("data" => $data));
    }
}