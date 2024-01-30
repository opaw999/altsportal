<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dtr_model extends CI_Model
{

    public $db_pis;
    public $db_piscolonnade;
    public $db_tkcolonnade;
    public $db_tktalibon;
    public $db_tktubigon;

    function __construct()
    {
        parent::__construct();

        $this->db_pis = $this->load->database('pis', TRUE);
        $this->db_piscolonnade = $this->load->database('pis_colonnade', TRUE);
        $this->db_tkcolonnade = $this->load->database('tk_colonnade', TRUE);
        $this->db_tktalibon = $this->load->database('tk_talibon', TRUE);
        $this->db_tktubigon = $this->load->database('tk_tubigon', TRUE);
    }

    public function return_result_array($sql)
    {

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function return_row_array($sql)
    {

        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function return_num_rows($sql)
    {

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function return_result($sql)
    {

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function return_data_result($database, $sql)
    {

        if ($database == "tk_talibon") {

            $query = $this->db_tktalibon->query($sql);
        } else if ($database == "pis") {

            $query = $this->db_pis->query($sql);
        } else if ($database == "tk_tubigon") {

            $query = $this->db_tktubigon->query($sql);
        } else if ($database == "tk_colonnade") {

            $query = $this->db_tkcolonnade->query($sql);
        } else if ($database == "pis_colonnade") {

            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->result();
    }

    public function return_data_row_array($database, $sql)
    {

        if ($database == "tk_talibon") {

            $query = $this->db_tktalibon->query($sql);
        } else if ($database == "pis") {

            $query = $this->db_pis->query($sql);
        } else if ($database == "tk_tubigon") {

            $query = $this->db_tktubigon->query($sql);
        } else if ($database == "tk_colonnade") {

            $query = $this->db_tkcolonnade->query($sql);
        } else if ($database == "pis_colonnade") {

            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->row_array();
    }

    public function return_data_num_rows($database, $sql)
    {

        if ($database == "tk_talibon") {

            $query = $this->db_tktalibon->query($sql);
        } else if ($database == "pis") {

            $query = $this->db_pis->query($sql);
        } else if ($database == "tk_tubigon") {

            $query = $this->db_tktubigon->query($sql);
        } else if ($database == "tk_colonnade") {

            $query = $this->db_tkcolonnade->query($sql);
        } else if ($database == "pis_colonnade") {

            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->num_rows();
    }

    public function return_data_result_array($database, $sql)
    {

        if ($database == "tk_talibon") {

            $query = $this->db_tktalibon->query($sql);
        } else if ($database == "pis") {

            $query = $this->db_pis->query($sql);
        } else if ($database == "tk_tubigon") {

            $query = $this->db_tktubigon->query($sql);
        } else if ($database == "tk_colonnade") {

            $query = $this->db_tkcolonnade->query($sql);
        } else if ($database == "pis_colonnade") {

            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->result_array();
    }

    public function list_of_cutoffs()
    {

        $this->db->select('startFC, endFC, startSC, endSC, statCut');
        $query = $this->db->get('promo_schedule');
        return $query->result_array();
    }

    public function display_1stcutoff($cut_off)
    {

        $query = $this->db->select('DISTINCT(dateTo) AS dateTo, dateFrom')
            ->order_by('dateFrom', 'DESC')
            ->get_where('1stcutoff', array('statCut' => $cut_off));
        return $query->result();
    }

    public function display_2ndcutoff($cut_off)
    {

        $query = $this->db->select('DISTINCT(dateTo) AS dateTo, dateFrom')
            ->order_by('dateFrom', 'DESC')
            ->get_where('2ndcutoff', array('statCut' => $cut_off));
        return $query->result();
    }

    public function list_of_company($agency_code, $company_code)
    {

        if ($agency_code != 0) {

            $query = $this->db->select('company_name')
                ->from('promo_locate_company')
                ->where('agency_code', $agency_code)
                ->order_by('company_name', 'ASC')
                ->get();
            return $query->result_array();
        } else {

            $query = $this->db->select('company_name')
                ->from('promo_locate_company')
                ->where('company_code', $company_code)
                ->order_by('company_name', 'ASC')
                ->get();
            return $query->result_array();
        }
    }

    public function get_company_name($company_code)
    {

        $query = $this->db->select('company_name')
            ->get_where('promo_locate_company', array('company_code' => $company_code));
        return $query->row_array();
    }

    public function store_entry($server, $bioM, $allowId, $dateFrom, $entry, $mode)
    {

        $table = '';
        if ($allowId == "Biometric ID") : $table = "duty_biometric";
        endif;
        if ($allowId == "Logbox ID") : $table = "duty_logbox";
        endif;

        if ($mode == "I") : $time = "timeIn";
        else : $time = "timeOut";
        endif;
        $sql = "SELECT * FROM $table WHERE bioMetricId = '$bioM' AND dateDuty = '$dateFrom'

                    AND $time = '$entry' AND mode = '$mode'";
        $row = $this->return_data_row_array($server, $sql);
        if (empty($row)) {
            $store = '';
        } else {
            $store = $row['store'];
        }

        $code = '';
        if ($store == "alturas") {
            $code = "A";
        }
        if ($store == "alturas_tal") {
            $code = "B";
        }
        if ($store == "al_tub") {
            $code = "C";
        }
        if ($store == "icm") {
            $code = "D";
        }
        if ($store == "plaza_marcela") {
            $code = "E";
        }
        if ($store == "col_c") {
            $code = "F";
        }
        if ($store == "col_m") {
            $code = "G";
        }
        if ($store == "alta_cita") {
            $code = "H";
        }
        if ($store == "fixrite_panglao" || $store == "al_panglao") {
            $code = "I";
        }
        return $code;
    }

    public function get_photo($emp_id, $database)
    {

        if ($database == "pis") {

            $query = $this->db_pis->select('photo')
                ->get_where("applicant", array('app_id' => $emp_id));
        } else {

            $query = $this->db_piscolonnade->select('photo')
                ->get_where("applicant", array('app_id' => $emp_id));
        }

        return $query->row_array();
    }

    public function check_user_cutoff($supplier_id, $statCut)
    {

        $query = $this->db->select('COUNT(pcId) AS row')
            ->get_where('promo_supplier_cutoff', array('supplier_id' => $supplier_id, 'statCut' => $statCut));
        return $query->row_array();
    }

    public function supplier_type()
    {
        $query = $this->db->select('supplier_type')
            ->get_where('promo_supplier', array('id' => $_SESSION['supplier_id']));
        return $query->row_array();
    }

    public function supplier_ac_code($server)
    {

        if ($server == "colonnade") {

            $query = $this->db_tkcolonnade->get_where('promo_supplier_ac_code', array('user_id' => $_SESSION['userId'], 'supplier_id' => $_SESSION['supplier_id']));
            return $query->row();
        } else {

            $query = $this->db->get_where('promo_supplier_ac_code', array('user_id' => $_SESSION['userId'], 'supplier_id' => $_SESSION['supplier_id']));
            return $query->row();
        }
    }

    public function companies_under_agency($server, $agency_code)
    {
        if ($server == "colonnade") {

            // ONLY_FULL_GROUP_BY
            $this->db_tkcolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = $this->db_tkcolonnade->from('promo_locate_company')
                ->where('agency_code', $agency_code)
                ->group_by('company_name')
                ->get();
            return $query->result();
        } else {

            // ONLY_FULL_GROUP_BY
            $this->db->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = $this->db->from('promo_locate_company')
                ->where('agency_code', $agency_code)
                ->group_by('company_name')
                ->get();
            return $query->result();
        }
    }

    public function company_name($server, $company_code)
    {

        if ($server == "colonnade") {

            $query = $this->db_piscolonnade->get_where('locate_promo_company', array('pc_code' => $company_code));
            return $query->row_array();
        } else {

            $query = $this->db_pis->get_where('locate_promo_company', array('pc_code' => $company_code));
            return $query->row_array();
        }
    }

    public function promo_under_agency($data, $companies, $agency_code)
    {

        $before = date("Y-m-d", strtotime("- 2 week"));
        $date  = date('Y-m-d');

        $store = "";
        $companys = array();
        $i = 0;

        foreach ($companies as $company) {

            $companys[] = $company->company_name;
        }

        if ($data['server'] == "colonnade") {

            $store = "(p.colm = 'T' OR p.colc = 'T')";
            $this->db_piscolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_piscolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = $this->db_piscolonnade->select('e.record_no, e.emp_id, name, startdate, eocdate, position, promo_company, promo_type')
                ->from('employee3 AS e')
                ->join('promo_record AS p', 'p.record_no = e.record_no AND p.emp_id = e.emp_id')
                ->join('duxvwc44_dbtkcolon.promo_sched_emp AS t', 't.empId = e.emp_id')
                ->where('statCut', $data['cutoff'])
                ->where_in('promo_company', $companys)
                ->where('agency_code', $agency_code)
                ->group_start()
                ->where($store)
                ->group_end()
                ->group_start()
                ->group_start()
                ->where("'$data[dateFrom]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->or_group_start()
                ->where("'$data[dateTo]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->group_end()
                ->group_by('e.emp_id')
                ->get();

            // my query before the update for GROUP II
            // $query = "SELECT p.record_no, p.emp_id, e.name, e.position
            //             FROM promo_record p
            //                 INNER JOIN (
            //                     SELECT max(record_no) AS record_no, emp_id, name, position
            //                     FROM employee3
            //                     GROUP BY emp_id
            //                 ) e
            //                 ON  p.record_no = e.record_no
            //                 INNER JOIN duxvwc44_dbtkcolon.promo_sched_emp t ON t.empId = p.emp_id
            //                 WHERE
            //                     t.statCut = '" . $data['cutoff'] . "' AND
            //                     ($companys) AND
            //                     p.agency_code = '" . $agency_code . "' AND
            //                     $store
            //                 ORDER BY p.record_no DESC";
            // $sql = $this->db_piscolonnade->query($query);
        } else {

            if ($data['server'] == "talibon") {

                $tk = "duxvwc44_dbtalibon";
                $store = "p.al_tal = 'T'";
            } else if ($data['server'] == "tubigon") {

                $tk = "duxvwc44_dbtubigon";
                // $store = "p.al_tub = 'T'";
                $store = "(p.al_tub = 'T' OR p.fr_tubigon = 'T')";
            } else {

                $tk = "duxvwc44_altstk";
                $store = "p.al_tag = 'T' OR p.icm = 'T' OR p.pm = 'T' OR p.alta_citta = 'T' OR p.fr_panglao = 'T' OR p.al_panglao = 'T'";
            }

            $this->db_pis->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_pis->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = $this->db_pis->select('e.record_no, e.emp_id, name, startdate, eocdate, position, promo_company, promo_type')
                ->from('employee3 AS e')
                ->join('promo_record AS p', 'p.record_no = e.record_no AND p.emp_id = e.emp_id')
                ->join($tk . '.promo_sched_emp AS t', 't.empId = e.emp_id')
                ->where('statCut', $data['cutoff'])
                ->where_in('promo_company', $companys)
                ->where('agency_code', $agency_code)
                ->group_start()
                ->where($store)
                ->group_end()
                ->group_start()
                ->group_start()
                ->where("'$data[dateFrom]' BETWEEN startdate AND eocdate")
                ->or_where(" startdate BETWEEN '$data[dateFrom]' AND '$data[dateTo]'")
                ->group_end()
                ->or_group_start()
                ->where("'$data[dateTo]' BETWEEN startdate AND eocdate")
                ->or_where(" eocdate BETWEEN '$data[dateFrom]' AND '$data[dateTo]'")
                ->group_end()
                ->group_end()
                ->group_by('e.emp_id')
                ->get();
        }

        // print_r($this->db->last_query()); 

        return $query->result();
    }

    public function promo_details($pis, $emp_id, $record_no)
    {

        if ($pis == "pis_colonnade") {
            $query = $this->db_piscolonnade->select('promo_company, promo_type')
                ->get_where('promo_record', array('emp_id' => $emp_id, 'record_no' => $record_no));
        } else {
            $query = $this->db_pis->select('promo_company, promo_type')
                ->get_where('promo_record', array('emp_id' => $emp_id, 'record_no' => $record_no));
        }
        return $query->row();
    }

    public function employee_details($pis, $emp_id, $record_no)
    {

        $before = date("Y-m-d", strtotime("- 2 week"));
        $date  = date('Y-m-d');

        if ($pis == "pis_colonnade") {

            $sql = "SELECT current_status
                        FROM employee3
                        WHERE 
                            emp_id = '" . $emp_id . "' AND record_no = '" . $record_no . "' AND
                            (current_status = 'Active' OR ((current_status = 'End of Contract' OR current_status = 'Resigned' OR current_status = 'blacklisted') AND (eocdate BETWEEN '$before' AND '$date')))";
            $query = $this->db_piscolonnade->query($sql);
        } else {

            $sql = "SELECT current_status
                        FROM employee3
                        WHERE 
                            emp_id = '" . $emp_id . "' AND record_no = '" . $record_no . "' AND
                            (current_status = 'Active' OR ((current_status = 'End of Contract' OR current_status = 'Resigned' OR current_status = 'blacklisted') AND (eocdate BETWEEN '$before' AND '$date')))";
            $query = $this->db_pis->query($sql);
        }
        return $query->row();
    }

    public function promo_under_company($data, $company)
    {

        $before = date("Y-m-d", strtotime("- 2 week"));
        $date  = date('Y-m-d');

        if ($data['server'] == "colonnade") {

            $this->db_piscolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_piscolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $store = "(p.colm = 'T' OR p.colc = 'T')";

            /* $query = "SELECT p.record_no, p.emp_id, e.name, e.position
                        FROM promo_record p
                            INNER JOIN (
                                SELECT max(record_no) AS record_no, emp_id, name, position
                                FROM employee3
                                GROUP BY emp_id
                            ) e
                            ON  p.record_no = e.record_no
                            INNER JOIN duxvwc44_dbtkcolon.promo_sched_emp t ON t.empId = p.emp_id
                            WHERE
                                t.statCut = '" . $data['cutoff'] . "' AND
                                p.promo_company = '" . $company . "' AND
                                $store
                            ORDER BY p.record_no DESC"; */
            $sql = $this->db_piscolonnade->select('e.record_no, e.emp_id, name, startdate, eocdate, position, promo_company, promo_type')
                ->from('employee3 AS e')
                ->join('promo_record AS p', 'p.record_no = e.record_no AND p.emp_id = e.emp_id')
                ->join('duxvwc44_dbtkcolon.promo_sched_emp AS t', 't.empId = e.emp_id')
                ->where('statCut', $data['cutoff'])
                ->where('promo_company', $company)
                ->group_start()
                ->where($store)
                ->group_end()
                ->group_start()
                ->group_start()
                ->where("'$data[dateFrom]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->or_group_start()
                ->where("'$data[dateTo]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->group_end()
                ->group_by('e.emp_id')
                ->get();
        } else {

            if ($data['server'] == "talibon") {

                $tk = "duxvwc44_dbtalibon";
                $store = "(p.al_tal = 'T')";
            } else if ($data['server'] == "tubigon") {

                $tk = "duxvwc44_dbtubigon";
                // $store = "(p.al_tub = 'T')";
                $store = "(p.al_tub = 'T' OR p.fr_tubigon = 'T')";
            } else {

                $tk = "duxvwc44_altstk";
                $store = "(p.al_tag = 'T' OR p.icm = 'T' OR p.pm = 'T' OR p.alta_citta = 'T' OR p.fr_panglao = 'T' OR p.al_panglao = 'T')";
            }

            $this->db_pis->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_pis->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            /* $query = "SELECT p.record_no, p.emp_id, e.name, e.position
                        FROM promo_record p
                            INNER JOIN (
                                SELECT max(record_no) AS record_no, emp_id, name, position
                                FROM employee3
                                GROUP BY emp_id
                            ) e
                            ON  p.record_no = e.record_no
                            INNER JOIN $tk.promo_sched_emp t ON t.empId = p.emp_id
                            WHERE
                                t.statCut = '" . $data['cutoff'] . "' AND
                                p.promo_company = '" . $company . "' AND
                                $store
                            ORDER BY p.record_no DESC"; */
            $sql = $this->db_pis->select('e.record_no, e.emp_id, name, startdate, eocdate, position, promo_company, promo_type')
                ->from('employee3 AS e')
                ->join('promo_record AS p', 'p.record_no = e.record_no AND p.emp_id = e.emp_id')
                ->join($tk . '.promo_sched_emp AS t', 't.empId = e.emp_id')
                ->where('statCut', $data['cutoff'])
                ->where('promo_company', $company)
                ->group_start()
                ->where($store)
                ->group_end()
                ->group_start()
                ->group_start()
                ->where("'$data[dateFrom]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->or_group_start()
                ->where("'$data[dateTo]' BETWEEN startdate AND eocdate")
                ->group_end()
                ->group_end()
                ->group_by('e.emp_id')
                ->get();
        }

        return $sql->result();
    }

    public function promo_masterfile_under_agency($data, $companies)
    {

        $before = date("Y-m-d", strtotime("- 2 week"));
        $date  = date('Y-m-d');

        $companys = "";
        $i = 0;

        foreach ($companies as $company) {

            if ($i == 0) {
                // updated due to error of the company name with single qoute TECHNO FOODS PHIL. INC. (ROGER'S) & MEGAPOLYMER
                // $companys = "p.promo_company = '" . $company->company_name . "'";
                $companys = 'p.promo_company = "' . $company->company_name . '"';
            } else {

                // $companys .= " OR p.promo_company = '" . $company->company_name . "'";
                $companys .= ' OR p.promo_company = "' . $company->company_name . '"';
            }

            $i++;
        }

        if ($data['server'] == "colonnade") {

            $this->db_piscolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_piscolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT e.record_no, e.emp_id, e.name, p.promo_company, p.promo_type, e.current_status, e.position, t.statCut
                        FROM employee3 e
                            INNER JOIN promo_record p ON  p.record_no = e.record_no
                            INNER JOIN duxvwc44_dbtkcolon.promo_sched_emp t ON t.empId = e.emp_id
                            WHERE
                                ($companys) AND
                                (p.colc = 'T' OR p.colm = 'T')
                            GROUP BY e.emp_id
                            ORDER BY e.record_no DESC";
            $sql = $this->db_piscolonnade->query($query);
        } else {

            if ($data['server'] == "talibon") {

                $tk = "duxvwc44_dbtalibon";
                $store_condition = "(p.al_tal = 'T')";
            } else if ($data['server'] == "tubigon") {

                $tk = "duxvwc44_dbtubigon";
                $store_condition = "(p.al_tub = 'T')";
            } else {

                $tk = "duxvwc44_altstk";
                $store_condition = "(p.al_tag = 'T' OR p.icm = 'T' OR p.pm = 'T' OR p.alta_citta = 'T')";
            }

            $this->db_pis->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_pis->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT e.record_no, e.emp_id, e.name, p.promo_company, p.promo_type, e.current_status, e.position, t.statCut
                        FROM employee3 e
                            INNER JOIN promo_record p ON  p.record_no = e.record_no
                            INNER JOIN $tk.promo_sched_emp t ON t.empId = e.emp_id
                            WHERE
                                ($companys) AND
                                $store_condition
                            GROUP BY e.emp_id
                            ORDER BY e.record_no DESC";
            $sql = $this->db_pis->query($query);
        }

        return $sql->result();
    }

    public function promo_masterfile_under_company($data, $company)
    {

        $before = date("Y-m-d", strtotime("- 2 week"));
        $date  = date('Y-m-d');

        if ($data['server'] == "colonnade") {

            $this->db_piscolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_piscolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $store = "(p.colm = 'T' OR colc = 'T')";

            $query = "SELECT e.record_no, e.emp_id, e.name, p.promo_company, p.promo_type, e.current_status, e.position, t.statCut
                        FROM employee3 e
                            INNER JOIN promo_record p ON  p.record_no = e.record_no
                            INNER JOIN duxvwc44_dbtkcolon.promo_sched_emp t ON t.empId = e.emp_id
                            WHERE
                                p.promo_company = \"$company\" AND
                                (e.current_status = 'Active' OR ((e.current_status = 'End of Contract' OR e.current_status = 'Resigned' OR e.current_status = 'blacklisted') AND (e.eocdate BETWEEN '$before' AND '$date'))) AND
                                (e.emp_type like 'Promo%') AND 
                                $store
                            GROUP BY e.emp_id
                            ORDER BY e.record_no DESC";
            $sql = $this->db_piscolonnade->query($query);
        } else {

            if ($data['server'] == "talibon") {

                $tk = "duxvwc44_dbtalibon";
                $store = "(al_tal = 'T')";
            } else if ($data['server'] == "tubigon") {

                $tk = "duxvwc44_dbtubigon";
                $store = "(al_tub = 'T')";
            } else {

                $tk = "duxvwc44_altstk";
                $pis = 'duxvwc44_altspis';
                $store = "(al_tag = 'T' OR alta_citta = 'T' OR icm = 'T' OR pm = 'T')";
            }

            $this->db_pis->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_pis->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT e.record_no, e.emp_id, e.name, p.promo_company, p.promo_type, e.current_status, e.position, t.statCut
                        FROM employee3 e
                            INNER JOIN promo_record p ON  p.record_no = e.record_no
                            INNER JOIN $tk.promo_sched_emp t ON t.empId = e.emp_id
                            WHERE
                                p.promo_company = \"$company\" AND
                                (e.current_status = 'Active' OR ((e.current_status = 'End of Contract' OR e.current_status = 'Resigned' OR e.current_status = 'blacklisted')
                                AND (e.eocdate BETWEEN '$before' AND '$date'))) AND
                                $store
                            GROUP BY e.emp_id
                            ORDER BY e.record_no DESC";
            $sql = $this->db_pis->query($query);
        }
        return $sql->result();
    }

    public function no_sil_current($tk, $data)
    {

        if ($tk == "tk_colonnade") {

            $this->db_tkcolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tkcolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $r_l_absence = "SELECT COUNT(id) as no_rows FROM r_l_absence WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            fromDate = '" . $data['dateFrom'] . "' AND toDate = '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.status = 'Approved'";
            $r_l_absence = $this->db_tkcolonnade->query($r_l_absence);
            $r_l_absence_count = $r_l_absence->row();

            $rla_day = "SELECT COUNT(id) as no_rows FROM r_l_absence, rla_day WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            rla_day.empId = '" . $data['empId'] . "' AND 
                            rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
            $rla_day = $this->db_tkcolonnade->query($rla_day);
            $rla_day_count = $rla_day->row();

            if ($r_l_absence_count->no_rows != $rla_day_count->no_rows) {

                $query = "SELECT COUNT(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
                $query = $this->db_tkcolonnade->query($query);
            } else {

                $query = "SELECT SUM(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'
                                      LIMIT 1";
                $query = $this->db_tkcolonnade->query($query);
            }
        } else if ($tk == "tk_talibon") {

            $this->db_tktalibon->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tktalibon->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $r_l_absence = "SELECT COUNT(id) as no_rows FROM r_l_absence WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            fromDate = '" . $data['dateFrom'] . "' AND toDate = '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.status = 'Approved'";
            $r_l_absence = $this->db_tktalibon->query($r_l_absence);
            $r_l_absence_count = $r_l_absence->row();

            $rla_day = "SELECT COUNT(id) as no_rows FROM r_l_absence, rla_day WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            rla_day.empId = '" . $data['empId'] . "' AND 
                            rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
            $rla_day = $this->db_tktalibon->query($rla_day);
            $rla_day_count = $rla_day->row();

            if ($r_l_absence_count->no_rows != $rla_day_count->no_rows) {

                $query = "SELECT COUNT(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
                $query = $this->db_tktalibon->query($query);
            } else {

                $query = "SELECT SUM(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'
                                      LIMIT 1";
                $query = $this->db_tktalibon->query($query);
            }
        } else if ($tk == "tk_tubigon") {

            $this->db_tktubigon->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tktubigon->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $r_l_absence = "SELECT COUNT(id) as no_rows FROM r_l_absence WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            fromDate = '" . $data['dateFrom'] . "' AND toDate = '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.status = 'Approved'";
            $r_l_absence = $this->db_tktubigon->query($r_l_absence);
            $r_l_absence_count = $r_l_absence->row();

            $rla_day = "SELECT COUNT(id) as no_rows FROM r_l_absence, rla_day WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            rla_day.empId = '" . $data['empId'] . "' AND 
                            rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
            $rla_day = $this->db_tktubigon->query($rla_day);
            $rla_day_count = $rla_day->row();

            if ($r_l_absence_count->no_rows != $rla_day_count->no_rows) {

                $query = "SELECT COUNT(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
                $query = $this->db_tktubigon->query($query);
            } else {

                $query = "SELECT SUM(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'
                                      LIMIT 1";
                $query = $this->db_tktubigon->query($query);
            }
        } else {

            $this->db->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $r_l_absence = "SELECT COUNT(id) as no_rows FROM r_l_absence WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            fromDate = '" . $data['dateFrom'] . "' AND toDate = '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.status = 'Approved'";
            $r_l_absence = $this->db->query($r_l_absence);
            $r_l_absence_count = $r_l_absence->row();

            $rla_day = "SELECT COUNT(id) as no_rows FROM r_l_absence, rla_day WHERE 
                            r_l_absence.typeLeave = 'Personal' AND 
                            (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                            r_l_absence.empId = '" . $data['empId'] . "' AND 
                            rla_day.empId = '" . $data['empId'] . "' AND 
                            rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                            r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
            $rla_day = $this->db->query($rla_day);
            $rla_day_count = $rla_day->row();

            if ($r_l_absence_count->no_rows != $rla_day_count->no_rows) {

                $query = "SELECT COUNT(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'";
                $query = $this->db->query($query);
            } else {

                $query = "SELECT SUM(noDays) as sil FROM r_l_absence, rla_day WHERE 
                                      r_l_absence.typeLeave = 'Personal' AND 
                                      (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                      r_l_absence.empId = '" . $data['empId'] . "' AND 
                                      rla_day.empId = '" . $data['empId'] . "' AND 
                                      rla_day.date BETWEEN '" . $data['dateFrom'] . "' AND '" . $data['dateTo'] . "' AND r_l_absence.supStatus != 'Previous' AND
                                      r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved'
                                      LIMIT 1";
                $query = $this->db->query($query);
            }
        }

        return $query->row_array();
    }

    public function no_sil_previous($tk, $data)
    {

        if ($tk == "tk_colonnade") {

            $this->db_tkcolonnade->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tkcolonnade->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT COUNT(r_l_absence.id) as sil FROM r_l_absence, rla_day WHERE 
                                  r_l_absence.typeLeave = 'Personal' AND 
                                  (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                  r_l_absence.empId = '" . $data['empId'] . "' AND 
                                  rla_day.empId = '" . $data['empId'] . "' AND 
                                  r_l_absence.supDF = '" . $data['dateFrom'] . "' AND r_l_absence.supDT = '" . $data['dateTo'] . "' AND r_l_absence.supStatus = 'Previous' AND
                                  r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved' AND 
                                  rla_day.date BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT
                                  GROUP BY rla_day.date";
            $query = $this->db_tkcolonnade->query($query);
        } else if ($tk == "tk_talibon") {

            $this->db_tktubigon->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tktubigon->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT COUNT(r_l_absence.id) as sil FROM r_l_absence, rla_day WHERE 
                                  r_l_absence.typeLeave = 'Personal' AND 
                                  (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                  r_l_absence.empId = '" . $data['empId'] . "' AND 
                                  rla_day.empId = '" . $data['empId'] . "' AND 
                                  r_l_absence.supDF = '" . $data['dateFrom'] . "' AND r_l_absence.supDT = '" . $data['dateTo'] . "' AND r_l_absence.supStatus = 'Previous' AND
                                  r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved' AND 
                                  rla_day.date BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT
                                  GROUP BY rla_day.date";
            $query = $this->db_tktubigon->query($query);
        } else if ($tk == "tk_tubigon") {

            $this->db_tktalibon->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_tktalibon->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT COUNT(r_l_absence.id) as sil FROM r_l_absence, rla_day WHERE 
                                  r_l_absence.typeLeave = 'Personal' AND 
                                  (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                  r_l_absence.empId = '" . $data['empId'] . "' AND 
                                  rla_day.empId = '" . $data['empId'] . "' AND 
                                  r_l_absence.supDF = '" . $data['dateFrom'] . "' AND r_l_absence.supDT = '" . $data['dateTo'] . "' AND r_l_absence.supStatus = 'Previous' AND
                                  r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved' AND 
                                  rla_day.date BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT
                                  GROUP BY rla_day.date";
            $query = $this->db_tktalibon->query($query);
        } else {

            $this->db->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');

            $query = "SELECT COUNT(r_l_absence.id) as sil FROM r_l_absence, rla_day WHERE 
                                  r_l_absence.typeLeave = 'Personal' AND 
                                  (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%') AND 
                                  r_l_absence.empId = '" . $data['empId'] . "' AND 
                                  rla_day.empId = '" . $data['empId'] . "' AND 
                                  r_l_absence.supDF = '" . $data['dateFrom'] . "' AND r_l_absence.supDT = '" . $data['dateTo'] . "' AND r_l_absence.supStatus = 'Previous' AND
                                  r_l_absence.rLAId = rla_day.rLAId AND r_l_absence.empId = rla_day.empId AND r_l_absence.status = 'Approved' AND 
                                  rla_day.date BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT
                                  GROUP BY rla_day.date";
            $query = $this->db->query($query);
        }

        return $query->row_array();
    }
}
