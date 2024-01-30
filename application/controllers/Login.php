<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        date_default_timezone_set('Asia/Manila');
    }

    public function authentication()
    {

        $fetch = $this->input->post(NULL, TRUE);

        // $password =  password_hash($fetch['password'], PASSWORD_DEFAULT);
        $row = $this->login_model->check_user($fetch);
        if ($row) {

            if (password_verify($fetch['password'], $row['password'])) {

                $dateToday  = date("Y-m-d");
                $dateFrom   = $row['date_from'];
                $dateTo     = $row['date_to'];
                $dateExt    = date("Y-m-d", strtotime($dateTo . "+3 days"));

                // newly added module
                $first_login = '';
                $last_login  = date("Y-m-d H:i:s");

                if ($row['first_login'] == "") {

                    $first_login  = date("Y-m-d H:i:s");
                }

                if ((strtotime($dateFrom) <= strtotime($dateToday)) && (strtotime($dateExt) >= strtotime($dateToday))) {

                    $userId         = $row['id'];
                    $supplier_id    = $row['supplier_id'];
                    $username       = $row['username'];

                    $user = $this->login_model->update_promo_supplier_user($userId, $first_login, $last_login);

                    $data = array(
                        'userId'    => $userId,
                        'supplier_id' => $supplier_id,
                        'username'  => $username,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($data);

                    die("success");
                }
            }
        }

        die("failure");
    }

    public function anonymous_authentication()
    {

        $fetch = $this->input->post(NULL, TRUE);

        $password =  password_hash('Altsportal2019', PASSWORD_DEFAULT);
        $row = $this->login_model->check_user($fetch);
        if ($row) {

            if (password_verify($fetch['password'], $password)) {

                $dateToday  = date("Y-m-d");
                $dateFrom   = $row['date_from'];
                $dateTo     = $row['date_to'];
                $dateExt    = date("Y-m-d", strtotime($dateTo . "+3 days"));

                // newly added module
                $first_login = '';
                $last_login  = date("Y-m-d H:i:s");

                if ($row['first_login'] == "") {

                    $first_login  = date("Y-m-d H:i:s");
                }

                if ((strtotime($dateFrom) <= strtotime($dateToday)) && (strtotime($dateExt) >= strtotime($dateToday))) {

                    $userId         = $row['id'];
                    $supplier_id    = $row['supplier_id'];
                    $username       = $row['username'];

                    $user = $this->login_model->update_promo_supplier_user($userId, $first_login, $last_login);

                    $data = array(
                        'userId'    => $userId,
                        'supplier_id' => $supplier_id,
                        'username'  => $username,
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($data);

                    die("success");
                }
            }
        }

        die("failure");
    }
}
