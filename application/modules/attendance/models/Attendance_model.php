<?php

class Attendance_model extends CI_Model {

    function selectStaff($id = '') {
        $this->db->select('tbl_account.*, tbl_designation.designation');
        $this->db->from('tbl_account');
        $this->db->join('tbl_designation', 'tbl_account.DESIGNATION = tbl_designation.id');
        $this->db->where('ACC_MODE=', 'STAFF');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        if ($id != '') {
            $this->db->where('ACC_ID', $id);
        }
        $this->db->order_by("ACC_NAME", "asc");
        $res = $this->db->get();
        return $res;
    }

    function selectYear() {
        $sql = "CALL get_timetrack_year()";
        $query = $this->db->query($sql);
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function selectMonth($year) {
        $sql = "CALL get_timetrack_month(?)";
        $query = $this->db->query($sql, array('year' => $year));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function select_individual_attendance($staff, $year, $month) {
        $sql = "CALL get_individual_attendance(?, ?, ?)";
        $query = $this->db->query($sql, array('year' => $year, 'month' => $month, 'staff' => $staff));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function select_daywise_attendance($date) {
        $sql = "CALL get_daywise_attendance(?)";
        $query = $this->db->query($sql, array('day' => $date));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function selectCalendar($year = '', $month = '', $date = '') {
        $this->db->select('*');
        $this->db->from('tbl_calendar');
        if ($year != '') {
            $this->db->where("YEAR(CAL_DATE)", $year);
        }
        if ($month != '') {
            $this->db->where("MONTH(CAL_DATE)", $month);
        }
        if ($date != '') {
            $this->db->where("CAL_DATE", $date);
        }
        $this->db->order_by("CAL_DATE", "asc");
        $res = $this->db->get();
        return $res;
    }

    function add_wrk_frm_hme($staff, $date, $from, $to) {
        $otherdb = $this->load->database('otherdb', TRUE);
        $otherdb->select_max('work_hme_id');
        $otherdb->from('PunchTimeDetails');
        $wrk_id = $otherdb->get()->row();
        $ins_data = array(
            'tktno' => $staff,
            'hhmm' => 0,
            'tmmm' => 0,
            'hh_mm' => 0,
            'flag' => 'HOME',
            'work_hme_id' => $wrk_id->work_hme_id + 1
        );
        if($date != "" && $date != '1970-01-01') {
            if($from != "" && $from != "00:00:00") {
                $ins_data['date'] = $date . " " . $from;
                $otherdb->insert('PunchTimeDetails', $ins_data);
            }
            if($to != "" && $to != "00:00:00") {
                $ins_data['date'] = $date . " " . $to;
                $otherdb->insert('PunchTimeDetails', $ins_data);
            }
        }
    }

    function delete_wrk_frm_hme($id) {
        $otherdb = $this->load->database('otherdb', TRUE);
        $otherdb->where('work_hme_id', $id);
        $otherdb->delete('PunchTimeDetails');
    }

    function select_hme_attendance($year, $month) {
        $otherdb = $this->load->database('otherdb', TRUE);
        $otherdb->distinct();
        $otherdb->select('`tktno`,DATE(date) as DATE, TIME(MIN(date)) as punch_in, TIME(MAX(date)) as punch_out,work_hme_id');
        $otherdb->from('PunchTimeDetails');
        $otherdb->where('flag', 'HOME');
        $otherdb->where('YEAR(date)', $year);
        $otherdb->where('MONTH(date)', $month);
        $otherdb->group_by("tktno");
        $otherdb->group_by("DATE(date)");
        $otherdb->order_by("date", "asc");
        $res = $otherdb->get();
        return $res;
    }

    function sel_record($id) {
        $otherdb = $this->load->database('otherdb', TRUE);
        $otherdb->distinct();
        $otherdb->select('`tktno`,DATE(date) as DATE, TIME(MIN(date)) as punch_in, TIME(MAX(date)) as punch_out');
        $otherdb->from('PunchTimeDetails');
        $otherdb->where('flag', 'HOME');
        $otherdb->where('work_hme_id', $id);
        $res = $otherdb->get();
        return $res;
    }

}

?>