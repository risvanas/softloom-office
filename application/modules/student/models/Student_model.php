<?php

class Student_model extends CI_Model {

    function stud_insert($tab, $dat) {
        $this->db->insert($tab, $dat);
    }

    function selectAll($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DEL_FLAG =1');
        $query = $this->db->get();
        return $query;
    }

    function edit($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('STUDENT_ID =' . "'" . $id . "'");
        $this->db->where('DEL_FLAG =1');
        $query = $this->db->get();
        return $query;
    }

    function stud_update($table, $data, $id) {
        $this->db->where('STUDENT_ID =' . "'" . $id . "'");
        $this->db->update($table, $data);
    }

    function delete($table, $id, $dat) {
        $this->db->where('STUDENT_ID', $id);
        $this->db->update($table, $dat);
    }

    function sel_course($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('PARENT_ACC_ID', '31');
        $this->db->where('DEL_FLAG', 1);
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function select_status($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('B_FLAG', 'TRAINING');
        $this->db->order_by("status", "asc");
        $query = $this->db->get();
        return $query;
    }

    function select_district($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by("DISTRICT", "asc");
        $query = $this->db->get();
        return $query;
    }

    function join_course_list() {
        $this->db->select('*');
        $this->db->from('tbl_student');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_student.COURSE');
        $this->db->join('tbl_status', 'tbl_status.id=tbl_student.STATUS');
        $this->db->where('tbl_student.DEL_FLAG =1');
        $this->db->where('tbl_student.STATUS !=8');
        $this->db->where('tbl_student.STATUS !=9');
        $res = $this->db->get();
        return $res;
    }

    function select_reg_date($dat1, $dat2) {
        $this->db->select('*');
        $this->db->from('tbl_student');
        $this->db->join('tbl_account', 'tbl_student.COURSE=tbl_account.ACC_ID');
        $this->db->where('tbl_student.REG_DATE >=', $dat1);
        $this->db->where('tbl_student.REG_DATE <=', $dat2);
        $this->db->where('tbl_student.DEL_FLAG =1');
        $this->db->where('tbl_student.STATUS !=8');
        $res = $this->db->get();
        return $res;
    }

    function select_due_date($dat1, $dat2) {
        $this->db->select('*');
        $this->db->from('tbl_student');
        $this->db->where('DUE_DATE >=', $dat1);
        $this->db->where('DUE_DATE <=', $dat2);
        $res = $this->db->get();
        return $res;
    }

    function select_sal($table, $id) {
        $this->db->where('SRC_ID', $id);
        $this->db->where('BOOK_NAME', 'SAl');
        $query = $this->db->get($table);
        return $query;
    }

    function trans_update($table, $data, $id) {
        $this->db->where('SRC_ID =' . "'" . $id . "'");
        $this->db->update($table, $data);
    }

    function multipe_select($from, $to, $dtype, $course, $stat, $key_words, $sort_by) {

        $this->db->select('*');
        $this->db->from('tbl_student');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_student.COURSE');
        $this->db->join('tbl_status', 'tbl_status.id=tbl_student.STATUS');
        $this->db->where('tbl_student.DEL_FLAG =1');
        //$this->db->where('tbl_student.STATUS !=8');
        if ($course == "" && $key_words == "" && $stat == "" && $dtype != "" && $from == "1970-01-01" && $to == "1970-01-01") {
            $this->db->where('tbl_student.STATUS!=8');
        }
        if ($course != "") {
            $this->db->where('tbl_student.COURSE', $course);
        }
        if ($stat != "") {
            $this->db->where('tbl_student.STATUS', $stat);
        }
        if ($key_words != "") {
            $this->db->like('tbl_student.NAME', $key_words);
            $this->db->or_like('tbl_student.CONTACT_NO', $key_words);
            $this->db->or_like('tbl_student.CONTACT_NO2', $key_words);
        }
        if ($dtype != "" && $from != "1970-01-01") {
            $this->db->where('tbl_student.' . $dtype . ' >=', $from);
        }
        if ($dtype != "" && $to != "1970-01-01") {
            $this->db->where('tbl_student.' . $dtype . ' <=', $to);
        }
//		if($dtype!="" && $from!="1970-01-01"&& $to!="1970-01-01")
//		{
//			$this->db->where('tbl_student.'.$dtype.' >=',$from);
//			$this->db->where('tbl_student.'.$dtype.' <=',$to);
//		}
        if ($sort_by != "") {
            $this->db->order_by("tbl_student." . $sort_by, "asc");
        }
        $res = $this->db->get();
        return $res;
    }
	function select_year($year_code)
	{
		$this->db->select('FROM_DATE,TO_DATE');
		$this->db->from('tbl_accounting_year');
		$this->db->where('AY_ID',$year_code);
		$query = $this->db->get();
        return $query;
	}
    function select_company($company_id = "") {
        $this->db->select('*');
        $this->db->from('tbl_company');
        if($company_id != "") {
            $this->db->where('ID', $company_id);
        }
        $res = $this->db->get();
        return $res;
    }
}

?>