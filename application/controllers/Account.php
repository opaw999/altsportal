<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('account_model');
    }

    public function basic_info() {

    	$data['userId'] = $this->input->post('userId', TRUE);
        $data['supplier_name'] = $this->input->post('supplier_name', TRUE);
    	$data['request'] = "basic_info";

    	$this->load->view('body/modal_response', $data);
    }

    public function change_username() {

    	$data['userId'] = $this->input->post('userId', TRUE);
    	$data['request'] = "change_username";

    	$this->load->view('body/modal_response', $data);
    }

    public function change_password() {

    	$data['userId'] = $this->input->post('userId', TRUE);
    	$data['request'] = "change_password";

    	$this->load->view('body/modal_response', $data);
    }

    public function submit_password() {

    	$fetch = html_escape($this->input->post(NULL, TRUE));
    	$password = $this->account_model->promo_supplier_user($fetch['userId'])['password'];

        if (password_verify($fetch['current_pass'], $password)) {
    		
    		if ($fetch['new_pass'] == $fetch['confirm_pass']) {
    			
    			$pass = $this->account_model->update_password($fetch['userId'],$fetch['new_pass']);
    			if ($pass) {
    				
    				die("success");
    			}
    		} else {

    			die("unmatched");
    		}

    	} else {

    		die("incorrect_password");
    	}
    }

    public function submit_username() {

    	$fetch = $this->input->post(NULL, TRUE);
    	$username = $this->account_model->promo_supplier_user($fetch['userId'])['username'];

    	if ($username == $fetch['current_username']) {
    		
    		if ($fetch['new_username'] == $fetch['confirm_username']) {
    			
    			$pass = $this->account_model->update_username($fetch['userId'],$fetch['new_username']);
    			if ($pass) {
    				
    				die("success");
    			}
    		} else {

    			die("unmatched");
    		}

    	} else {

    		die("incorrect_username");
    	}
    }

    public function submit_profile() {

    	$fetch = $this->input->post(NULL, TRUE);

    	$count = 0;
    	foreach ($fetch as $key => $value) {
    	    if (!empty($value)) {

    	       	$count++;
    	    } 
    	}

    	if ($count == 1) {
    	   
    	   	die("empty");
    	} else {

    		$profile = $this->account_model->update_profile($fetch);
    		if ($profile) {
    			
    			die("success");
    		}
    	}
    }

    public function changeProfilePic() {

        $data['userId'] = $this->input->post('userId', TRUE);
        $data['request'] = "changeProfilePic";

        $this->load->view('body/modal_response', $data);
    }

    public function getProfilePic() {

        $userId = $this->input->post('userId', TRUE);
        $photo = $this->account_model->company_basic_info($userId)['photo'];
        if ($photo == "") {
										
			$photo = "user-1.png";
		} 

		die($photo);
    }

    public function uploadProfilePic() {

        $fetch_data = $this->input->post(NULL, TRUE);
        $userId = $fetch_data['userId'];

        if(!empty($_FILES['profile']['name'])) {    

            $photo = $this->account_model->company_basic_info($userId)['photo'];
            // echo $photo;
            if ($photo != "") {
                
                unlink(FCPATH ."$photo");
            }

            $image      = addslashes(file_get_contents($_FILES['profile']['tmp_name']));
            $image_name = addslashes($_FILES['profile']['name']);   
            $array  = explode(".",$image_name); 
            
            $filename   = $userId."=".date('Y-m-d')."=".'Profile'."=".date('H-i-s-A').".".end($array);
            $destination_path   = "assets/img/user/".$filename; 

            if(move_uploaded_file($_FILES['profile']['tmp_name'], $destination_path)) {

                $profile = $this->account_model->update_photo($userId, $destination_path);
                if ($profile) {

                    die("success");
                }
            }   
        }

    }
}