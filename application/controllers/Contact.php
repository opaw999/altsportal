<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__DIR__).'/utils/Pusher.php';


class Contact extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('contact_model');
    }

	public function submit_message() {
		
		$fetch = $this->input->post(NULL, TRUE);
		$message = $this->contact_model->submit_message($fetch);

		$pusher = new Pusher();

		if ($message) {
			
			$pusher->broadcast('supplier-channel', 'supplier-event', $message);
			die("success");
		}
	}

	public function auth_user() {

		$pusher = new Pusher();

		if ($_POST['channel_name'] == "private-admin-channel-".$_SESSION['supplier_id']) {
		
	        $socket_id 	= $_POST['socket_id'];
	        $channel 	= $_POST['channel_name'];

	        $string_to_sign = "$socket_id:$channel";
	        $secret = "ff1f638d357e0d19019c";
	        $signature = hash_hmac('sha256', $string_to_sign, $secret);

	        echo json_encode(array('auth' => "b49163b6de1bae4c1c2f:$signature"));
	    }
    }
}
