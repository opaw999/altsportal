<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 

        if (isset($_SESSION['adminId'])) {
            
            $this->load->model('email_model');
        	$this->load->model('setup_model');
        	$this->load->model('violation_model');
        } 
    }

	public function menu($menu = 'email', $submenu = 'email') {

		if (!isset($_SESSION['adminId'])) {
			
			$this->load->view('template/header_login');
	        $this->load->view('body/login/login');
	        $this->load->view('template/script'); 
	        $this->load->view('body/login/login_js');
		
		} else {
		
			if (!file_exists(APPPATH."views/body/$menu/$submenu.php")) {

		        $this->load->view('template/header_login');
		        $this->load->view('body/show_404');
		        $this->load->view('template/script'); 

			} else {

				$data['menu']  = html_escape($menu);
				$data['submenu']  = html_escape($submenu);

				if ($menu == "violation") {
					
					$data['cutoffs'] = $this->violation_model->list_of_cutoffs();
				}
		
				$this->load->view('template/header', $data);
				$this->load->view('template/menu', $data);
		        $this->load->view("body/$menu/$submenu", $data);
		        $this->load->view('template/script');
		        $this->load->view("body/$menu/".$menu."_js", $data);
		    }
		}
	}
}