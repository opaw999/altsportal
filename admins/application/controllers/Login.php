<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

	public function authentication() {
		
		$fetch = $this->input->post(NULL, TRUE);

        // password_hash($fetch['password'],PASSWORD_DEFAULT);
    	$check_login = $this->login_model->check_user($fetch);
        if($check_login) {

            if (password_verify($fetch['password'],$check_login['password'])) {

                $data = array(
                    'adminId'    => $check_login['user_no'],
                    'admin_username'  => $check_login['username'],
                    'server'  => $check_login['server'],
                    'isUserLoggedIn' => TRUE
                );

                $this->session->set_userdata($data);
                
                die("success");
            }

        } else {

            die("failure");
        }
	}
}