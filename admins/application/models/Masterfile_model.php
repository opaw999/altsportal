<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterfile_model extends CI_Model
{

    public $loginId = '';
    private $db_pis;
    private $db_piscolonnade;
    private $db_tkcolonnade;
    private $db_tktalibon;
    private $db_tktubigon;

    function __construct()
    {
        parent::__construct();
        $this->loginId = $_SESSION['adminId'];

        $this->db_pis = $this->load->database('pis', TRUE);
        $this->db_piscolonnade = $this->load->database('pis_colonnade', TRUE);
        $this->db_tkcolonnade = $this->load->database('tk_colonnade', TRUE);
        $this->db_tktalibon = $this->load->database('tk_talibon', TRUE);
        $this->db_tktubigon = $this->load->database('tk_tubigon', TRUE);
    }

    public function selectAll_tcA($server, $table, $array)
    {
        if ($server == 'cebu') {
            $query = $this->db_piscolonnade->get_where($table, $array);
        } else {
            $query = $this->db_pis->get_where($table, $array);
        }

        return $query->result_array();
    }

    public function selectAll_tcR($server, $table, $array)
    {
        if ($server == 'cebu') {
            $query = $this->db_piscolonnade->get_where($table, $array);
        } else {
            $query = $this->db_pis->get_where($table, $array);
        }

        return $query->row_array();
    }

    public function selectAll_tcR_tk($server, $table, $array)
    {
        if ($server == 'cebu') {
            $query = $this->db_tkcolonnade->get_where($table, $array);
        } else if ($server == 'tagbilaran') {
            $query = $this->db->get_where($table, $array);
        } else if ($server == 'talibon') {
            $query = $this->db_tktalibon->get_where($table, $array);
        } else if ($server == 'tubigon') {
            $query = $this->db_tktubigon->get_where($table, $array);
        }

        return $query->row_array();
    }

    public function selectAll_tcA_tk($server, $table, $array)
    {
        if ($server == 'cebu') {
            $query = $this->db_tkcolonnade->get_where($table, $array);
        } else if ($server == 'tagbilaran') {
            $query = $this->db->get_where($table, $array);
        } else if ($server == 'talibon') {
            $query = $this->db_tktalibon->get_where($table, $array);
        } else if ($server == 'tubigon') {
            $query = $this->db_tktubigon->get_where($table, $array);
        }
        return $query->result_array();
    }

    public function join_tkR($server, $select, $tb1, $tb2, $join, $condition)
    {
        if ($server == 'cebu') {
            $database = $this->db_tkcolonnade;
        } else if ($server == 'tagbilaran') {
            $database = $this->db;
        } else if ($server == 'talibon') {
            $database = $this->db_tktalibon;
        } else if ($server == 'tubigon') {
            $database = $this->db_tktubigon;
        }
        $query =  $database->select($select)
            ->from($tb1)
            ->join($tb2, $join)
            ->where($condition)
            ->get();
        return $query->row_array();
    }

    public function join_tkA($server, $select, $tb1, $tb2, $join, $condition)
    {
        if ($server == 'cebu') {
            $database = $this->db_tkcolonnade;
        } else if ($server == 'tagbilaran') {
            $database = $this->db;
        } else if ($server == 'talibon') {
            $database = $this->db_tktalibon;
        } else if ($server == 'tubigon') {
            $database = $this->db_tktubigon;
        }
        $query =  $database->select($select)
            ->from($tb1)
            ->join($tb2, $join)
            ->where($condition)
            ->get();
        return $query->result_array();
    }

    public function locate_promo_bu($server)
    {
        $database = ($server == 'cebu') ? $this->db_piscolonnade : $this->db_pis;
        $query = $database->select('*')
            ->from('locate_promo_business_unit')
            ->where('status', 'active')
            ->order_by('bunit_name')
            ->get();
        return $query->result_array();
    }

    public function empStores($server, $table, $emp_id, $record_no, $field)
    {
        $database = ($server == 'cebu') ? $this->db_piscolonnade : $this->db_pis;
        $query = $database->select('COUNT(promo_id) AS num')
            ->get_where($table, array('emp_id' => $emp_id, 'record_no' => $record_no, $field => 'T'));
        return $query->row_array()['num'];
    }

    public function masterfileSearch($input)
    {
        $database = ($input['server'] == 'cebu') ? $this->db_piscolonnade : $this->db_pis;
        $query = $database->distinct()
            ->select('emp_id, record_no')
            ->from('employee3')
            ->where_in('emp_type', array('Promo', 'Promo-NESCO'))
            ->group_start()
            ->like('name', $input['str'], 'both')
            ->or_like('emp_id', $input['str'], 'both')
            ->group_end()
            ->where('CURDATE() BETWEEN startdate AND eocdate', NULL, FALSE)
            ->limit(10)
            ->get();
        return $query->result_array();
    }

    public function dtrSearch($input)
    {
        $database = ($input['server'] == 'cebu') ? $this->db_piscolonnade : $this->db_pis;
        $query = $database->distinct()
            ->select('emp_id, record_no, date_added, name')
            ->from('employee3 e1')
            ->where_in('emp_type', array('Promo', 'Promo-NESCO'))
            ->group_start()
            ->like('name', $input['str'], 'both')
            ->or_like('emp_id', $input['str'], 'both')
            ->group_end()
            ->where('CURDATE() BETWEEN startdate AND eocdate')
            ->where('date_added = (SELECT MAX(date_added) FROM employee3 e2 WHERE e1.emp_id = e2.emp_id)', NULL, FALSE)
            ->limit(10)
            ->get();
        return $query->result_array();
    }

    public function promoDetails($server, $emp_id, $record_no)
    {
        $database = ($server == 'cebu') ? $this->db_piscolonnade : $this->db_pis;
        $query =  $database->select('*')
            ->from('employee3 as e')
            ->join('promo_record as p', 'p.emp_id=e.emp_id and p.record_no=e.record_no')
            ->where('e.emp_id', $emp_id)
            ->where('e.record_no', $record_no)
            ->get();
        return $query->row_array();
    }

    public function no_sil_current($tk, $data)
    {

        if ($tk == "cebu") {

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
        } else if ($tk == "talibon") {

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
        } else if ($tk == "tubigon") {

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

        if ($tk == "cebu") {

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
        } else if ($tk == "talibon") {

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
        } else if ($tk == "tubigon") {

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

        $condition = "bioMetricId = '$bioM' AND dateDuty = '$dateFrom' AND $time = '$entry' AND mode = '$mode'";
        $row = $this->selectAll_tcR_tk($server, $table, $condition);

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
}
