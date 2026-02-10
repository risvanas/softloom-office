<?php

class Dashboard_model extends CI_Model {

        function select_log_details($from='', $to='', $staff_id='') {
//            select * from tbl_logindetails join tbl_account on tbl_logindetails.USER= tbl_account.ACC_ID where tbl_logindetails.DEL_FLAG=1 and USER=$user_id order by tbl_logindetails.DATE_TIME desc limit 10
        $this->db->select('*');
        $this->db->from('tbl_logindetails logn');
        $this->db->join('tbl_account stf', 'stf.ACC_ID = logn.USER');
        $this->db->where('logn.DEL_FLAG =1');
        if($staff_id != "") {
            $this->db->where("logn.USER", $staff_id);
        }
        if ($from != "" && $from != "1970-01-01") {
            $this->db->where("logn.DATE_TIME >= ", $from);
        }
        if ($to != "" && $to != "1970-01-01") {
            $this->db->where("logn.DATE_TIME <= ", $to);
        }
        $this->db->order_by('logn.DATE_TIME', 'desc');
        $return = $this->db->get()->result();
        return $return;
    }
    
    function selectStaff($id = '') {
        $this->db->select('tbl_account.*, tbl_designation.designation');
        $this->db->from('tbl_account');
        $this->db->join('tbl_designation', 'tbl_account.DESIGNATION = tbl_designation.id');
        $this->db->where('ACC_MODE=', 'STAFF');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        if($id != ''){
            $this->db->where('ACC_ID', $id);
        }
        $this->db->order_by("ACC_NAME", "asc");
        $res = $this->db->get();
        return $res;
    }
    
    function delete($table, $id, $data) {
        $this->db->where('INVOICE_ID', $id);
        $this->db->update($table, $data);
    }

}

?>