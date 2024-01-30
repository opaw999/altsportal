<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('setup_model');
    }

    public function users_xls() {

    	$data['request'] = "users_xls";

    	$this->load->view('body/modal_response',$data);
    }
}