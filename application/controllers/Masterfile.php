<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterfile extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('masterfile_model');
        $this->load->model('dtr_model');
    }

    public function view_masterfile() {

    	$fetch = $this->input->post(NULL, TRUE);

        $supplier_type = $this->dtr_model->supplier_type()['supplier_type'];
        if ($fetch['server'] == "colonnade") {

            $pis = "pis_colonnade";
            $tk  = "tk_colonnade";
            
            $colonnade_code = $this->dtr_model->supplier_ac_code('colonnade');
            if ($supplier_type == 1) {
                
                $agency_code = $colonnade_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('colonnade', $agency_code);
                $employees = $this->dtr_model->promo_masterfile_under_agency($fetch, $companies);
            } else {

                $company_code = $colonnade_code->company_code;
                $company_name = $this->dtr_model->company_name('colonnade', $company_code)['pc_name'];
                $employees = $this->dtr_model->promo_masterfile_under_company($fetch, $company_name);
            }

        } else {

            $pis = "pis";

            if ($fetch['server'] == "talibon") {
                $tk = "tk_talibon";
            } else if ($fetch['server'] == "tubigon") {
                $tk = "tk_tubigon";
            } else {
                $tk = "duxvwc44_altstk";
            }

            $alturas_code = $this->dtr_model->supplier_ac_code('alturas');
            if ($supplier_type == 1) {
                
                $agency_code = $alturas_code->agency_code;
                $companies = $this->dtr_model->companies_under_agency('alturas', $agency_code);
                $employees = $this->dtr_model->promo_masterfile_under_agency($fetch, $companies);
            } else {

                $company_code = $alturas_code->company_code;
                $company_name = $this->dtr_model->company_name('alturas', $company_code)['pc_name'];
                $employees = $this->dtr_model->promo_masterfile_under_company($fetch, $company_name);
            }
        }
        
        $data = array();
        foreach ($employees as $emp) {

        	$cut = $this->masterfile_model->get_cutoff($tk, $emp->statCut);
    		if ($cut['endFC'] == '') {
    		  	
    		  	$endFC = "last";

    		} else {
    		  
    		  	$endFC = $cut['endFC'];   
    		}
    		$cut_off = $cut['startFC']."-".$endFC." / ".$cut['startSC']."-".$cut['endSC'];

    		// get store name
            $storeName = "";
            $ctr = 0;
            $bunit = "SELECT bunit_field, bunit_name FROM locate_promo_business_unit";
            $business = $this->dtr_model->return_data_result_array($pis, $bunit);

            foreach ($business as $str) {
            
                $promo = "SELECT promo_id FROM promo_record WHERE ".$str['bunit_field']." = 'T' AND emp_id = '".$emp->emp_id."' AND record_no = '".$emp->record_no."'";
                if($this->dtr_model->return_data_num_rows($pis, $promo) > 0) {

                    if($ctr == 0){
    
                        $storeName = $str['bunit_name'];
                    } else {
    
                        $storeName .= ", ".$str['bunit_name'];
                    }
                    $ctr++;
                }
            }

    		$sub_array = array();
			$sub_array[] = ucwords(strtolower($emp->name));
			$sub_array[] = $emp->promo_company;
			$sub_array[] = $storeName;
			$sub_array[] = ucwords(strtolower($emp->position));
			$sub_array[] = ucwords(strtolower($emp->promo_type));
			$sub_array[] = $cut_off;
			$sub_array[] = '<a href="javascript:void(0);" class="schedule" id="'.$emp->emp_id.'" title="View Schedule"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
			$data[] = $sub_array;
		}

		echo json_encode(array("data" => $data));
    }

	public function view_schedule() {

		$data['fetch'] = $this->input->post(NULL, TRUE);

		$data['request'] = "view_schedule";
		$this->load->view('body/modal_response', $data);
	}

	public function view_sched() {

		$data['fetch'] = $this->input->post(NULL, TRUE);

		$data['request'] = "view_sched";
		$this->load->view('body/modal_response', $data);
	}
}
