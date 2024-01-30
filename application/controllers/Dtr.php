<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dtr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('dtr_model');
    }

    public function display_cutoff()
    {

        $cutoff = $this->input->post('cutoff', TRUE);

        $x = 0;
        $fetch_data = $this->dtr_model->display_1stcutoff($cutoff);
        $data = array();
        foreach ($fetch_data as $row) {

            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">' . $date_from . '</span>' . date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_' . $x . '" value="' . $cutoff . '">
    						<input type="hidden" id="cut_' . $x . '" value="1">
    						<input type="hidden" id="dateFrom_' . $x . '" value="' . $row->dateFrom . '">
    						<input type="hidden" id="dateTo_' . $x . '" value="' . $row->dateTo . '">
    						<a href="javascript:void(0);" id="' . $x . '" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array;
        }

        $fetch = $this->dtr_model->display_2ndcutoff($cutoff);
        foreach ($fetch as $row) {

            $x++;
            $date_from = strtotime($row->dateFrom);

            $sub_array = array();
            $sub_array[] = '<span style="display:none;">' . $date_from . '</span>' . date('M. d, Y', strtotime($row->dateFrom));
            $sub_array[] = date('M. d, Y', strtotime($row->dateTo));
            $sub_array[] = '<input type="hidden" id="cutoff_' . $x . '" value="' . $cutoff . '">
    						<input type="hidden" id="cut_' . $x . '" value="2">
    						<input type="hidden" id="dateFrom_' . $x . '" value="' . $row->dateFrom . '">
    						<input type="hidden" id="dateTo_' . $x . '" value="' . $row->dateTo . '">
    						<a href="javascript:void(0);" id="' . $x . '" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
            $data[] = $sub_array;
        }

        echo json_encode(array("data" => $data));
    }

    public function cutoff()
    {

        $fetch = $this->input->post(NULL, TRUE);

        echo date('M. d, Y', strtotime($fetch['dateFrom'])) . " - " . date('M. d, Y', strtotime($fetch['dateTo']));
    }

    public function employee_list()
    {

        $data['fetch'] = $this->input->post(NULL, TRUE);
        $data['alturas'] = $this->dtr_model->supplier_ac_code("alturas");
        $data['colonnade'] = $this->dtr_model->supplier_ac_code("colonnade");

        $data['request'] = "employee_list";
        $this->load->view('body/modal_response', $data);
    }

    public function view_employee_list()
    {
        $fetch = $this->input->post(NULL, TRUE);

        $supplier_type = $this->dtr_model->supplier_type()['supplier_type'];
        if ($fetch['server'] == "colonnade") {

            $pis = "pis_colonnade";
            $tk  = "tk_colonnade";

            $colonnade_code = $this->dtr_model->supplier_ac_code('colonnade');
            // if supplier type = 1, supplier is agency else supplier is company
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
            // if supplier type = 1, supplier is agency else supplier is company
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
            // get store name
            $storeName = "";
            $ctr = 0;
            $bunit = "SELECT bunit_field, bunit_name FROM locate_promo_business_unit";
            $business = $this->dtr_model->return_data_result_array($pis, $bunit);
            foreach ($business as $str) {

                $promo = "SELECT promo_id FROM promo_record WHERE " . $str['bunit_field'] . " = 'T' AND emp_id = '" . $emp->emp_id . "' AND record_no = '" . $emp->record_no . "'";
                if ($this->dtr_model->return_data_num_rows($pis, $promo) > 0) {

                    if ($ctr == 0) {

                        $storeName = $str['bunit_name'];
                    } else {

                        $storeName .= ", " . $str['bunit_name'];
                    }
                    $ctr++;
                }
            }

            // $pd = $this->dtr_model->promo_details($pis, $emp->emp_id, $emp->record_no);
            // $ed = $this->dtr_model->employee_details($pis, $emp->emp_id, $emp->record_no);

            $query = "SELECT assignId, bioMetricId, barcodeId, allowId FROM assign WHERE empId = '" . $emp->emp_id . "' ORDER BY assignId DESC LIMIT 1";
            $res = $this->dtr_model->return_data_row_array($tk, $query);

            if (is_array($res)) {

                $bioId = $res['allowId'];
                if ($bioId == 'Logbox ID') {

                    $id = $res['barcodeId'];
                } else {

                    $id = @$res['biometricId'];
                }

                $sub_array = array();
                $sub_array[] = ucwords(strtolower($emp->name));
                $sub_array[] = $emp->promo_company;
                $sub_array[] = $storeName;
                $sub_array[] = ucwords(strtolower($emp->position));
                $sub_array[] = ucwords(strtolower($emp->promo_type));
                $sub_array[] = '<a href="javascript:void(0);" class="print_dtr" id="' . $emp->emp_id . '" title="View DTR"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
                $sub_array[] = '<input class="chkC chk_' . $fetch['cutoff'] . '" name="chkEmpId[]" value="' . $id . '" type="checkbox" onclick="chk(' . $fetch['cutoff'] . ')">';
                $data[] = $sub_array;
            } else {

                $sub_array = array();
                $sub_array[] = ucwords(strtolower($emp->name));
                $sub_array[] = $emp->promo_company;
                $sub_array[] = $storeName;
                $sub_array[] = ucwords(strtolower($emp->position));
                $sub_array[] = ucwords(strtolower($emp->promo_type));
                $sub_array[] = '';
                $sub_array[] = '';
                $data[] = $sub_array;
            }
        }

        echo json_encode(array("data" => $data));
    }

    public function view_dtr()
    {

        $data['fetch'] = $this->input->post(NULL, TRUE);
        $data['request'] = "view_dtr";

        $this->load->view('body/modal_response', $data);
    }

    public function vTEntry()
    {

        $data['fetch'] = $this->input->post(NULL, TRUE);
        $data['request'] = "vTEntry";

        $this->load->view('body/modal_response', $data);
    }
}
