<?php
defined('BASEPATH') or exit('No direct script access allowed');

// for login module
$route['authentication'] = 'login/authentication';

// for email module
$route['view_message']              = 'email/view_message';
$route['delete_message']            = 'email/delete_message';
$route['view_details']              = 'email/view_details';
$route['delete_this_msg']           = 'email/delete_this_msg';
$route['view_message_detail']       = 'email/view_message_detail';
$route['count_unread_msg']          = 'email/count_unread_msg';
$route['count_total_msg']           = 'email/count_total_msg';
$route['supplier_chat_messages']    = 'email/supplier_chat_messages';
$route['view_supplier_messages']    = 'email/view_supplier_messages';
$route['send_feedback']             = 'email/send_feedback';
$route['update_active_chat']        = 'email/update_active_chat';

// for setup module
$route['dataTable_script']          = 'setup/dataTable_script';
$route['fetch_user_account']        = 'setup/fetch_user_account';
$route['delete_user']               = 'setup/delete_user';
$route['extend_contract']           = 'setup/extend_contract';
$route['submit_contract']           = 'setup/submit_contract';
$route['setup_cutoff']              = 'setup/setup_cutoff';
$route['insertAll_com_cut']         = 'setup/insertAll_com_cut';
$route['deleteAll_com_cut']         = 'setup/deleteAll_com_cut';
$route['insert_com_cut']            = 'setup/insert_com_cut';
$route['delete_com_cut']            = 'setup/delete_com_cut';
$route['create_account']            = 'setup/create_account';
$route['create_account_form']       = 'setup/create_account_form';
$route['submit_account']            = 'setup/submit_account';
$route['com_for_agency']            = 'setup/com_for_agency';
$route['delete_company']            = 'setup/delete_company';
$route['submit_agency']             = 'setup/submit_agency';
$route['fetch_companies']           = 'setup/fetch_companies';
$route['setupan_agency']            = 'setup/setupan_agency';
$route['insert_update_locate_company'] = 'setup/insert_update_locate_company';
$route['fetch_users']               = 'setup/fetch_users';
$route['reset_password']            = 'setup/reset_password';
$route['user_status']               = 'setup/user_status';
$route['submit_adminUser']          = 'setup/submit_adminUser';
$route['add_adminUser']             = 'setup/add_adminUser';
$route['update_adminUser']          = 'setup/update_adminUser';
$route['submit_updated_userAdmin']  = 'setup/submit_updated_userAdmin';
$route['fetch_agency_list']         = 'setup/fetch_agency_list';
$route['delete_agency']             = 'setup/delete_agency';
$route['update_agency']             = 'setup/update_agency';
$route['sub_updated_agency']        = 'setup/sub_updated_agency';
$route['fetch_company_list']        = 'setup/fetch_company_list';
$route['delete_companies']          = 'setup/delete_companies';
$route['sub_added_company']         = 'setup/sub_added_company';
$route['update_company']            = 'setup/update_company';
$route['sub_updated_company']       = 'setup/sub_updated_company';
$route['supplier_list']             = 'setup/supplier_list';
$route['add_supplier_details']      = 'setup/add_supplier_details';
$route['create_update_supplier']    = 'setup/create_update_supplier';
$route['edit_supplier_details']     = 'setup/edit_supplier_details';
$route['supplier_status']           = 'setup/supplier_status';
$route['supplier_account_list']     = 'setup/supplier_account_list';
$route['add_supplier_account']      = 'setup/add_supplier_account';
$route['setup_supplier']            = 'setup/setup_supplier';
$route['setup_consignor']           = 'setup/setup_consignor';
$route['create_supplier_account']   = 'setup/create_supplier_account';
$route['create_consignor_account']  = 'setup/create_consignor_account';
$route['supplier_user_status']      = 'setup/supplier_user_status';
$route['supplier_reset_password']   = 'setup/supplier_reset_password';
$route['renew_contract']            = 'setup/renew_contract';
$route['renew_supplier_contract']   = 'setup/renew_supplier_contract';
$route['edit_tag_ac']               = 'setup/edit_tag_ac';
$route['edit_tag_vendor']           = 'setup/edit_tag_vendor';
$route['update_supplier_account']   = 'setup/update_supplier_account';
$route['update_consignor_account']  = 'setup/update_consignor_account';
$route['consignor_account_list']    = 'setup/consignor_account_list';

// for violation module
$route['display_cutoff']            = 'violation/display_cutoff';
$route['cutoff']                    = 'violation/cutoff';
$route['employee_list']             = 'violation/employee_list';
$route['company_list']              = 'violation/company_list';
$route['view_employee_list']        = 'violation/view_employee_list';
$route['view_company_list']         = 'violation/view_company_list';
$route['upload_violation_form']     = 'violation/upload_violation_form';
$route['upload_violation']          = 'violation/upload_violation';
$route['view_violation']            = 'violation/view_violation';
$route['view_image']                = 'violation/view_image';
$route['delete_violation']          = 'violation/delete_violation';

// for report module
$route['report/users_xls']          = 'report/users_xls';

// for change account details module
$route['submit_username']           = 'admin/submit_username';
$route['submit_password']           = 'admin/submit_password';

// for import module
$route['import_data']               = 'import/import_data';
$route['import_violation_data']     = 'import/import_violation_data';

// for cms module
$route['fetch_vis']                 = 'cms/fetch_vis';
$route['fetch_cas']                 = 'cms/fetch_cas';
$route['fetch_po']                  = 'cms/fetch_po';
$route['fetch_deduction']           = 'cms/fetch_deduction';
$route['fetch_sales']               = 'cms/fetch_sales';
$route['fetch_items']               = 'cms/fetch_items';
$route['fetch_check_voucher']       = 'cms/fetch_check_voucher';
$route['fetch_check_details']       = 'cms/fetch_check_details';
$route['fetch_check_monitoring']    = 'cms/fetch_check_monitoring';
$route['fetch_sales']               = 'cms/fetch_sales';
$route['fetch_sales_uploaded']      = 'cms/fetch_sales_uploaded';
$route['fetch_sales_summary']       = 'cms/fetch_sales_summary';

// for masterfile
$route['masterfile']                = 'masterfile/masterfile';
$route['masterfileData']            = 'masterfile/masterfileData';
$route['promoDefSched']             = 'masterfile/promoDefSched';
$route['multSched']                 = 'masterfile/multSched';
$route['viewSched']                 = 'masterfile/viewSched';
$route['dayoff']                    = 'masterfile/dayoff';
$route['viewSchedPromo']            = 'masterfile/viewSchedPromo';
$route['dtrSearch']                 = 'masterfile/dtrSearch';
$route['dtrCutoff']                 = 'masterfile/dtrCutoff';
$route['promoDtr']                  = 'masterfile/promoDtr';
$route['vTEntry']                   = 'masterfile/vTEntry';

$route['page/menu/(:any)/(:any)']   = 'page/menu/$1/$2/$3';
$route['default_controller']        = 'page/menu';
$route['404_override']              = '';
$route['translate_uri_dashes']      = FALSE;
