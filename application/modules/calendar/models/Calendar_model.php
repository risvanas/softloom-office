<?php

class Calendar_model extends CI_Model {

    function acc_insert($table, $data) {
        $this->db->insert($table, $data);
    }

    function selectCalendar($year, $month) {
        $this->db->select('*');
        $this->db->from('tbl_calendar');
        if($year != ''){
            $this->db->where("YEAR(CAL_DATE)", $year);
        }
        if($month != ''){
            $this->db->where("MONTH(CAL_DATE)", $month);
        }
        $this->db->order_by("CAL_DATE", "asc");
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
    
    function select_attendance($year, $month, $staff_status) {
        $sql = "CALL get_monthly_attendance(?, ?, ?)";
        $query = $this->db->query($sql, array('year' => $year, 'month' => $month, 'staff_status' => $staff_status));
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

//    function sel_data($table, $condition = array()) {
//        if (!empty($condition)) {
//            foreach ($condition as $key => $value) {
//                $this->db->where($key, $value);
//            }
//        }
//        $res = $this->db->get($table);
//        return $res;
//    }

}

?>