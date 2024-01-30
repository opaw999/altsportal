<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin_model');
    }

    public function submit_username() {

    	$fetch = $this->input->post(NULL, TRUE);

    	$chk = $this->admin_model->chk_ur_username($fetch['user_no'], $fetch['current_username']);
    	if ($chk > 0) {
    		
	    	$exist = $this->admin_model->chk_username($fetch['new_username']);
	    	if ($exist == 0) {
	    		
	    		$update = $this->admin_model->update_admin_username($fetch['user_no'], $fetch['new_username']);
	    		if ($update) {

	    			die("success");
	    		} else {

	    			die("failure");
	    		}
	    	} else {	

	    		die("exist");
	    	}
	    } else {

	    	die("mismatch");
	    }
    }

    public function submit_password() {

    	$fetch = $this->input->post(NULL, TRUE);

    	$chk = $this->admin_model->ur_password($fetch['user_no']);
    	if ($chk) {

    		if (password_verify($fetch['current_password'],$chk->password)) {
    			
    			$password = password_hash($fetch['new_password'],PASSWORD_DEFAULT);
    			$update = $this->admin_model->update_admin_password($fetch['user_no'], $password);
    			if ($update) {

    				die("success");
    			} else {

    				die("failure");
    			}
    		} else {

    			die("mismatch");
    		}
	    } else {

	    	die("failure");
	    }
    }
}