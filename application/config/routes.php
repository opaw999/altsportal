<?php
defined('BASEPATH') or exit('No direct script access allowed');

// for login module
$route['authentication'] = 'login/authentication';
$route['anonymous/authentication'] = 'login/anonymous_authentication';

// for logout module
$route['logout'] = 'logout';

// for dtr module
$route['display_cutoff'] = 'dtr/display_cutoff';
$route['cutoff'] = 'dtr/cutoff';
$route['employee_list'] = 'dtr/employee_list';
$route['view_employee_list'] = 'dtr/view_employee_list';
$route['view_dtr'] = 'dtr/view_dtr';
$route['vTEntry'] = 'dtr/vTEntry';

// for violation module
$route['emp_violation_list'] = 'violation/emp_violation_list';
$route['violation/company_list'] = 'violation/company_list';
$route['violation/view_employee_list'] = 'violation/view_employee_list';
$route['violation/view_company_list'] = 'violation/view_company_list';
$route['violation/view_company_violation'] = 'violation/view_company_violation';
$route['view_violation'] = 'violation/view_violation';
$route['view_image'] = 'violation/view_image';
$route['violation/display_cutoff'] = 'violation/display_cutoff';
$route['violation/display_supplier_cutoff'] = 'violation/display_supplier_cutoff';

// for print dtr module
$route['print/print_dtr'] = 'print_file/print_dtr';
$route['print/print_violation'] = 'print_file/print_violation';
$route['print/print_employee_violation'] = 'print_file/print_employee_violation';

// for masterfile module
$route['view_masterfile'] = 'masterfile/view_masterfile';
$route['view_schedule'] = 'masterfile/view_schedule';
$route['view_sched'] = 'masterfile/view_sched';

// for contact module
$route['submit_message'] = 'contact/submit_message';
$route['pusher/auth'] = 'contact/auth_user';
$route['count_unread_msg'] = 'message/count_unread_msg';
$route['read_all_messages'] = 'message/read_all_messages';
$route['view_message'] = 'message/view_message';
$route['send_message'] = 'message/send_message';

// for account module
$route['basic_info'] = 'account/basic_info';
$route['change_username'] = 'account/change_username';
$route['change_password'] = 'account/change_password';
$route['submit_password'] = 'account/submit_password';
$route['submit_username'] = 'account/submit_username';
$route['submit_profile'] = 'account/submit_profile';
$route['changeProfilePic'] = 'account/changeProfilePic';
$route['getProfilePic'] = 'account/getProfilePic';
$route['uploadProfilePic'] = 'account/uploadProfilePic';

//for supplier deduction
$route['supplier/view_penalty'] = 'supplier/view_penalty';

//cms
$route['view_items_sales']          = 'concession/view_items_sales';
$route['view_items_masterfile']     = 'concession/view_items_masterfile';
$route['items_pdf/(:any)']          = 'concession/items_pdf/$1';
$route['view_cas']                  = 'concession/show_cas';
$route['vendor_sales_pdf/(:any)']   = 'concession/vendor_sales_pdf/$1';
$route['view_vis']                  = 'concession/view_vis';
$route['view_cas']                  = 'concession/view_cas';
$route['view_items']                = 'concession/view_items';
$route['view_deductions']           = 'concession/view_deductions';
$route['view_check']                = 'concession/view_check';
$route['view_sales']                = 'concession/view_sales';



//api
$route['testlive']                  = 'concession/testlive';
$route['receive_po']                = 'concession/receive_po';
$route['post_toportal']             = 'concession/post_toportal';


//po
$route['vendor_po_pdf/(:any)']      = 'concession/vendor_po_pdf/$1';
$route['view_po']                   = 'concession/view_po';
$route['view_receivedpo']           = 'concession/view_received_po';



$route['page/menu/(:any)/(:any)'] = 'page/menu/$1/$2';
$route['default_controller'] = 'page/menu';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
