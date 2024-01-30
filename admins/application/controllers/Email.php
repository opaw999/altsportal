<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__DIR__).'/utils/Pusher.php';


class Email extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        
        $this->load->model('email_model');
    }

    public function view_message() {

    	$data['start'] = $this->input->post('previous',TRUE);
    	$data['request'] = 'view_message';
    	
    	$this->load->view('body/modal_response', $data);
    }

    public function delete_message() {

    	$fetch = explode("*", $this->input->post('newCHK', TRUE));

        for ($i=0; $i < sizeof($fetch) -1; $i++) { 
           
            $this->email_model->delete_message($fetch[$i]);
        }

        die("success");
    }

    public function view_details() {

    	$data['msgId'] = $this->input->post('msgId',TRUE);
    	$data['request'] = 'view_details';
    	
    	$this->load->view('body/modal_response', $data);
    }

    public function delete_this_msg() {

    	$msgId 	= $this->input->post('msgId', TRUE);
		$delete = $this->email_model->delete_message($msgId);

		if ($delete) {

        	die("success");
		} else {

			die("error");
		}
    }

    public function view_message_detail() {

    	$data['start'] = $this->input->post('row_position',TRUE);
    	$data['request'] = 'view_message_detail';
    	
    	$this->load->view('body/modal_response', $data);
    }

    public function count_unread_msg() {

    	echo $this->email_model->count_unread_msg();
    }

    public function count_total_msg() {

        echo $this->email_model->count_total_msg();
    }

    public function supplier_chat_messages() {

        $data['email'] = $this->email_model->supplier_chat_messages();
        $data['request'] = 'supplier_chat_messages';

        $this->load->view('body/modal_response', $data);
    }

    public function view_supplier_messages() {

        $id = $this->input->post('id', TRUE);
        $this->email_model->update_message($id);

        $data['user_id'] = $id;
        $data['messages'] = $this->email_model->view_supplier_messages($id);
        $data['request'] = 'view_supplier_messages';

        $this->load->view('body/modal_response', $data);
    }

    public function send_feedback() {

        $data = $this->input->post(NULL, TRUE);
        $feedback = $this->email_model->send_feedback($data);

        $pusher = new Pusher();
        if ($feedback) {

            $pusher->broadcast('private-admin-channel-'. $data['cc'], 'admin-event', $data['cc']);
            die('success');
        }
    }

    public function update_active_chat()
    {
        $id = $this->input->post('id', TRUE);

        $active = $this->email_model->show_active_chat()['exist'];

        if ($active > 0) {
            
            return $this->email_model->update_active_chat($id);
        } else {
            return $this->email_model->insert_active_chat($id);
        }
    }
}