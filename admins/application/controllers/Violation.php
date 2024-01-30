<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Violation extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('violation_model');
    }

    public function display_cutoff() {

    	$cutoff = $this->input->post('cutoff', TRUE);

    	$x = 0;
    	$fetch_data = $this->violation_model->display_1stcutoff($cutoff);
    	$data = array();
    	foreach ($fetch_data as $row) {
    		
    		$x++;
    		$date_from = strtotime($row->dateFrom);
    		
    		$sub_array = array();
    		$sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
    		$sub_array[] = date('M. d, Y', strtotime($row->dateTo));
    		$sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
    						<input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
    						<input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
    						<a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
    		$data[] = $sub_array; 
    	}

    	$fetch = $this->violation_model->display_2ndcutoff($cutoff);
    	foreach ($fetch as $row) {
    		
    		$x++;
    		$date_from = strtotime($row->dateFrom);
    		
    		$sub_array = array();
    		$sub_array[] = '<span style="display:none;">'.$date_from.'</span>'.date('M. d, Y', strtotime($row->dateFrom));
    		$sub_array[] = date('M. d, Y', strtotime($row->dateTo));
    		$sub_array[] = '<input type="hidden" id="cutoff_'.$x.'" value="'.$cutoff.'">
    						<input type="hidden" id="dateFrom_'.$x.'" value="'.$row->dateFrom.'">
    						<input type="hidden" id="dateTo_'.$x.'" value="'.$row->dateTo.'">
    						<a href="javascript:void(0);" id="'.$x.'" class="record"><i class="fa fa-fw fa-list txt-color-blue hidden-md"></i></a>';
    		$data[] = $sub_array; 
    	}

    	echo json_encode(array("data" => $data));
    }

    public function cutoff() {

    	$fetch = $this->input->post(NULL, TRUE);

    	echo date('M. d, Y', strtotime($fetch['dateFrom']))." - ".date('M. d, Y', strtotime($fetch['dateTo']));
    }

    public function employee_list() {

    	$data['fetch'] = $this->input->post(NULL, TRUE);

    	$data['request'] = "employee_list";
    	$this->load->view('body/modal_response', $data);
    }

    public function company_list() {

        $data['fetch'] = $this->input->post(NULL, TRUE);

        $data['request'] = "company_list";
        $this->load->view('body/modal_response', $data);
    }

    public function view_employee_list() {

    	$fetch = $this->input->post(NULL, TRUE);

        if ($fetch['server'] == "colonnade") {

            $pis = "pis_colonnade";
            $tk  = "tk_colonnade";
            
            $employees = $this->violation_model->promo_list($fetch);

        } else {

            $pis = "pis";

            if ($fetch['server'] == "talibon") {
                $tk = "tk_talibon";
            } else if ($fetch['server'] == "tubigon") {
                $tk = "tk_tubigon";
            } else {
                $tk = "timekeeping";
            }

            $employees = $this->violation_model->promo_list($fetch);
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
            $ed = $this->violation_model->employee_details($pis, $emp->emp_id, $emp->record_no);

            $check_violation = $this->violation_model->promo_violation($pis, $emp->emp_id, $fetch);

            $action .= '<a href="javascript:void(0);" class="upload_violation" id="upload_'.$emp->emp_id.'" title="Upload Violation"><img src="'.base_url().'/assets/img/icon/upload.png" width="20px;"></img></a> &nbsp;';
            
            if ($check_violation->exist > 0) {

                $action .= '<a href="javascript:void(0);" class="view_violation" id="view_'.$emp->emp_id.'" title="View Violation"><img src="'.base_url().'/assets/img/icon/folder.png" width="20px;"></img></a>';
            } else {

                $action .= '<a href="javascript:void(0);" title="No Uploaded Violation"><img src="'.base_url().'/assets/img/icon/no folder.png" width="20px;"></img></a>';
            }

            if (!empty($ed)) {
                
                $sub_array = array();
                $sub_array[] = ucwords(strtolower($emp->name));
                $sub_array[] = $pd->promo_company;
                $sub_array[] = $storeName;
                $sub_array[] = ucwords(strtolower($emp->position));
                $sub_array[] = ucwords(strtolower($pd->promo_type));
                $sub_array[] = $action;
                $data[] = $sub_array; 
            }
        }

        echo json_encode(array("data" => $data));
    }

    public function view_company_list() {

        $fetch = $this->input->post(NULL, TRUE);

        if ($fetch['server'] == "colonnade") {

            $pis = "pis_colonnade";
            $companies = $this->violation_model->company_list($pis);

        } else {

            $pis = "pis";
            $companies = $this->violation_model->company_list($pis);
        }

        $data = array();
        foreach ($companies as $row) {

            $action = "";

            $check_violation = $this->violation_model->promo_violation($pis, $row->pc_code, $fetch);
            $action .= '<a href="javascript:void(0);" class="upload_violation" id="upload_'.$row->pc_code.'" title="Upload Violation"><img src="'.base_url().'/assets/img/icon/upload.png" width="20px;"></img></a> &nbsp;';
            
            if ($check_violation->exist > 0) {

                $action .= '<a href="javascript:void(0);" class="view_violation" id="view_'.$row->pc_code.'" title="View Violation"><img src="'.base_url().'/assets/img/icon/folder.png" width="20px;"></img></a>';
            } else {

                $action .= '<a href="javascript:void(0);" title="No Uploaded Violation"><img src="'.base_url().'/assets/img/icon/no folder.png" width="20px;"></img></a>';
            }
            
            $sub_array = array();
            $sub_array[] = $row->pc_name;
            $sub_array[] = $action;
            $data[] = $sub_array; 
        }

        echo json_encode(array("data" => $data));
    }

    public function upload_violation_form() {

        $fetch = $this->input->post(NULL, TRUE);

        $data['fetch'] = $fetch;
        $data['supplier'] = $this->violation_model->company_with_agency($fetch);
        $data['request'] = "upload_violation_form";
        $this->load->view('body/modal_response', $data);
    }

    public function upload_violation() {

        $fetch = $this->input->post(NULL, TRUE);

        $path = "";
        if(!empty($_FILES['files']['name'])) {    

            $file = $_FILES['files']['name'];
            for ($i=0; $i < count($file); $i++) { 

                if(isset($file[$i]) && $file[$i] != ''){
                    
                    // File name
                    $filename = $file[$i];

                    // Get extension
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    // Valid image extension
                    $valid_ext = array("png","jpeg","jpg");

                    // Check extension
                    if(in_array($ext, $valid_ext)){
    
                        // File path
                        $path = "assets/img/violation/".$fetch['pc_code']."_".$fetch['dateFrom']."_".$fetch['dateTo']."_".date("YmdHis")."_".$i.".".$ext;

                        // Upload file
                        if(move_uploaded_file($_FILES['files']['tmp_name'][$i],FCPATH."".$path)){
                            
                            $violation = $this->violation_model->insert_promo_violation($path, $fetch);
                        }
                    }

                }
            }

            die("success");

        } else {

            die("fail");
        }
    }

    public function view_violation() {

        $fetch = $this->input->post(NULL, TRUE);

        $data['fetch'] = $fetch;
        $data['violation'] = $this->violation_model->get_promo_violation($fetch);
        $data['request'] = "view_violation";

        $this->load->view('body/modal_response', $data);
    }

    public function view_image() {

        $id = $this->input->get('id', TRUE);
        $image = $this->violation_model->view_image($id);

        $data[] = [
            'image_path' => $image->image_path,
            'created_at' => date('F d, Y h:i A', strtotime($image->created_at))
        ];
        echo json_encode($data);
    }

    public function delete_violation() {

        $fetch = $this->input->post(NULL, TRUE);

        $violation = $this->violation_model->delete_violation($fetch['violation_id']);
        if($violation) {

            $no_violation = $this->violation_model->no_of_violation($fetch)['no_violation'];
            die($no_violation);
        }
    }
}