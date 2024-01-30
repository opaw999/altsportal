<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    public $loginId = '';
    public $timestamp = '';

	function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];

        date_default_timezone_set('Asia/Manila');
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function return_result_array($sql) {

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function return_row_array($sql) {

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function return_num_rows($sql) {

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function return_result($sql) {

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function view_message($start) {

        $query = $this->db->from('message')
                            ->where('deleted !=', 1)
                            ->order_by('date_submitted', 'DESC')
                            ->limit(10,$start)
                            ->get();
        return $query->result();
    }

    public function view_picture($userId) {

        $query = $this->db->select('photo')
                            ->get_where('promo_supplier_user', array('id' => $userId));
        return $query->row_array();
    }

    public function count_total_msg() {

        $query = $this->db->get_where('message', array('deleted !=' => 1));
        return $query->num_rows();
    }

    public function count_unread_msg() {

        $query = $this->db->get_where('message', array('admin_read' => 0));
        return $query->num_rows();
    }

    public function delete_message($msg_id) {

        $data = array(
                'deleted' => 1
        );

        $this->db->where('msg_id', $msg_id);
        return $this->db->update('message', $data);
    }

    public function update_message($user_id) {

        $data = array(
                'admin_read' => 1
        );

        $this->db->where('userId', $user_id);
        return $this->db->update('message', $data);
    }

    public function message_details($msgId) {

        $query = $this->db->get_where('message', array('msg_id' => $msgId));
        return $query->row();
    }

    public function view_message_detail($start) {

        $query = $this->db->from('message')
                            ->where('deleted !=', 1)
                            ->order_by('date_submitted', 'DESC')
                            ->limit(1,$start)
                            ->get();
        return $query->row();
    }

    public function supplier_chat_messages() {

        $query = $this->db->query("SELECT DISTINCT `userId` FROM `message` WHERE cc = 0");
        $userIds = $query->result();

        $messages = array();
        foreach ($userIds as $id) {

            $query = $this->db->from('message')
                                    ->group_start()
                                        ->where('userId', $id->userId)
                                        ->or_where('cc', $id->userId)
                                    ->group_end()
                                ->order_by('msg_id', 'DESC')
                                ->get();
            $messages[] = $query->row();
        }
        
        // $ids = array_column($messages, 'msg_id');
        $ids = $this->array_column_manual($messages, 'msg_id');
        array_multisort($ids, SORT_DESC);
        return $ids;
    }
    
    private function array_column_manual($array, $column)
    {
        $newarr = array();
        foreach ($array as $row) $newarr[] = $row->$column;
        return $newarr;
    }

    public function active_chat($user_id) {
        $query = $this->db->select('COUNT(id) AS active')
                            ->from('promo_active_messages')
                                ->where('user_id', $user_id)
                                ->where('admin_id', $this->loginId)
                            ->get();
        $row = $query->row();
        if ($row->active > 0) {
            return 'active_chat';
        }
    }

    public function show_active_chat(){
        $query = $this->db->select('COUNT(id) AS exist')
                            ->from('promo_active_messages')
                                ->where('admin_id', $this->loginId)
                            ->get();
        return $query->row_array();
    }

    public function update_active_chat($user_id) {

        $data = array(
                'user_id' => $user_id,
                'updated_at' => $this->timestamp
        );

        $this->db->where('admin_id', $this->loginId);
        return $this->db->update('promo_active_messages', $data);
    }

    public function insert_active_chat($user_id) {

        $data = array(
                'user_id' => $user_id,
                'admin_id' => $this->loginId,
                'created_at'    => $this->timestamp
        );

        return $this->db->insert('promo_active_messages', $data);
    }

    public function view_supplier_messages($user_id) {
        $query = $this->db->from('message')
                            ->where('userId', $user_id)
                            ->or_where('cc', $user_id)
                        ->get();
        return $query->result();
    }

    public function send_feedback($data) {

        $sender = $this->message_sender($data['cc']);

        $insert = array(
                'userId' => $this->loginId,
                'cc' => $data['cc'],
                'sender' => $sender,
                'message' => htmlspecialchars($data['feedback']),
                'admin_read' => 1,
                'date_submitted'    => $this->timestamp
        );

        return $this->db->insert('message', $insert);
    }

    private function message_sender($user_id) {
        $query = $this->db->select('supplier')
                            ->from('promo_supplier')
                            ->join('promo_supplier_user', 'promo_supplier_user.supplier_id = promo_supplier.id')
                            ->where('promo_supplier_user.supplier_id', $user_id)
                            ->get();
        $row = $query->row();
        return $row->supplier;
    }
}