<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    public function count_unread_msg()
    {
        $query = $this->db->select('COUNT(msg_id) AS count')
                        ->from('message')
                            ->group_start()
                                ->where('userId', $_SESSION['supplier_id'])
                                ->or_where('cc', $_SESSION['supplier_id'])
                            ->group_end()
                            ->where('supplier_read', false)
                        ->get();
        return $query->row();
    }
    
    public function read_all_messages() {
        $data = array(
                'supplier_read' => 1
        );
        
        $this->db->where('userId', $_SESSION['supplier_id']);
        $this->db->or_where('cc', $_SESSION['supplier_id']);
        $this->db->update('message', $data);
    }

    public function chat_messages()
    {
        $query = $this->db->from('message')
                                ->group_start()
                                    ->where('userId', $_SESSION['supplier_id'])
                                    ->or_where('cc', $_SESSION['supplier_id'])
                                ->group_end()
                            ->get();
        return $query->result();
    }

    public function submit_message($data)
    {
        $supplier = $this->supplier_details($_SESSION['userId']);
        $insert = array(
                'userId'    => $_SESSION['supplier_id'],
                'sender'    => $supplier->supplier,
                'subject'   => 'concern',
                'message'   => $data['message'],
                'supplier_read' => 1,
                'date_submitted' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('message', $insert);
    }

    public function supplier_details($user_id)
    {
        $query = $this->db->select('supplier, photo')
                            ->from('promo_supplier_user')
                            ->join('promo_supplier', 'promo_supplier.id = promo_supplier_user.supplier_id')
                            ->where('promo_supplier_user.id', $user_id)
                            ->get();
        return $query->row();
    }
}