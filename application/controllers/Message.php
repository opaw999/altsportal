<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__DIR__).'/utils/Pusher.php';

class Message extends CI_Controller {

	function __construct()
    {
        parent::__construct(); 
        $this->load->model('login_model');
        $this->load->model('message_model');
    }

    public function count_unread_msg()
    {
        $message = $this->message_model->count_unread_msg();
        echo $message->count;
    }
    
    public function read_all_messages()
    {
        $message = $this->message_model->read_all_messages();
        echo 0;
    }

    public function view_message()
    {
        
        $data['messages'] = $this->message_model->chat_messages();
        $data['request'] = 'chat_messages';

        $this->load->view('body/modal_response', $data);
    }

    public function send_message()
    {
        $fetch = $this->input->post(NULL, TRUE);
        $message = $this->message_model->submit_message($fetch);

        $pusher = new Pusher();

        if ($message) {
            
            $pusher->broadcast('supplier-channel', 'supplier-event', $message);
            die("success");
        }
    }
}