<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('dtr_model');
		$this->load->model('account_model');
		$this->load->model('contact_model');
		$this->load->model('message_model');
		$this->load->model('concession_model');
	}

	public function menu($menu = 'about', $submenu = '')
	{
		if (!isset($_SESSION['username'])) {

			if (html_escape($menu) == 'anonymous') {

				$this->load->view('template/anonymous_login');
			} else {

				$this->load->view('template/header_login');
				$this->load->view('body/login/login');
				$this->load->view('template/footer_script');
				$this->load->view('body/login/login_js');
			}
		} else {

			if ($menu == "cms" || $menu == "violation") {

				if (!file_exists(APPPATH . "views/body/$menu/$submenu/$submenu.php")) {

					$this->load->view('template/header_login');
					$this->load->view('body/show_404');
					$this->load->view('template/footer_script');
				} else {
					//CMS DATA
					$vcode = @$this->concession_model->getVendorCode("vendor_id = '" . $_SESSION['supplier_id'] . "' ");

					//count vendor code
					$vcodes = [];
					$vcode_count 	 = $this->concession_model->countVendorCode("vendor_id = '" . $_SESSION['supplier_id'] . "' ");
					$vendorcodes 	 = $this->concession_model->getVendorCodes("vendor_id = '" . $_SESSION['supplier_id'] . "' ");
					foreach ($vendorcodes as $rows) :
						array_push($vcodes, $rows['vendor_code']);
					endforeach;

					$data['vcodes']  = $vcodes;
					$data['vis_tbl'] = $this->concession_model->getfrmtblwhere('tbl_vis', "vendor_code='$vcode'");
					$data['cas_tbl'] = $this->concession_model->getalltblwhere('tbl_cas', "vendor_code='$vcode'");

					$monthplus  = date('Y-m-d', strtotime('+1 month')); //date one month from the current date
					$monthminus = date('Y-m-d', strtotime('-1 month')); //date one month after the current date
					$where      = " p_start > '$monthminus' and p_end < '$monthplus' and vendor_code = '$vcode'";
					$data['sales']  = $this->concession_model->getalltblwhere("tbl_item_sales_summary", $where);


					$data['check']      = $this->concession_model->getalltblwhere("tbl_check_monitoring", "vendor_code='$vcode'");
					$data['deductions'] = $this->concession_model->getfrmtblwhere('tbl_deductions', "vendor_code = '$vcode' and status !='Void'");
					//END CMS DATA

					$data['supplier'] = $this->login_model->supplier_details($_SESSION['userId']);
					$data['title']  = html_escape($menu);
					$data['message'] = $this->message_model->count_unread_msg();

					$this->load->view('template/header', $data);
					$this->load->view('template/menu', $data);
					$this->load->view("body/$menu/$submenu/$submenu", $data);
					$this->load->view('template/footer');
					$this->load->view('template/script');
					$this->load->view("body/$menu/$submenu/" . $submenu . "_js", $data);
				}
			} else {

				if (!file_exists(APPPATH . "views/body/$menu/$menu.php")) {

					$this->load->view('template/header_login');
					$this->load->view('body/show_404');
					$this->load->view('template/footer_script');
				} else {

					$data['supplier'] = $this->login_model->supplier_details($_SESSION['userId']);
					$data['title']  = html_escape($menu);
					$data['message'] = $this->message_model->count_unread_msg();

					if ($menu == 'masterfile') {
						$data['alturas'] = $this->dtr_model->supplier_ac_code("alturas");
						$data['colonnade'] = $this->dtr_model->supplier_ac_code("colonnade");
					}

					$this->load->view('template/header', $data);
					$this->load->view('template/menu', $data);
					$this->load->view("body/$menu/$menu", $data);
					$this->load->view('template/footer');
					$this->load->view('template/script');
					$this->load->view("body/$menu/" . $menu . "_js", $data);
				}
			}
		}
	}
}
