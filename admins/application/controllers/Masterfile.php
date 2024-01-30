<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterfile extends CI_Controller
{
    public $pdf;
    function __construct()
    {
        parent::__construct();

        $this->load->model('masterfile_model');
        $this->load->library('Pdf');
    }

    public function masterfile()
    {
        $input = $this->input->post(NULL, TRUE);
        $query = $this->masterfile_model->masterfileSearch($input);
        echo '<ul class="list-group">';
        if (count($query) > 0) {
            foreach ($query as $row) {
                $condition = "emp_id = '$row[emp_id]' AND record_no = '$row[record_no]'";
                $emp        = $this->masterfile_model->selectAll_tcR($input['server'], 'employee3', $condition);
                $name       = htmlspecialchars($emp['name']);
                $emp_id     = $emp['emp_id'];
                $record_no  = $emp['record_no'];
                $data       = $name . '*' . $emp_id . '*' . $record_no;
                echo '<a href="javascript:;" class="list-group-item" onclick="selectMasterfile(\'' . $data . '\')">'
                    . $name .
                    '</a>';
            }
        } else {
            echo '<a href="javascript:;" class="list-group-item">No Results Found!</a>';
        }
        echo    '</ul>';
    }

    public function masterfileData()
    {
        $input  = $this->input->post(NULL, TRUE);
        $row    = $this->masterfile_model->promoDetails($input['server'], $input['emp_id'], $input['record_no']);
        $dayoff = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'assign_day_off', array('empId' => $input['emp_id']));
        $data   = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'assign', array('empId' => $input['emp_id']));
        $bUs    = $this->masterfile_model->locate_promo_bu($input['server']);
        $stores = '';
        $i = 0;
        foreach ($bUs as $bu) {
            $hasBu = $this->masterfile_model->empStores($input['server'], 'promo_record', $input['emp_id'], $input['record_no'], $bu['bunit_field']);
            if ($hasBu > 0) {
                $i++;
                $stores = ($i == 1) ? $bu['bunit_name'] : $stores . ', ' . $bu['bunit_name'];
            }
        }
        $do = (count($dayoff) > 0) ? $dayoff['day'] : $row['dayoff'];
        if ($do == '') {
            $do = 'No Day Off';
        }


        $sc = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'shiftcodes', array('shiftCode' => $data['shiftCode']));

        $in1     = $sc['1stIn'];
        $out1     = $sc['1stOut'];

        $in2     = $sc['2ndIn'];
        $out2     = $sc['2ndOut'];

        echo    '<table class="table table-sm font_size2 mt-1">
                    <tr>
                        <th>HRMS ID</th>
                        <td colspan="3">: ' . $row['emp_id'] . '</td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td colspan="3">: ' . $row['promo_company'] . '</td>
                    </tr>
                    <tr>
                        <th>Store(s)</th>
                        <td colspan="3">: ' . $stores . '</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td colspan="3">: ' . $row['promo_department'] . '</td>
                    </tr>
                    <tr>
                        <th>Biometric ID</th>
                        <td colspan="3">: ' . $data['bioMetricId'] . '</td>
                    </tr>
                        <th>Logbox ID</th>
                        <td colspan="3">: ' . $data['barcodeId'] . '</td>
                    </tr>
                    <tr>
                        <th>Default ID</th>
                        <td>: ' . $data['allowId'] . '</td>
                        <th>Day Off</th>
                        <td>: ' . $do . '</td>
                    </tr>';

        if ($row['promo_type'] == 'STATION') {
            echo    '<tr>
                        <th>Default Shift Code</th>
                        <td colspan="3">: ' . $data['shiftCode'] . '</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td colspan="3">: ' . $in1 . ' ' . $out1 . ' - ' . $in2 . ' ' . $out2 . '</td>
                    </tr>';
        }
        echo    '</table>';
        echo    '<div class="button-container d-flex justify-content-center">';
        if ($row['promo_type'] == 'ROVING') {
            echo    '<button class="btn btn-primary mx-1" onclick="shiftSched(\'' . $input['emp_id'] . '\')">Default Schedule</button>';
        }
        $month  = date('m');
        $year   = date('Y');
        echo        '<button class="btn btn-primary mx-1" onclick="viewSched(\'' . $input['emp_id'] . '\',\'' . $row['promo_type'] . '\',\'' . $month . '\',\'' . $year . '\')">View Schedule</button>
                </div>';
    }

    public function promoDefSched()
    {
        $input  = $this->input->post(NULL, TRUE);
        $query  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'promo_def_sched', array('empId' => $input['emp_id']));

        echo    '<table class="table table-hover table-sm font_size3" width="100%" id="promoDefSched">
                    <thead>
                	    <tr>
                	    	<th class="d">Day</th>
                	    	<th class="sc">Shift Code</th>
                	    	<th clas="ts">Time Schedule</th>
                	    	<th class="s1">Store1</th>
                	    	<th class="s2">Store2</th>
                	    </tr>
                    </thead>
                    <tbody>';
        foreach ($query as $row) {
            $dayV       = $row['day_sched'];
            $shiftCode  = $row['shiftCode'];
            $storea     = $row['store1'];
            $storeb     = $row['store2'];

            if ($storea == "03,01") {
                $s_a = "Plaza Marcela Discount Store";
            } else if ($storea == "02,01") {
                $s_a = "Alturas Mall";
            } else if ($storea == "02,03") {
                $s_a = "Island City Mall";
            } else if ($storea == "02,21") {
                $s_a = "Alturas Tubigon";
            } else if ($storea == "02,02") {
                $s_a = "Alturas Talibon";
            } else if ($storea == "07,01") {
                $s_a = "Colonnade Colon";
            } else if ($storea == "07,02") {
                $s_a = "Colonnade Mandaue";
            } else if ($storea == "02,23") {
                $s_a = "Alta Citta";
            } else {
                $s_a = "";
            }

            if ($storeb == "03,01") {
                $s_b = "Plaza Marcela Discount Store";
            } else if ($storeb == "02,01") {
                $s_b = "Alturas Mall";
            } else if ($storeb == "02,03") {
                $s_b = "Island City Mall";
            } else if ($storeb == "02,21") {
                $s_b = "Alturas Tubigon";
            } else if ($storeb == "02,02") {
                $s_b = "Alturas Talibon";
            } else if ($storeb == "07,01") {
                $s_b = "Colonnade Colon";
            } else if ($storeb == "07,02") {
                $s_b = "Colonnade Mandaue";
            } else if ($storeb == "02,23") {
                $s_b = "Alta Citta";
            } else {
                $s_b = "";
            }
            $sc     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'shiftcodes', array('shiftCode' => $shiftCode));
            $in1    = $sc['1stIn'];
            $out1   = $sc['1stOut'];

            $in2    = $sc['2ndIn'];
            $out2   = $sc['2ndOut'];



            echo    "<tr>
	            		<td>$dayV</td>
	            		<td>$shiftCode</td>
	            		<td>$in1 - $out1 | $in2 - $out2</td>
	            		<td>$s_a</td>
	            		<td>$s_b</td>
	            	</tr>";
        }
        echo    '<tbody>
            </table>';
    }

    public function multSched()
    {
        $input  = $this->input->post(NULL, TRUE);
        $c      = "empId ='$input[emp_id]' ORDER BY dateFrom DESC";
        $query  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'assign_mul_sc', $c);
        echo '<h5 class="text-center">Multiple Shift Schedule</h5>';
        echo    '<table class="table table-hover table-sm font_size2" width="100%" id="multScheds">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>SC</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Request</th>
                            <th>Request Date/Time</th>
                            <th>Dayoff</th>
                        </tr>
                    <thead>
                    <tbody>';
        foreach ($query as $row) {

            $amsId  = $row['amsId'];
            $mSC    = $row['shiftCode'];
            $dF     = $row['dateFrom'];
            $dT     = $row['dateTo'];
            $status = $row['status'];

            $dFrom  = date('m/d/Y', strtotime($dF));
            $dTo    = date('m/d/Y', strtotime($dT));

            $sc     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'shiftcodes', array('shiftCode' => $mSC));
            $in1    = $sc['1stIn'];
            $out1   = $sc['1stOut'];
            $in2    = $sc['2ndIn'];
            $out2   = $sc['2ndOut'];

            $num_odaf = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_odaf', array('amsId' => $amsId));
            $reqStat = '';
            $dateReq = '';
            if (count($num_odaf) > 0) {

                $dateReq = $num_odaf['dateReq'];
                $timeReq = $num_odaf['timeReq'];
                $dateReq = date("m/d/Y g:i A", strtotime("$dateReq $timeReq"));
                $reqStat = "<b>O.D.A.</b>";
            }

            $num_nsc = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_new_shift', array('amsId' => $amsId));
            $img_dayff = '';
            if (count($num_nsc) > 0) {

                $dateReq    = $num_nsc['dateReq'];
                $timeReq    = $num_nsc['timeReq'];
                $dateReq    = date("m/d/Y g:i A", strtotime("$dateReq $timeReq"));
                $reqStat    = "<b>C.S.</b>";
                $img_dayff  =   '<a href="javascript:;" title="View Dayoff" onclick="viewDayoff(\'' . $input['emp_id'] . '\',\'' . $amsId . '\')">
                                    <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                                </a>';
            }

            echo    "<tr>
                        <td>$dFrom - $dTo</td>
                        <td>$mSC</td>
                        <td>$in1 $out1 - $in2 $out2 </td>
                        <td>$status</td>
                        <td>$reqStat</td>
                        <td>$dateReq</td>
                        <td class='text-center'>$img_dayff</td>
                    </tr>";
        }

        echo        '</tbody>
                </table>';
    }

    public function dayoff()
    {
        $input  = $this->input->post(NULL, TRUE);
        $condition = array('empId' => $input['emp_id'], 'amsId' => $input['amsId']);
        $query  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'ass_mul_do', $condition);


        if (count($query) > 0) {
            echo    '<table class="table table-hover table-sm">
                        <tr>
                            <th>Date</th>
                            <th>Dayoff</th>
                        </tr>';
            foreach ($query as $row) {

                $date   = $row['date'];
                $dayOff = $row['dayOff'];
                $date   = date("M. d, Y", strtotime($date));

                echo    '<tr class = "trHover">
                            <td>' . $date . '</td>
                            <td>' . $dayOff . '</td>
                        </tr>';
            }
        } else {
            echo '<h4 class="text-danger">No Results Found!</h4>';
        }
        echo        '</table>';
    }

    public function viewSched()
    {
        $input          = $this->input->post(NULL, TRUE);
        $empId          = $input['emp_id'];
        $record_no      = $input['record_no'];
        $promo_type     = $input['promo_type'];
        $month          = $input['month'];
        $year           = $input['year'];
        $data           = $empId . '*' . $record_no . '*' . $promo_type;
        $future_year    = ($year * 1) + 10;

        $temp_date  = date("Y-m-d", strtotime("$year-$month-01"));

        $back_month = date("m", strtotime($temp_date . "-1 month"));
        $back_year  = date("Y", strtotime($temp_date . "-1 month"));

        $add_month  = date("m", strtotime($temp_date . "+1 month"));
        $add_year   = date("Y", strtotime($temp_date . "+1 month"));

        echo    '<div class="d-flex justify-content-center align-items-center">
                    <div class="col-md-4 text-right">
                        <a href="javascript:;" onclick="view_sched2(\'' . $back_month . '\',\'' . $back_year . '\',\'' . $data . '\')">
                            <i class="fa fa-lg fa-angle-double-left"></i>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <select name="month_" class="form-control" onchange="month_n(\'' . $data . '\')">';
        for ($x = 1; $x <= 12; $x++) {
            $sel = ($month  == $x) ? 'selected' : '';
            echo            '<option value="' . $x . '" ' . $sel . '>' . date('F', strtotime("$year-$x-01")) . '</option>';
        }
        echo            '</select>
                    </div>
                    <div class="col-md-2">
                        <select name="year_" class="form-control" onchange="year_n(\'' . $data . '\')">';
        for ($y = 2017; $y <= $future_year; $y++) {
            $sel = ($y == $year) ? 'selected' : '';
            echo            '<option value="' . $y . '" ' . $sel . '>' . $y . '</option>';
        }
        echo            '</select>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:;" onclick="view_sched2(\'' . $add_month . '\',\'' . $add_year . '\',\'' . $data . '\')">
                            <i class="fa fa-lg fa-angle-double-right"></i></i>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="viewSchedPromo">

                        </div>
                    </div>
                </div>';
    }

    public function viewSchedPromo()
    {
        $input  = $this->input->post(NULL, TRUE);


        $empId      = $input['emp_id'];
        $record_no  = $input['record_no'];
        $promo_type = $input['promo_type'];
        $month      = $input['month'];
        $year       = $input['year'];

        $last       = date("t", strtotime("$year-$month-01"));
        echo    '<table id="dt_schedule" class="table table-sm table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Schedule</th>
                            <th>Store</th>
                        </tr>
                    </thead>
                    <tbody>';


        $bUs    = $this->masterfile_model->locate_promo_bu($input['server']);
        $stores = '';
        $i = 0;
        foreach ($bUs as $bu) {
            $hasBu = $this->masterfile_model->empStores($input['server'], 'promo_record', $empId, $record_no, $bu['bunit_field']);
            if ($hasBu > 0) {
                $i++;
                $stores = ($i == 1) ? $bu['bunit_name'] : $stores . ', ' . $bu['bunit_name'];
            }
        }
        if ($promo_type == 'STATION') {

            for ($i = 1; $i <= $last; $i++) {

                $wholeDate  = date("F d, Y", strtotime("$year-$month-$i"));
                $n_day      = date("Y-m-d", strtotime("$year-$month-$i"));
                $dayS       = date("l", strtotime($n_day));

                echo    "<tr>
                            <td>$wholeDate</td>
                            <td>$dayS</td>
                            <td>";

                $count      = 0;
                $countDO    = 0;
                $ctr        = 0;

                $condition  = "empId= '$empId' AND '$n_day' BETWEEN dateFrom AND dateTo ORDER BY id DESC LIMIT 1";
                $cons       = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'assign_mul_sc', $condition);

                foreach ($cons as $co) {

                    $count++;
                    $shiftCode      = $co['shiftCode'];
                    $amsId          = $co['amsId'];
                    $no_schedule    = '';

                    $condition      = "empId= '$empId' AND amsId= '$amsId' AND date = '$n_day'";
                    $no_sched       = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'promo_nosched', $condition);

                    if (count($no_sched) != 0) {
                        $no_schedule = 'true';
                    }

                    $condition  = "empId= '$empId' AND amsId= '$amsId' AND date = '$n_day'";
                    $numDayoff  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'ass_mul_do', $condition);
                    if (count($numDayoff) != 0) {

                        $countDO++;
                        echo '<font color="red">DAY-OFF</font>';
                    } else if ($no_schedule == 'true') {

                        echo '<font color="red">NO SCHEDULE</font>';
                    } else {

                        $sc     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'shiftcodes', array('shiftCode' => $shiftCode));

                        $fIn    = $sc['1stIn'];
                        $fOut   = $sc['1stOut'];

                        $sIn    = $sc['2ndIn'];
                        $sOut   = $sc['2ndOut'];

                        $sq     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_new_shift', array('amsId' => $amsId));
                        if (count($sq) != 0) {

                            $dateReq = date("Y/m/d", strtotime($sq['dateReq']));
                            $timeReq = date("h:i A", strtotime($sq['timeReq']));
                            echo "[ <span data-toggle='tooltip' data-placement='top' title = ''><font color = 'blue'>$shiftCode</font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                        }

                        $sq     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'req_new_shift_emp', array('amsId' => $amsId));
                        if (count($sq) != 0) {

                            $dateReq = date("Y/m/d", strtotime($sq['dateReq']));
                            $timeReq = date("h:i A", strtotime($sq['timeReq']));
                            echo "[ <span data-toggle='tooltip' data-placement='top' title = ''><font color = 'blue'>$shiftCode</font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                        }

                        $sq     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_odaf', array('amsId' => $amsId));
                        if (count($sq) != 0) {

                            $dateReq = date("Y/m/d", strtotime($sq['dateReq']));
                            $timeReq = date("h:i A", strtotime($sq['timeReq']));
                            echo "[ <span data-toggle='tooltip' data-placement='top' title = ''><font color = 'red'>$shiftCode </font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                        }
                    }
                }

                if ($count == 0) {

                    $day        = date('l', strtotime($n_day));
                    $condition  = "empId= '$empId' AND day= '$day'";
                    $numDayoff  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'assign_day_off', $condition);

                    if (count($numDayoff) != 0) {

                        $countDO++;
                        echo "<font color='red'>DAY-OFF</font>";
                    } else {

                        $row  = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'assign', array('empId' => $empId));
                        if (count($row) > 0) {

                            $shiftCode = $row['shiftCode'];
                            $sc  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'shiftcodes', array('shiftCode' => $shiftCode));
                            foreach ($sc as $sg) {

                                $ctr++;
                                $fIn    = $sg['1stIn'];
                                $fOut   = $sg['1stOut'];

                                $sIn    = $sg['2ndIn'];
                                $sOut   = $sg['2ndOut'];

                                echo "[ <span data-html='true' data-toggle='tooltip' data-placement='top' title = 'default schedule'><font color = ''>$shiftCode</font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                            }
                        } else {
                            echo '';
                        }
                    }
                }

                echo        '</td>
                                <td>';

                if ($countDO > 0) {

                    echo '';
                } else {

                    echo ucwords(strtolower($stores));
                }
                echo        '</td>
                        </tr>';
            }
        } else {

            for ($i = 1; $i <= $last; $i++) {

                $wholeDate  = date("F d, Y", strtotime("$year-$month-$i"));
                $n_day      = date("Y-m-d", strtotime("$year-$month-$i"));
                $dayS       = date("l", strtotime($n_day));

                echo    "<tr>
                            <td>$wholeDate</td>
                            <td>$dayS</td>
                            <td>";

                $count      = 0;
                $countDO    = 0;
                $ctr        = 0;

                $condition  = "empId= '$empId' AND dateRendered= '$n_day' ORDER BY pId DESC LIMIT 1";
                $cons       = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'promo_mul_sc', $condition);
                foreach ($cons as $co) {

                    $count++;
                    $shiftCode  = $co['shiftCode'];
                    $amsId      = $co['amsId'];
                    $no_store   = $co['noStore'];
                    $store1     = $co['store1'];
                    $store2     = $co['store2'];

                    $condition   = "empId= '$empId' AND amsId= '$amsId' AND date = '$n_day'";
                    $numDayoff  = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'ass_mul_do', $condition);
                    if (count($numDayoff) != 0) {

                        $countDO++;
                        echo "<font color='red'>DAY-OFF</font>";
                    } else if ($no_store == 0) {
                        echo "<font color='red'>NO SCHEDULE</font>";
                    } else {

                        $sg     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'shiftcodes', array('shiftCode' => $shiftCode));

                        $fIn    = $sg['1stIn'];
                        $fOut   = $sg['1stOut'];

                        $sIn    = $sg['2ndIn'];
                        $sOut   = $sg['2ndOut'];

                        $sq     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_new_shift', array('amsId' => $amsId));
                        if (count($sq) != 0) {

                            $dateReq = date("Y/m/d", strtotime($sq['dateReq']));
                            $timeReq = date("h:i A", strtotime($sq['timeReq']));
                            echo "[ <span title = ''><font color = 'blue'>$shiftCode</font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                        }

                        $sq     = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'request_odaf', array('amsId' => $amsId));
                        if (count($sq) != 0) {

                            $dateReq = date("Y/m/d", strtotime($sq['dateReq']));
                            $timeReq = date("h:i A", strtotime($sq['timeReq']));
                            echo "[ <span title = ''><font color = 'red'>$shiftCode </font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                        }
                    }
                }

                if ($count == 0) {

                    $day        = date('l', strtotime($n_day));
                    $condition  = "empId = '$empId' AND day_sched = '$day'";
                    $ds         = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'promo_def_sched', $condition);
                    $shiftCode  = $ds['shiftCode'];
                    $no_store   = $ds['noStore'];

                    if ($no_store == '0') {

                        echo "<font color='red'>DAY-OFF</font>";
                    } else {

                        $sc = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'shiftcodes', array('shiftCode' => $shiftCode));
                        if (count($sc) != 0) {
                            foreach ($sc as $sg) {

                                $ctr++;
                                $fIn = $sg['1stIn'];
                                $fOut = $sg['1stOut'];

                                $sIn = $sg['2ndIn'];
                                $sOut = $sg['2ndOut'];

                                echo "[ <span title = 'default schedule'><font color = ''>$shiftCode</font> = <sup>$fIn - $fOut , $sIn   $sOut</sup></span> ]";
                            }
                        } else {
                            echo '';
                        }
                    }
                }

                echo        '</td>
                            <td>';

                $condition = "empId = '$empId' AND dateRendered = '$n_day' ORDER BY pId DESC LIMIT 1";
                $cons = $this->masterfile_model->selectAll_tcA_tk($input['server'], 'promo_mul_sc', $condition);
                foreach ($cons as $co) {

                    $count++;
                    if ($co['noStore'] > 0) {
                        if ($co['noStore'] == '1') {

                            $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $co['store1']));

                            echo $row['store_name'];
                        } else {

                            $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $co['store1']));
                            $store1 = $row['store_name'];

                            $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $co['store2']));
                            $store2 = $row['store_name'];

                            echo "$store1 / $store2";
                        }
                    } else {

                        echo '';
                    }
                }

                if ($count == 0) {

                    $day        = date('l', strtotime($n_day));
                    $condition  = "empId = '$empId' AND day_sched = '$day'";
                    $ds         = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'promo_def_sched', $condition);
                    if (count($ds) != 0) {

                        if ($ds['noStore'] > 0) {

                            if ($ds['noStore'] == '1') {

                                $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $ds['store1']));
                                echo $row['store_name'];
                            } else {

                                $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $ds['store1']));
                                $store1 = $row['store_name'];

                                $row = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'storecode', array('store_code' => $ds['store2']));
                                $store2 = $row['store_name'];

                                echo "$store1 / $store2";
                            }
                        } else {

                            echo '';
                        }
                    } else {
                        echo '';
                    }
                }
                echo        '</td>
                        </tr>';
            }
        }

        echo        '</tbody>
                </table>';
    }

    public function dtrSearch()
    {
        $input = $this->input->post(NULL, TRUE);
        $query = $this->masterfile_model->dtrSearch($input);
        echo '<ul class="list-group">';
        if (count($query) > 0) {
            foreach ($query as $row) {
                $condition = "empId = '$row[emp_id]' AND recordNo = '$row[record_no]'";
                $check      = $this->masterfile_model->selectAll_tcR_tk($input['server'], 'promo_sched_emp', $condition);
                if (count($check) > 0) {
                    $name       = htmlspecialchars($row['name']);
                    $emp_id     = $row['emp_id'];
                    $record_no  = $row['record_no'];
                    $data       = $name . '*' . $emp_id . '*' . $record_no . '*' . $check['statCut'];
                    echo    '<a href="javascript:;" class="list-group-item" onclick="selectDtr(\'' . $data . '\')">'
                        . $name .
                        '</a>';
                }
            }
        } else {
            echo '<a href="javascript:;" class="list-group-item">No Results Found!</a>';
        }
        echo    '</ul>';
    }

    public function dtrCutoff()
    {
        $input      = $this->input->post(NULL, TRUE);
        $statCut    = $input['statCut'];
        $empId      = $input['emp_id'];
        $recordNo   = $input['record_no'];
        $server     = $input['server'];
        $s          = $this->masterfile_model->selectAll_tcR_tk($server, 'promo_schedule', array('statCut' => $statCut));
        $startFC    = $s['startFC'];
        $endFC      = $s['endFC'];
        $startSC    = $s['startSC'];
        $endSC      = $s['endSC'];

        if ($endFC == '') {
            $endFC = 'last';
        }
        echo    '<h5 class="text-center">
                    List of Cut Off [<font color="red"> ' . $startFC . ' - ' . $endFC . ' | ' . $startSC . ' - ' . $endSC . ' </font>]
                </h5>';

        echo    '<table class="table table-hover table-sm" width="100%" id="dtrCutoffs">
                    <thead>
                        <tr>
                            <th>Date From</th>
                            <th>Date To</th>
                            <th class="text-center">Action</th>
                        </tr>
                    <thead>
                    <tbody>';

        for ($i = 1; $i <= 2; $i++) {
            $condition  = "statCut = '$statCut' GROUP BY dateFrom ORDER BY dateFrom DESC LIMIT 6";
            $cutoffType = $i == 1 ? '1stcutoff' : '2ndcutoff';
            $con        = $this->masterfile_model->selectAll_tcA_tk($input['server'], $cutoffType, $condition);

            foreach ($con as $c) {
                $dateFrom   = $c['dateFrom'];
                $dateTo     = $c['dateTo'];
                $dF         = strtotime($dateFrom);
                $dFrom      = date('F d, Y', strtotime($dateFrom));
                $dTo        = date('F d, Y', strtotime($dateTo));

                echo    "<tr>
                            <td><span style='display:none'>$dF</span>$dFrom</td>
                            <td>$dTo</td>
                            <td class='text-center'>
                                <a href='javascript:;' onclick='empDTR2(\"$empId\",\"$recordNo\",\"$dateFrom\",\"$dateTo\",\"$statCut\",\"$i\",\"$server\")'>
                                    <i class='fa fa-eye fa-lg'></i>
                                </a>
                            </td>
                        </tr>";
            }
        }

        echo        '</tbody>
                </table>';
    }

    public function promoDtr()
    {
        $input      = $this->input->post(NULL, TRUE);
        $empId      = $input['empId'];
        $recordNo   = $input['recordNo'];
        $statCut    = $input['statCut'];
        $server     = $input['server'];
        $dateFrom   = date('M. d, Y', strtotime($input['dateFrom']));
        $dateTo     = date('M. d, Y', strtotime($input['dateTo']));

        $cutOff     = ($input['i'] == 1) ? '1stcutoff' : '2ndcutoff';
        $id         = ($input['i'] == 1) ? 'fCOId' : 'sCOId';

        $bioM       = '';
        $condition  = "empId = '$empId' ORDER BY assignId DESC LIMIT 1";
        $b          = $this->masterfile_model->selectAll_tcR_tk($server, 'assign', $condition);

        $allowId = $b['allowId'];
        if ($allowId == "Biometric ID") {

            $bioM = $b['bioMetricId'];
        }

        if ($allowId == "Logbox ID") {

            $bioM = $b['barcodeId'];
        }

        $ass = $this->masterfile_model->promoDetails($server, $empId, $recordNo);

        $name               = ucwords(strtolower($ass['name']));
        $promo_company      = $ass['promo_company'];
        $promo_department   = $ass['promo_department'];
        $promo_type         = $ass['promo_type'];

        $condition  = "bioMetricId = '$bioM' AND dateFrom = '$input[dateFrom]' AND dateTo = '$input[dateTo]' ORDER BY $id DESC";
        $g = $this->masterfile_model->selectAll_tcR_tk($server, $cutOff, $condition);

        $dw = $totalOvertime = $legalHoliday = $specialHoliday = '';
        if (!empty($g)) {

            $dw             = $g['daysWork'];
            $totalOvertime  = $g['otForPayment'];
            $legalHoliday   = $g['legHol'];
            $specialHoliday = $g['speHol'];
        }

        if (!empty($totalOvertime)) {

            $totalOvertime = "$totalOvertime";
        } else {

            $totalOvertime = "0";
        }

        $sil        = 0;
        $sil_prev   = 0;
        $sil_cu     = 0;

        $cu = $this->masterfile_model->no_sil_current($server, $input);
        if (!empty($cu)) {

            $sil_cu = $cu['sil'];
        }

        $prev = $this->masterfile_model->no_sil_previous($server, $input);
        if (!empty($prev)) {

            $sil_prev = $prev['sil'];
        }

        $sil = $sil_prev + $sil_cu;

        $photo = $this->masterfile_model->selectAll_tcR($server, 'applicant', array('app_id' => $empId))['photo'];
        $pic = explode("../images/user/", $photo);
        $picture = end($pic);

        if (!file_exists("assets/img/user/$picture")) {

            $picture = "assets/img/user/user-1.png";
        } else {

            $picture = "assets/img/user/$picture";
        }

        $ser = ($input['server'] == 'cebu') ? 'colonnade' : $input['server'];
?>
        <input type="hidden" name="cut" value="<?php echo $input['i']; ?>">
        <input type="hidden" name="dateFrom" value="<?php echo $input['dateFrom']; ?>">
        <input type="hidden" name="dateTo" value="<?php echo $input['dateTo']; ?>">
        <input type="hidden" name="server" value="<?php echo $ser; ?>">
        <input type="hidden" name="cutoff" value="<?php echo $input['statCut']; ?>">
        <input type="hidden" name="chkEmpId[]" value="<?php echo $bioM; ?>">
        <div class="row">
            <div class="col-md-2">
                <img src="<?php echo base_url($picture); ?>" loading="lazy" alt="User Image" class="img-thumbnail" width="140">
            </div>
            <div class="col-md-10">
                <table class="table">
                    <tr>
                        <th width="13%">Fullname</th>
                        <td> : <?php echo $name; ?></td>
                        <th>Daysworked</th>
                        <td> : <?php echo $dw; ?></td>
                        <th>Legal Holiday</th>
                        <td> : <?php echo $legalHoliday; ?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td> : <?php echo $promo_company; ?></td>
                        <th>Overtime</th>
                        <td> : <?php echo $totalOvertime; ?></td>
                        <th>SIL</th>
                        <td> : <?php echo $sil; ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td> : <?php echo $promo_department; ?></td>
                        <th>Special Holiday</th>
                        <td colspan="3">: <?php echo $specialHoliday; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php if ($allowId != '') { ?>
            <div class="row">
                <div class="col-md-12">
                    <table id="dt_dtrEntry" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th class="d">Date</th>
                                <th>Day</th>
                                <th>IN1</th>
                                <th>OUT1</th>
                                <th>IN2</th>
                                <th>OUT2</th>
                                <th>IN3</th>
                                <th>OUT3</th>
                                <th>HW</th>
                                <th>DW</th>
                                <th>OT</th>
                                <th>App. Req</th>
                                <th class="text-center">E</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while (strtotime($dateFrom) <= strtotime($dateTo)) {

                                $day        = date('D', strtotime($dateFrom));
                                $dF         = date('Y-m-d', strtotime($dateFrom));

                                $dutyId     = '';
                                $in1_store  = $out1_store = $in2_store = $out2_store    = $in3_store = $out3_store = "";
                                $in1        = $out1 = $in2 = $out2 = $in3 = $out3 = "";

                                $tempDate   = date('Y-m-d', strtotime($dateFrom));

                                $condition  = "bioMetricId = '$bioM' AND date = '$tempDate' ORDER BY dutyId DESC";
                                $dtr        = $this->masterfile_model->selectAll_tcR_tk($server, 'duty', $condition);

                                @$dutyId    = $dtr['dutyId'];
                                @$in1       = $dtr['in1'];
                                @$out1      = $dtr['out1'];

                                @$in2       = $dtr['in2'];
                                @$out2      = $dtr['out2'];

                                @$in3       = $dtr['in3'];
                                @$out3      = $dtr['out3'];

                                // store entry
                                $in1_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $in1, "I");
                                $out1_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $out1, "O");
                                $in2_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $in2, "I");
                                $out2_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $out2, "O");
                                $in3_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $in3, "I");
                                $out3_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dF, $out3, "O");

                                if (empty($out3_store)) {
                                    $out3_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, date('Y-m-d', strtotime($dF . " +1 day")), $out3, "O");
                                }

                                if (!empty($in1)) {
                                    $in1 = date('h:i A', strtotime($in1));
                                }

                                if (!empty($out1)) {
                                    $out1 = date('h:i A', strtotime($out1));
                                }


                                if (!empty($in2)) {
                                    $in2 = date('h:i A', strtotime($in2));
                                }

                                if (!empty($out2)) {
                                    $out2 = date('h:i A', strtotime($out2));
                                }

                                if (!empty($in3)) {
                                    $in3 = date('h:i A', strtotime($in3));
                                }

                                if (!empty($out3)) {

                                    $out3 = date('h:i A', strtotime($out3));
                                }

                                $hours_work = 0;
                                $oT = 0;

                                $condition  = "dutyId = '$dutyId'";
                                $hoursWork  = $this->masterfile_model->selectAll_tcR_tk($server, 'perday', $condition);
                                if (!empty($hoursWork)) {

                                    $hours_work = $hoursWork['hoursWork'];
                                }

                                $res = explode("&", $hours_work);

                                if ($res[0] == "") {
                                    $res[0] = 0;
                                }

                                if (@$res[1] == "") {
                                    $res[1] = 0;
                                }

                                $h = floatval($res[0]) * 1;
                                $m = floatval($res[1]) * 1;

                                // days worked
                                $tempH = $h / 8;
                                $tempM = ($m / 60) / 8;
                                $tempM2 = ($m / 60);

                                $tempHM = $tempH + $tempM;
                                $newHM = round($tempHM, 3);

                                // hours worked
                                $min = round($tempM2, 3);
                                $hw = $h + $min;

                                // overtime
                                $otApp = 0;
                                $condition  = "emp_id = '$empId' AND otDate = '$tempDate' ORDER BY pay_id DESC";
                                $qt  = $this->masterfile_model->selectAll_tcR_tk($server, 'otforpayment', $condition);

                                if (!empty($qt)) {
                                    $otApp = $qt['otApp'];
                                }
                                $oT = floatval($otApp) * 1;

                                if (empty($oT) || $oT == 0) {
                                    $oT = 0;
                                }


                                $dayB = date('l', strtotime($dateFrom));
                                // check if holiday	

                                $nameH1 = '';
                                $cat1      = '';

                                $condition  = "date = '$tempDate' AND moveDate = '' LIMIT 1";
                                $ch  = $this->masterfile_model->selectAll_tcR_tk($server, 'holidays_promo', $condition);

                                if (!empty($ch)) {
                                    $nameH1 = $ch['nameHoliday'];
                                    $cat1      = $ch['category'];
                                }

                                $nameH2 = '';
                                $cat2      = '';

                                $condition  = "moveDate = '$tempDate' LIMIT 1";
                                $ch2  = $this->masterfile_model->selectAll_tcR_tk($server, 'holidays_promo', $condition);

                                if (!empty($ch2)) {
                                    $nameH2 = $ch2['nameHoliday'];
                                    $cat2      = $ch2['category'];
                                }

                                if (count($ch) != 0) {
                                    $nH     = "<span style = 'color:red'>$nameH1</span>";
                                    $cat     = "<span style = 'color:red'>$cat1</span>";
                                }
                                if (count($ch2) != 0) {
                                    $nH     = "<span style = 'color:red'>$nameH2</span>";
                                    $cat     = "<span style = 'color:red'>$cat2</span>";
                                }
                                // end of check if holiday	

                                // check if na assignan	

                                $yesHol = "";
                                $numODA = 0;
                                if (count($ch) != 0 || count($ch2) != 0) {
                                    $yesHol = "true";

                                    $condition  = "empId = '$empId' AND '$tempDate' BETWEEN dateFrom AND dateTo";
                                    $chkdateo  = $this->masterfile_model->selectAll_tcA_tk($server, 'assign_mul_sc', $condition);
                                    foreach ($chkdateo as $cht) {

                                        $amsId      = $cht['amsId'];
                                        $condition  = "amsId = '$amsId'";
                                        $numODA     = $this->masterfile_model->selectAll_tcR_tk($server, 'assign_mul_sc', $condition);
                                    }
                                }
                                // end of check if na assignan	

                                $countDO = 0;
                                $count   = 0;
                                $show_do = 0;
                                // check if na assignan sa day off	

                                $condition  = "empId = '$empId' AND status = 'active' AND status2 = 'Approved' AND '$tempDate' BETWEEN dateFrom AND dateTo ORDER BY id DESC";
                                $queryMSC  = $this->masterfile_model->selectAll_tcR_tk($server, 'assign_mul_sc', $condition);

                                if (is_array($queryMSC) && count($queryMSC)) {

                                    $amsId = $queryMSC['amsId'];

                                    //ge assignan ug dayoff pag CS
                                    $condition  = "amsId = '$amsId' AND empId = '$empId' AND date = '$tempDate'";
                                    $count  = $this->masterfile_model->selectAll_tcR_tk($server, 'ass_mul_do', $condition);

                                    //short term nga day-off request
                                    $condition  = "empId = '$empId' AND dateToChange = '$tempDate' AND status = 'Approved'";
                                    $queryCDO  = $this->masterfile_model->selectAll_tcR_tk($server, 'ass_change_do', $condition);

                                    //ge assignan ug new day-off pero walay change day-off nga request
                                    if (count($count) && count($queryCDO) == 0) {
                                        $show_do = 1;
                                    }

                                    //na assignan ug new day-off sa supv pero nag request ug change day-off ang emp. vice versa
                                    $condition  = "empId = '$empId' AND dateNew = '$tempDate' AND status = 'Approved'";
                                    $queryCDO  = $this->masterfile_model->selectAll_tcR_tk($server, 'ass_change_do', $condition);

                                    if ($queryCDO) {
                                        // echo $queryCDO."".$tempDate."<br>";

                                        // ge change day-off pag human ug cs sa supv
                                        $select     = 'tb1.time, tb1.date, tb2.dateToChange';
                                        $tb1        = 'approveby as tb1';
                                        $tb2        = 'ass_change_do as tb2';
                                        $join       = 'tb2.acdId=tb1.requestId';
                                        $condition  = "tb2.empId = '$empId' AND tb2.dateNew = '$tempDate' AND tb1.requestType = 'CDOS' AND tb2.status = 'Approved'";
                                        $query      = $this->masterfile_model->join_tkR($server, $select, $tb1, $tb2, $join, $condition);

                                        if (count($query)) {

                                            $dateApp        = $query['date'];
                                            $timeApp        = $query['time'];
                                            $dateToChange   = $query['dateToChange'];

                                            //date & time sa pag approved sa supvr
                                            $app_details    = date("Y-m-d H:i:s", strtotime("$dateApp $timeApp"));

                                            $select     = 'dateReq, timeReq';
                                            $tb1        = 'ass_mul_do as tb1';
                                            $tb2        = 'request_new_shift as tb2';
                                            $join       = 'tb2.amsId=tb1.amsId';
                                            $condition  = "tb1.empId = '$empId' AND tb1.date = '$dateToChange' LIMIT 1";
                                            $query      = $this->masterfile_model->join_tkR($server, $select, $tb1, $tb2, $join, $condition);
                                            if (count($query)) {
                                                $dateReq = $query['dateReq'];
                                                $timeReq = $query['timeReq'];

                                                $req_details    = date("Y-m-d H:i:s", strtotime("$dateReq $timeReq"));
                                                if ($app_details > $req_details) {
                                                    $show_do = 1;
                                                }
                                            }
                                        }
                                    }
                                }

                                //wala na assign ug new day-off sa change shift pero nag request ug change day-off
                                $old_do = 0;
                                $req_do = 0;

                                // PHP >= 7.3
                                // if(is_countable($searchdata)) {
                                //     // Do something
                                // }

                                // // PHP >= 7.1
                                // if(is_iterable($searchdata)) {
                                //     // Do something
                                // }

                                if (is_array($queryMSC) && count($queryMSC) == 0) {
                                    //petsa nga bag-o ang day-off
                                    $condition  = "empId = '$empId' AND dateNew = '$tempDate' AND status = 'Approved'";
                                    $queryCDO  = $this->masterfile_model->selectAll_tcR_tk($server, 'ass_change_do', $condition);

                                    if ($queryCDO) {
                                        $req_do  = 1;
                                        $show_do = 1;
                                    }

                                    //petsa nga ang day-off ilisdan ug dili e display
                                    $condition  = "empId = '$empId'' AND dateToChange = '$tempDate' AND status = 'Approved'";
                                    $queryCDO  = $this->masterfile_model->selectAll_tcR_tk($server, 'ass_change_do', $condition);
                                    if ($queryCDO) {
                                        $old_do = 1;
                                    }
                                }

                                // default day-off
                                if (is_array($queryMSC) && count($queryMSC) == 0 && $show_do == 0 && $old_do == 0) {

                                    $day2 = date('l', strtotime($tempDate));

                                    $condition  = "empId = '$empId' AND day = '$day2'";
                                    $show_do  = $this->masterfile_model->selectAll_tcR_tk($server, 'assign_day_off', $condition);
                                }

                                //if ge offdutyhan
                                $condition  = "empId = '$empId' AND '$tempDate' BETWEEN dateFrom AND dateTo AND remark != ''";
                                $numODA  = $this->masterfile_model->selectAll_tcR_tk($server, 'assign_mul_sc', $condition);
                                if (count($numODA)) {
                                    $show_do = 0;
                                }

                                /* // check if na assignan sa day off	
										$sql_do = "SELECT amsId FROM assign_mul_sc WHERE empId = '".$fetch['empId']."' AND
																status = 'active' AND status2 = 'Approved' AND '".$tempDate."' BETWEEN dateFrom AND dateTo 
																ORDER BY id DESC";
										$amsId 	= $this->dtr_model->return_data_row_array($tk, $sql_do)['amsId'];

										$show_do = 0;
										if(!empty($amsId)){

											$sq_do = "SELECT count(ass_mul_do.empId) as numDO FROM ass_mul_do WHERE 
																  ass_mul_do.amsId = '".$amsId."' AND ass_mul_do.empId = '".$fetch['empId']."' AND ass_mul_do.date = '".$tempDate."'";
											$numDO = $this->dtr_model->return_data_row_array($tk, $sq_do)['numDO'];
											if($numDO != 0){
												$show_do = 1;
											}
										}

										if(empty($amsId)){
											$sq_do = "SELECT count(assign_day_off.empId) as numDO FROM assign_day_off WHERE 
																  assign_day_off.empId = '".$fetch['empId']."' AND assign_day_off.day = '".$dayB."'";
											$numDO = $this->dtr_model->return_data_row_array($tk, $sq_do)['numDO'];
											if($numDO != 0){
												$show_do = 1;
											}
										}
									// end of check if na assignan sa day off	

									// if nag change day off short term	
										// new assign day -off
											$sq_do = "SELECT count(ass_change_do.empId) as numDO, ass_change_do.dateNew, approveby.date, approveby.time 
																  FROM ass_change_do, approveby WHERE 
																  ass_change_do.acdId = approveby.requestId AND approveby.requestType = 'CDOS' AND
																  ass_change_do.empId = '".$fetch['empId']."' AND ass_change_do.dateNew = '".$tempDate."' AND ass_change_do.status = 'Approved'";
											$s_do  = $this->dtr_model->return_data_row_array($tk, $sq_do);
											$numDO 	 = $s_do['numDO'];	
											$dateReq = $s_do['date'];	
											$timeReq = $s_do['time'];
											$dateNew = $s_do['dateNew'];

											if($numDO != 0){
												$show_do = 1;
												// check if naa assignan ug utro balik
													$sql_do ="SELECT amsId FROM assign_mul_sc WHERE empId = '".$fetch['empId']."' AND
																			status = 'active' AND status2 = 'Approved' AND '".$tempDate."' BETWEEN dateFrom AND dateTo 
																			ORDER BY id DESC";
													$amsId 	= $this->dtr_model->return_data_row_array($tk, $sql_do)['amsId'];		
													
													//check kon unsa nga day-off ge assign
														$sql_do 	 = "SELECT ass_mul_do.date FROM ass_mul_do WHERE 
																				empId = '".$fetch['empId']."' AND amsId = '".$amsId."'";
														$date_off_cs = $this->dtr_model->return_data_row_array($tk, $sql_do)['date'];									
														
													$consh  	= "SELECT dateReq, timeReq FROM request_new_shift WHERE 
																		  		amsId = '".$amsId."'";
													$con    	= $this->dtr_model->return_data_row_array($tk, $consh);
													$dateReq_sc = $con['dateReq'];
													$timeReq_sc = $con['timeReq'];
																							
													$date_req 	 = date("Y-m-d H:i:s", strtotime("$dateReq $timeReq"));																
													$date_req_sc = date("Y-m-d H:i:s", strtotime("$dateReq_sc $timeReq_sc"));

													if(strtotime($date_req_sc) > strtotime($date_req) && $dateNew != $date_off_cs && !empty($date_off_cs)){
														$show_do = 0;
													}
												// end of if check if naa assignan ug utro balik
											}	
										// end of new assign day -off	


										$sq_do 	 = "SELECT count(ass_change_do.empId) as numDO, approveby.date, approveby.time, ass_change_do.dateNew
															  FROM ass_change_do, approveby WHERE 
															  ass_change_do.acdId = approveby.requestId AND approveby.requestType = 'CDOS' AND
															  ass_change_do.empId = '".$fetch['empId']."' AND ass_change_do.dateToChange = '".$tempDate."' AND ass_change_do.status = 'Approved'";
										$s_do  	 	= $this->dtr_model->return_data_row_array($tk, $sq_do);
										$numDO 	 	= $s_do['numDO'];	
										$dateReq 	= $s_do['date'];	
										$timeReq 	= $s_do['time'];	
										$dateNew 	= $s_do['dateNew'];	

										if($numDO != 0){
											$show_do = 0;

												// check if naa assignan ug utro balik
													$sql_do = "SELECT amsId FROM assign_mul_sc WHERE empId = '".$fetch['empId']."' AND
																			status = 'active' AND status2 = 'Approved' AND '$tempDate' BETWEEN dateFrom AND dateTo 
																			ORDER BY id DESC";
													$amsId 	= $this->dtr_model->return_data_row_array($tk, $sql_do)['amsId'];	
													
													//check kon unsa nga day-off ge assign
														$sql_do 	 = "SELECT ass_mul_do.date FROM ass_mul_do WHERE 
																				ass_mul_do.empId = '".$fetch['empId']."' AND ass_mul_do.amsId = '".$amsId."'";
														$date_off_cs = $this->dtr_model->return_data_row_array($tk, $sql_do)['date'];									


													$consh  	= "SELECT request_new_shift.dateReq, timeReq FROM request_new_shift WHERE 
																		  		request_new_shift.amsId = '".$amsId."'";
													$con    	= $this->dtr_model->return_data_row_array($tk, $consh);
													$dateReq_sc = $con['dateReq'];
													$timeReq_sc = $con['timeReq'];		
													
													$date_req 	 = date("Y-m-d H:i:s", strtotime("$dateReq $timeReq"));																
													$date_req_sc = date("Y-m-d H:i:s", strtotime("$dateReq_sc $timeReq_sc"));												

													if($date_req_sc  > $date_req && !empty($dateReq_sc) && $dateNew != $date_off_cs && !empty($date_off_cs)){
														$show_do = 1;
													}
										}	
									
									// check if na off dutyhan ba	
										if($show_do == 1){

											$sql_m_d = "SELECT amsId FROM assign_mul_sc WHERE 
																     empId = '".$fetch['empId']."' AND ('".$tempDate."' BETWEEN dateFrom AND dateTo) ORDER BY id DESC";
											// $query_sql_m_d = $this->dtr_model->return_data_result_array($tk, $sql_m_d);
											$amsId = @$this->dtr_model->return_data_result_array($tk, $sql_m_d)['amsId'];
											// foreach ($query_sql_m_d as $sq_m) {

											// 	$amsId 	= $sq_m['amsId'];	

												$consh_m  	= "SELECT count(request_odaf.amsId) as numODA FROM request_odaf WHERE 
																	  	   request_odaf.amsId = '".$amsId."'";
												$numODA_m   = $this->dtr_model->return_data_row_array($tk, $consh_m)['numODA'];
												if($numODA_m != 0){
													$show_do = 0;
												}
											// }											
										}
												
									// end of check if na off duty va */

                                // check all request


                                //loa
                                $condition  = "r_l_absence.empId = '$empId' AND r_l_absence.empId = rla_day.empId AND rla_day.date = '$tempDate' AND
                            '$tempDate' BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT AND status = 'Approved'";
                                $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'r_l_absence, rla_day', $condition);
                                $numLOA     = count($sq_req);
                                //end of loa

                                //dwa
                                $condition  = "d_w_adjustment.empId = '$empId' AND d_w_adjustment.empId = off_date.empId AND off_date.date = '$tempDate' AND
                            '$tempDate' BETWEEN d_w_adjustment.dateFrom AND d_w_adjustment.dateTo AND status = 'Approved'";
                                $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'd_w_adjustment, off_date', $condition);
                                $numDWA     = count($sq_req);

                                if ($numDWA == 0) {

                                    $condition  = "empId = '$empId' AND (type = 'Failure' OR type = 'System Error' OR type = 'Wrong Mode') AND
                               '$tempDate' BETWEEN dateFrom AND dateTo AND status = 'Approved'";
                                    $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'd_w_adjustment', $condition);
                                    $numDWA     = count($sq_req);
                                }
                                //end of dwa

                                /*//eoa
										$sql_req = "SELECT count(e_o_authorization.status) as numEOA FROM e_o_authorization WHERE e_o_authorization.empId = '$empId' AND
																e_o_authorization.dateOvertime = '$tempDate' AND status = 'Approved'";
										$sq_req = $this->dtr_model->return_data_row_array($tk, $sql_req);
										$numEOA	 = $sq_req['numEOA'];*/
                                //end of eoa

                                //EOP
                                $condition  = "emp_id = '$empId' AND otDate = '$tempDate' AND status = 'Approved'";
                                $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'otforpayment', $condition);
                                $numEOP     = count($sq_req);
                                $ot_pay     = floatval($sq_req['otApp']) * 1;
                                //end of EOP

                                //ECA
                                $condition  = "empId = '$empId' AND cuDate = '$tempDate' AND status = 'Approved'";
                                $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'coverup_auth', $condition);
                                $numECA     = count($sq_req);
                                //end of ECA

                                //EUA
                                $condition  = "empId = '$empId' AND dateUndertime = '$tempDate' AND status = 'Approved'";
                                $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'undertime_auth', $condition);
                                $numEUA     = count($sq_req);
                                //end of EUA

                                // check if served suspension	
                                /*$sql_req = "SELECT sched_suspension.empId FROM sched_suspension WHERE sched_suspension.empId = '$empId' AND
																sched_suspension.dateSched = '$tempDate'";
										$numSUS  = $this->dtr_model->return_num_rows($sql_req);	*/
                                // $numSUS  = $this->dtr_model->count_served_suspension($tempDate, $empId)['numSUS'];
                                // end of check if served suspension

                                $LOA = "";
                                if ($numLOA != 0) {
                                    $LOA = "LOA";
                                }

                                $numSIL = 0;
                                if ($numLOA != 0) {

                                    //sil
                                    $condition  = "r_l_absence.empId = '$empId' AND r_l_absence.empId = rla_day.empId AND rla_day.date = '$tempDate' AND
                                '$tempDate' BETWEEN r_l_absence.incDate_sF AND r_l_absence.incDate_sT AND status = 'Approved' AND
                                (if_emer_pers LIKE '%Service Incentive Leave%' OR if_emer_pers LIKE '%SIL%' OR if_emer_pers LIKE '%S.I.L%')";
                                    $sq_req     = $this->masterfile_model->selectAll_tcR_tk($server, 'r_l_absence, rla_day', $condition);
                                    $numSIL    = count($sq_req);
                                    //end of sil

                                    if ($numSIL != 0) {
                                        $LOA = "SIL";
                                    }
                                }

                                $DWA = "";
                                if ($numDWA != 0) {
                                    $DWA = "DWA";
                                }
                                $EOA = "";
                                /*if($numEOA != 0){
										$EOA = "EOA";
									}*/
                                $EOP = "";
                                if ($numEOP != 0) {
                                    $EOP = "EOP";
                                }
                                $ECA = "";
                                if ($numECA != 0) {
                                    $ECA = "ECA";
                                }
                                $EUA = "";
                                if ($numEUA != 0) {
                                    $EUA = "EUA";
                                }
                                $SUS = "";
                                /*if($numSUS != 0){
										$SUS = "SS";
									}*/

                                $no_schedule = "";
                                if ($promo_type == 'ROVING') {

                                    $condition  = "empId = '$empId' AND dateRendered = '$tempDate' ORDER BY pId DESC";
                                    $num_store  = $this->masterfile_model->selectAll_tcR_tk($server, 'promo_mul_sc', $condition);
                                    $no_store   = '';
                                    if (!empty($num_store)) {

                                        $no_store = $num_store['noStore'];
                                    }
                                    // echo $tempDate."=".$no_store."<br>";
                                    if ($no_store == '') {

                                        $condition  = "empId = '$empId' AND day_sched = '$day' ORDER BY pdId DESC";
                                        $no_stores     = $this->masterfile_model->selectAll_tcR_tk($server, 'promo_def_sched', $condition);
                                        if (!empty($no_stores)) {
                                            $no_store = $no_stores['noStore'];
                                        }
                                        if ($no_store != '') {

                                            $no_schedule = 'true';
                                        }
                                    } else {

                                        if ($no_store == 0) {

                                            $no_schedule = 'true';
                                        } else {

                                            $no_schedule = '';
                                        }
                                    }
                                } else {

                                    $condition  = "empId = '$empId' AND status = 'active' AND status2 = 'Approved' AND '$tempDate' BETWEEN dateFrom AND dateTo ORDER BY id DESC";
                                    @$amsId    = $this->masterfile_model->selectAll_tcR_tk($server, 'assign_mul_sc', $condition)['amsId'];

                                    $condition  = "empId = '$empId' AND amsId = '$amsId' AND date = '$tempDate'";
                                    $no_sched    = $this->masterfile_model->selectAll_tcR_tk($server, 'promo_nosched', $condition)['amsId'];
                                    if (count($no_sched) == 1) {
                                        $no_schedule = "true";
                                    }
                                }

                                if ($yesHol == "true" && $numODA == 0) {

                                    echo    "<tr>
											<td>$dateFrom</td>
											<td>$day</td>
											<td colspan='10' align='center'>$nH [ $cat ]</td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
											<td align='center'><a href='javascript:viewTime(\"$server\",\"$empId\",\"$dateFrom\")'><i class='fa fa-eye'></i></a></td>
										</tr>";
                                } else if ($show_do == 1) {

                                    echo    "<tr>
											<td>$dateFrom</td>
											<td>$day</td>
											<td colspan='11' align='center' style = 'color:red'>DAY-OFF</td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
									    </tr>";
                                } else if ($no_schedule == "true") {

                                    echo    "<tr>
											<td>$dateFrom</td>
											<td>$day</td>
											<td colspan='11' align='center' style = 'color:red'>NO SCHEDULE</td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
                                            <td style='display:none'></td>
									    </tr>";
                                } else {

                                    echo    '<tr>
											<td>' . $dateFrom . '</td>
											<td>' . $day . '</td>
											<td>' . $in1_store . '' . $in1 . '</td>
											<td>' . $out1_store . '' . $out1 . '</td>
											<td>' . $in2_store . '' . $in2 . '</td>
											<td>' . $out2_store . '' . $out2 . '</td>
											<td>' . $in3_store . '' . $in3 . '</td>
											<td>' . $out3_store . '' . $out3 . '</td>
											<td>' . $hw . '</td>
											<td>' . $newHM . '</td>
											<td>' . $oT . '</td>
											<td>' . $LOA . ' ' . $DWA . ' ' . $EOA . ' ' . $EOP . ' ' . $ECA . ' ' . $EUA . ' ' . $SUS . '</td>';
                                    echo        "<td align='center'><a href='javascript:viewTime(\"$server\",\"$empId\",\"$dateFrom\")'><i class='fa fa-eye'></i></a></td>
									    </tr>";
                                }

                                $dateFrom = date('M. d, Y', strtotime($dateFrom . "+1 day"));
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        }
        // Previous Cut Off
        $condition = array('empId' => $empId, 'coDF1' => $input['dateFrom'], 'coDF2' => $input['dateTo']);
        $sql  = $this->masterfile_model->selectAll_tcA_tk($server, 'perday_previous', $condition);
        if (count($sql) > 0) { ?>
            <br>
            <div class="row">
                <div class="col-md-12 table-responsive">

                    <table class="table table-md table-stripped" width="100%">
                        <thead>
                            <tr>
                                <th colspan="13">Previous Cut Off</th>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>IN1</th>
                                <th>OUT1</th>
                                <th>IN2</th>
                                <th>OUT2</th>
                                <th>IN3</th>
                                <th>OUT3</th>
                                <th class="text-center">HW</th>
                                <th class="text-center">DW</th>
                                <th class="text-center">OT</th>
                                <th class="text-center">App. Request</th>
                                <th>E</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($sql as $nf) {

                                $dateDuty   = $nf['dateDuty'];
                                $dateFrom   = date('M. d, Y', strtotime($nf['dateDuty']));

                                $hw_new     = floatval($nf['hw_new']);
                                $hw_con     = $nf['hw_con'] + 0;
                                $request    = $nf['request'];
                                $dayS       = date("D", strtotime($dateDuty));
                                $dateD      = date("M. d, Y", strtotime($dateDuty));

                                $condition  = array('bioMetricId' => $bioM, 'date' => $dateDuty);
                                $dtr        = $this->masterfile_model->selectAll_tcR_tk($server, 'duty', $condition);
                                $dutyId     = $dtr['dutyId'];
                                $in1        = $dtr['in1'];
                                $out1       = $dtr['out1'];

                                $in2        = $dtr['in2'];
                                $out2       = $dtr['out2'];

                                $in3        = $dtr['in3'];
                                $out3       = $dtr['out3'];

                                // store entry
                                $in1_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $in1, "I");
                                $out1_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $out1, "O");
                                $in2_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $in2, "I");
                                $out2_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $out2, "O");
                                $in3_store  = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $in3, "I");
                                $out3_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, $dateDuty, $out3, "O");

                                if (empty($out3_store)) {
                                    $out3_store = $this->masterfile_model->store_entry($server, $bioM, $allowId, date('Y-m-d', strtotime($dateDuty . " +1 day")), $out3, "O");
                                }

                                if (!empty($in1)) {
                                    $in1 = date('h:i A', strtotime($in1));
                                }

                                if (!empty($out1)) {
                                    $out1 = date('h:i A', strtotime($out1));
                                }

                                if (!empty($in2)) {
                                    $in2 = date('h:i A', strtotime($in2));
                                }

                                if (!empty($out2)) {
                                    $out2 = date('h:i A', strtotime($out2));
                                }

                                if (!empty($in3)) {
                                    $in3 = date('h:i A', strtotime($in3));
                                }

                                if (!empty($out3)) {

                                    $out3 = date('h:i A', strtotime($out3));
                                }

                                echo "<tr>
                                        <td><span class='date_$dutyId'>$dateD</span></td>
                                        <td>$dayS</td>
                                        <td>" . $in1_store . "" . $in1 . "</td>
                                        <td>" . $out1_store . "" . $out1 . "</td>
                                        <td>" . $in2_store . "" . $in2 . "</td>
                                        <td>" . $out2_store . "" . $out2 . "</td>
                                        <td>" . $in3_store . "" . $in3 . "</td>
                                        <td>" . $out3_store . "" . $out3 . "</td>
                                        <td align='center'>$hw_new</td>
                                        <td align='center'>$hw_con</td>
                                        <td align='center'>0</td>
                                        <td align='center'>$request</td>
                                        <td align='center'><a href='javascript:viewTime(\"$server\",\"$empId\",\"$dateFrom\")'><i class='fa fa-eye'></i></a></td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php
        }
    }

    public function vTEntry()
    {
        $input  = $this->input->post(NULL, TRUE);
        $server = $input['server'];
        $empId  = $input['empId'];
        $date   = $input['dateRendered'];
        $nDate  = date('m-d-Y', strtotime($date));

        echo    '<table class = "table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Mode</th>
                            <th>Terminal</th>
                            <th>Store</th>
                        </tr>
                    </thead>
                    <tbody>';

        $bio        = '';
        $condition  = "empId = '$empId' ORDER BY assignId DESC LIMIT 1";
        $g          = $this->masterfile_model->selectAll_tcR_tk($server, 'assign', $condition);

        $allowId    = $g['allowId'];
        if ($allowId == "Biometric ID") {

            $bio        = $g['bioMetricId'];
            $condition  = "bioMetricId = '$bio' AND date = '$nDate' ORDER BY ADDTIME(timeIn,timeOut) ASC";
            $con        = $this->masterfile_model->selectAll_tcA_tk($server, 'duty_biometric', $condition);
        }

        if ($allowId == "Logbox ID") {

            $bio        = $g['barcodeId'];
            $condition  = "bioMetricId = '$bio' AND date = '$nDate' ORDER BY ADDTIME(timeIn,timeOut) ASC";
            $con        = $this->masterfile_model->selectAll_tcA_tk($server, 'duty_logbox', $condition);
        }

        foreach ($con as $c) {

            $bioM       = $c['bioMetricId'];
            $date       = $c['date'];
            $mode       = $c['mode'];
            $timeIn     = $c['timeIn'];
            $timeOut    = $c['timeOut'];

            $exp        = explode("-", $date);
            $fromDate   = "$exp[2]-$exp[0]-$exp[1]";

            $condition  = "bioMetricId = '$bioM' AND dateDuty = '$fromDate' AND timeIn = '$timeIn' AND timeOut = '$timeOut'";
            $store      = $this->masterfile_model->selectAll_tcR_tk($server, 'duty_logbox', $condition)['store'];

            if ("$timeOut" == "0") {
                $time = $timeIn;
            }

            if ("$timeIn" == "0") {
                $time = $timeOut;
            }

            echo    "<tr>
                        <td>$date</td>
                        <td>$time</td>
                        <td>$mode</td>
                        <td>$allowId</td>
                        <td>$store</td>
                    </tr>";
        }

        echo        "</tbody>
                </table>";
    }
}
