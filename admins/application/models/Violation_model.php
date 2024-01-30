<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Violation_model extends CI_Model {

    private $db_pis;
    private $db_piscolonnade;
    private $db_tkcolonnade;
	public 	$loginId;
    public 	$timestamp;

	function __construct() 
	{
		parent::__construct();
        $this->loginId = $_SESSION['adminId'];

        $this->db_pis = $this->load->database('pis', TRUE);
        $this->db_piscolonnade = $this->load->database('pis_colonnade', TRUE);
        $this->db_tkcolonnade = $this->load->database('tk_colonnade', TRUE);
        $this->db_tktalibon = $this->load->database('tk_talibon', TRUE);
        $this->db_tktubigon = $this->load->database('tk_tubigon', TRUE);

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

    public function return_data_result($database, $sql) {

        if ($database == "tk_talibon") {
            
            $query = $this->db_tktalibon->query($sql);
        }
        else if ($database == "pis") {
            
            $query = $this->db_pis->query($sql);
        }
        else if ($database == "tk_tubigon") {
            
            $query = $this->db_tktubigon->query($sql);
        }
        else if ($database == "tk_colonnade") {
            
            $query = $this->db_tkcolonnade->query($sql);
        }
        else if ($database == "pis_colonnade") {
            
            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->result();
    }

    public function return_data_row_array($database, $sql){

        if ($database == "tk_talibon") {
            
            $query = $this->db_tktalibon->query($sql);
        }
        else if ($database == "pis") {
            
            $query = $this->db_pis->query($sql);
        }
        else if ($database == "tk_tubigon") {
            
            $query = $this->db_tktubigon->query($sql);
        }
        else if ($database == "tk_colonnade") {
            
            $query = $this->db_tkcolonnade->query($sql);
        }
        else if ($database == "pis_colonnade") {
            
            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->row_array();
    }

    public function return_data_num_rows($database, $sql) {

        if ($database == "tk_talibon") {
            
            $query = $this->db_tktalibon->query($sql);
        }
        else if ($database == "pis") {
            
            $query = $this->db_pis->query($sql);
        }
        else if ($database == "tk_tubigon") {
            
            $query = $this->db_tktubigon->query($sql);
        }
        else if ($database == "tk_colonnade") {
            
            $query = $this->db_tkcolonnade->query($sql);
        }
        else if ($database == "pis_colonnade") {
            
            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->num_rows();
    }

    public function return_data_result_array($database, $sql) {

        if ($database == "tk_talibon") {
            
            $query = $this->db_tktalibon->query($sql);
        }
        else if ($database == "pis") {
            
            $query = $this->db_pis->query($sql);
        }
        else if ($database == "tk_tubigon") {
            
            $query = $this->db_tktubigon->query($sql);
        }
        else if ($database == "tk_colonnade") {
            
            $query = $this->db_tkcolonnade->query($sql);
        }
        else if ($database == "pis_colonnade") {
            
            $query = $this->db_piscolonnade->query($sql);
        } else {

            $query = $this->db->query($sql);
        }

        return $query->result_array();
    }

	public function list_of_cutoffs() {

		if ($this->session->userdata('server') == 'server_colonnade') {
			$query = $this->db_tkcolonnade->get_where('promo_schedule', array('remark' => 'active'));
		} else {
			$query = $this->db->get_where('promo_schedule', array('remark' => 'active'));
		}
		
		return $query->result_array();
	}

	public function display_1stcutoff($cut_off) {

    	$query = $this->db->select('DISTINCT(dateTo) AS dateTo, dateFrom')
    	                   ->order_by('dateFrom','DESC')
    	                   ->get_where('1stcutoff', array('statCut' => $cut_off));
    	return $query->result();
    }

    public function display_2ndcutoff($cut_off) {

    	$query = $this->db->select('DISTINCT(dateTo) AS dateTo, dateFrom')
                           ->order_by('dateFrom','DESC')
                           ->get_where('2ndcutoff', array('statCut' => $cut_off));
        return $query->result();
    }

    public function promo_list($data) {

    	$before= date("Y-m-d",strtotime("- 2 week"));
        $date  = date('Y-m-d');
        $store = '';

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

            $query = "SELECT p.record_no, p.emp_id, e.name, e.position
                        FROM promo_record p
                            INNER JOIN (
                                SELECT max(record_no) AS record_no, emp_id, name, position
                                FROM employee3
                                GROUP BY emp_id
                            ) e
                            ON  p.record_no = e.record_no
                            INNER JOIN boholonl_dbtkcolon.promo_sched_emp t ON t.empId = p.emp_id
                            WHERE
                                t.statCut = '".$data['cutoff']."' AND
                                $store
                            ORDER BY p.record_no DESC";
            $sql = $this->db_piscolonnade->query($query);

        } else {
            
            if ($data['server'] == "talibon") {
                
                $tk = "boholonl_dbtalibon";
                $store = "(p.al_tal = 'T')";

            } else if ($data['server'] == "tubigon") {
                
                $tk = "boholonl_dbtubigon";
                $store = "(p.al_tub = 'T')";

            } else {

                $tk = "boholonl_altstk";
                $store = "(p.al_tag = 'T' OR p.icm = 'T' OR p.pm = 'T' OR p.alta_citta = 'T')";
            }

            $this->db_pis->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db_pis->query('SET SESSION sql_mode =
                              REPLACE(REPLACE(REPLACE(
                              @@sql_mode,
                              "ONLY_FULL_GROUP_BY,", ""),
                              ",ONLY_FULL_GROUP_BY", ""),
                              "ONLY_FULL_GROUP_BY", "")');
           
            $query = "SELECT p.record_no, p.emp_id, e.name, e.position
                        FROM promo_record p
                            INNER JOIN (
                                SELECT max(record_no) AS record_no, emp_id, name, position
                                FROM employee3
                                GROUP BY emp_id
                            ) e
                            ON  p.record_no = e.record_no
                            INNER JOIN $tk.promo_sched_emp t ON t.empId = p.emp_id
                            WHERE
                                t.statCut = '".$data['cutoff']."' AND
                                $store
                            ORDER BY p.record_no DESC";
            $sql = $this->db_pis->query($query);
        }

        return $sql->result(); 
    }

    public function promo_details($pis, $emp_id, $record_no) {

        if ($pis == "pis_colonnade") {
            $query = $this->db_piscolonnade->select('promo_company, promo_type')
                                        ->get_where('promo_record', array('emp_id' => $emp_id, 'record_no' => $record_no));
        } else {
            $query = $this->db_pis->select('promo_company, promo_type')
                                        ->get_where('promo_record', array('emp_id' => $emp_id, 'record_no' => $record_no));
        }
        return $query->row();
    }

    public function employee_details($pis, $emp_id, $record_no) {

        $before= date("Y-m-d",strtotime("- 2 week"));
        $date  = date('Y-m-d');

        if ($pis == "pis_colonnade") {

            $sql = "SELECT current_status
                        FROM employee3
                        WHERE 
                            emp_id = '".$emp_id."' AND record_no = '".$record_no."' AND
                            (current_status = 'Active' OR ((current_status = 'End of Contract' OR current_status = 'Resigned' OR current_status = 'blacklisted') AND (eocdate BETWEEN '$before' AND '$date')))";
            $query = $this->db_piscolonnade->query($sql);
        
        } else {

            $sql = "SELECT current_status
                        FROM employee3
                        WHERE 
                            emp_id = '".$emp_id."' AND record_no = '".$record_no."' AND
                            (current_status = 'Active' OR ((current_status = 'End of Contract' OR current_status = 'Resigned' OR current_status = 'blacklisted') AND (eocdate BETWEEN '$before' AND '$date')))";
            $query = $this->db_pis->query($sql);
        }
        return $query->row();
    }

    public function promo_violation($pis, $pc_code, $data) {

        $date_from = date("Y-m-d", strtotime($data['dateFrom']));
        $date_to = date("Y-m-d", strtotime($data['dateTo']));

        if ($pis == "pis_colonnade") {

            $query = $this->db_piscolonnade->get_where('locate_promo_company', array('pc_code' => $pc_code));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db_piscolonnade->select('COUNT(id) AS exist')
                                        ->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $date_from, 'date_to' => $date_to));
        } else {

            $query = $this->db_pis->get_where('locate_promo_company', array('pc_code' => $pc_code));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db_pis->select('COUNT(id) AS exist')
                                        ->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $date_from, 'date_to' => $date_to));
        }
        return $query->row();
    }

    public function insert_promo_violation($path, $data) {

        $insert = array(
                'agency_code'    => $data['agency'],
                'company_name'   => $data['company'],
                'date_from' => $data['dateFrom'],
                'date_to'   => $data['dateTo'],
                'image_path'=> $path,
                'created_at'=> $this->timestamp,
                'updated_at'=> $this->timestamp
        );

        if ($data['server'] == "tagbilaran") {
            
            return $this->db_pis->insert('promo_violation', $insert);
        } else {

            return $this->db_piscolonnade->insert('promo_violation', $insert);
        }
    }

    public function get_promo_violation($data) {

        if ($data['server'] == "tagbilaran") {

            $query = $this->db_pis->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;
            
            $query = $this->db_pis->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $data['dateFrom'], 'date_to' => $data['dateTo']));
        } else {

            $query = $this->db_piscolonnade->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db_piscolonnade->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $data['dateFrom'], 'date_to' => $data['dateTo']));
        }

        return $query->result();
    }

    public function view_image($id) {

        if ($this->session->userdata('server') == "server_tag") {
            
            $query = $this->db_pis->select('image_path, created_at')
                                    ->get_where('promo_violation', array('id' => $id));
        } else {

            $query = $this->db_piscolonnade->select('image_path, created_at')
                                    ->get_where('promo_violation', array('id' => $id));
        }

        return $query->row();
    }

    public function delete_violation($id) {

        if ($this->session->userdata('server') == "server_tag") {
            
            return $this->db_pis->delete('promo_violation', array('id' => $id));
        } else {

            $query = $this->db_piscolonnade->delete('promo_violation', array('id' => $id));
        }
    }

    public function no_of_violation($data) {

        if ($this->session->userdata('server') == "tagbilaran") {

            $query = $this->db_pis->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;
            
            $query = $this->db_pis->select('COUNT(id) AS no_violation')
                                    ->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $data['dateFrom'], 'date_to' => $data['dateTo']));
        } else {

            $query = $this->db_piscolonnade->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db_piscolonnade->select('COUNT(id) AS no_violation')
                                    ->get_where('promo_violation', array('company_name' => $pc_name, 'date_from' => $data['dateFrom'], 'date_to' => $data['dateTo']));
        }

        return $query->row_array();
    }

    public function company_list($pis)
    {
        if ($pis == "pis_colonnade") {
            
            $query = $this->db_piscolonnade->get('locate_promo_company');
        } else {

            $query = $this->db_pis->get('locate_promo_company');
        }

        return $query->result();
    }

    public function company_with_agency($data)
    {
        if ($data['server'] == "tagbilaran") {
            
            $query = $this->db_pis->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db->group_by('agency_code')
            ->get_where('promo_locate_company', array('company_name' => $pc_name));
            $locate_company = $query->result();

            if (!empty($locate_company)) {
                
                return [
                    'agency' => 1,
                    'company' => $pc->pc_name,
                    'agencies' => $locate_company
                ];
            } else {

                return [
                    'agency' => 0,
                    'company' => $pc->pc_name
                ];
            }

        } else {

            $query = $this->db_piscolonnade->get_where('locate_promo_company', array('pc_code' => $data['pc_code']));
            $pc = $query->row();
            $pc_name = $pc->pc_name;

            $query = $this->db_tkcolonnade->get_where('promo_locate_company', array('company_name' => $pc_name));
            $locate_company = $query->result();

            if (!empty($locate_company)) {
                
                return [
                    'agency' => 1,
                    'company' => $pc->pc_name,
                    'agencies' => $locate_company
                ];
            } else {

                return [
                    'agency' => 0,
                    'company' => $pc->pc_name
                ];
            }
        }
    }

    public function agency_name($server, $agency_code)
    {
        if ($server == 'tagbilaran') {
            
            $query = $this->db->get_where('promo_locate_agency', array('agency_code' => $agency_code));
            return $query->row();
        } else {

            $query = $this->db_tkcolonnade->get_where('promo_locate_agency', array('agency_code' => $agency_code));
            return $query->row();
        }
    }
}