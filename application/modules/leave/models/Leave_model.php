<?php

class Leave_model extends CI_Model {

    function acc_insert($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_leave($staff_id = '', $from = '', $to = '', $selection = '') {
        $this->db->select('leave.*, stf.ACC_NAME, aprver.ACC_NAME as APPROVED_BY');
        $this->db->from('tbl_leave leave');
        $this->db->join('tbl_account stf', 'stf.ACC_ID = leave.STAFF_ID');
        $this->db->join('tbl_account aprver', 'aprver.ACC_ID = leave.PM_APPROVED_BY', 'left');
        $this->db->where('leave.DEL_FLAG =1');
        if ($staff_id != "") {
            $this->db->where("leave.STAFF_ID", $staff_id);
        }
        if ($from != "" && $from != "1970-01-01") {
            $this->db->where("leave.CREATED_ON >= ", $from . ' 00:00:00');
        }
        if ($to != "" && $to != "1970-01-01") {
            $this->db->where("leave.CREATED_ON <= ", $to . ' 23:59:59');
        }
        if ($selection == 'pending') {
            $this->db->where("(leave.HR_STATUS IS NULL OR leave.PM_STATUS IS NULL)");
//            $this->db->or_where("leave.HR_STATUS", NULL);
        }
        $return = $this->db->get()->result();
        foreach ($return as $key => $value) {
            $this->db->select('tbl_leave_details.*, pm.ACC_NAME as pm, hr.ACC_NAME as hr');
            $this->db->from('tbl_leave_details');
//            $this->db->join('tbl_account', 'tbl_account.ACC_ID = tbl_leave_details.STAFF_ID');
            $this->db->join('tbl_account pm', 'pm.ACC_ID = tbl_leave_details.APPROVED_PM', 'left');
            $this->db->join('tbl_account hr', 'hr.ACC_ID = tbl_leave_details.APPROVED_HR', 'left');
            $this->db->where('tbl_leave_details.DEL_FLAG =1');
            $this->db->where('tbl_leave_details.LEAVE_ID', $value->ID);
            $value->details = $this->db->get()->result();
        }
        return $return;
    }

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

    function edit($id) {
        $this->db->select('*');
        $this->db->from('tbl_leave');
        $this->db->where('ID', $id);
        $this->db->where('DEL_FLAG =1');
        $query = $this->db->get();
        return $query;
    }

    function acc_update($table, $data, $id, $condition = '') {
        $set = array();
        $update = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            if (strpos($value, 'IF(') === 0) {
                $set[] .= "$key = $value";
            } else {
                $set[] .= "$key = '$value'";
            }
        }
        $set_value = implode(",", $set);
        $update .= $set_value . " WHERE ID=$id";
        $this->db->query($update);
    }

    function delete($table, $id, $data) {
        $this->db->where('ID', $id);
        $this->db->update($table, $data);
    }

    function sel_data($table, $condition = array()) {
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $res = $this->db->get($table);
        return $res;
    }

}

?>