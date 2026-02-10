<?php

class Account_model extends CI_Model {

    function acc_insert($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_mainaccount($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('TYPE=', 'M');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function selectAll($table, $start=0, $limit=10) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_MODE=', 'STAFF');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        $this->db->order_by("ACC_NAME", "asc");
        $this->db->limit($limit, $start);
        $res = $this->db->get();
        return $res;
    }

    function selectcustomer($table, $start=0, $limit=10) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_MODE=', 'CUSTOMER');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        $this->db->order_by("ACC_NAME", "asc");
        $this->db->limit($limit, $start);
        $res = $this->db->get();
        return $res;
    }

    function select_subaccount($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('TYPE=', 'S');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->where('DEL_FLAG =1');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function edit($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_ID =' . "'" . $id . "'");
        $this->db->where('DEL_FLAG =1');
        $query = $this->db->get();
        return $query;
    }

    function acc_update($table, $data, $id) {
        $this->db->where('ACC_ID =' . "'" . $id . "'");
        $this->db->update($table, $data);
    }

    function select_designation($table) {
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        return $query;
    }

    function delete($table, $id, $data) {
        $this->db->where('ACC_ID', $id);
        $this->db->update($table, $data);
    }

    function mult_search($table, $acc_mode, $key_words = "", $search_status = "", $designation = "", $start = 0, $limit = 10) {
        $this->db->select('tbl_account.*');
        if ($acc_mode == "STAFF") {
            $this->db->select('tbl_designation.designation');
        }
        $this->db->from($table);
        if ($acc_mode == "STAFF") {
            $this->db->join('tbl_designation', 'tbl_account.DESIGNATION = tbl_designation.id');
        }
        $this->db->where('ACC_MODE=', $acc_mode);
        $this->db->where('DEL_FLAG =1');
        if ($search_status) {
            $this->db->where('STATUS=', $search_status);
        } else {
            $this->db->where('STATUS=', 'ACTIVE');
        }
        if ($key_words != "") {
            if ($acc_mode == "CUSTOMER") {
                $this->db->where("(ACC_NAME LIKE '%$key_words%' OR ADDRESS_ONE LIKE '%$key_words%' OR ADDRESS_TWO LIKE '%$key_words%' OR PHONE LIKE '%$key_words%')");
            } else if ($acc_mode == "STAFF") {
                $this->db->where("ACC_NAME LIKE '%$key_words%'");
            }
//            $this->db->or_like('MOBILE', $key_words);
//            $this->db->where("PHONE LIKE '%$key_words%'");
        }
        if ($designation) {
            $this->db->where('tbl_designation.id =', $designation);
        }
        $this->db->order_by("ACC_NAME", "asc");
        $this->db->limit($limit, $start);
        $res = $this->db->get();
        return $res;
    }
    
    function record_count($table, $acc_mode, $search_name = "", $search_status = "",$designation="") {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_MODE=', $acc_mode);
        $this->db->where('DEL_FLAG =1');
        if ($search_status) {
            $this->db->where('STATUS=', $search_status);
        } else {
            $this->db->where('STATUS=', 'ACTIVE');
        }
        if ($search_name) {
            if ($acc_mode == "CUSTOMER") {
                $this->db->where("(ACC_NAME LIKE '%$search_name%' OR ADDRESS_ONE LIKE '%$search_name%' OR ADDRESS_TWO LIKE '%$search_name%' OR PHONE LIKE '%$search_name%')");
            } else if ($acc_mode == "STAFF") {
                $this->db->where("ACC_NAME LIKE '%$search_name%'");
            }
//            $this->db->or_like('MOBILE', $search_name);
//            $this->db->where("PHONE LIKE '%$search_name%'");
        }
        if ($designation) {
            $this->db->where('tbl_account.DESIGNATION', $designation);
        }
        $this->db->order_by("ACC_NAME", "asc");
//                 echo $num = $this->db->count_all_result();
        return $this->db->get()->num_rows();
    }

    function get_account() {
        $this->db->select('acc_id, parent_acc_id, acc_code, acc_name, tin_no, acc_mode, type, opening_balance');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG =1');
        $this->db->where('TYPE ="M"');
        $this->db->where('PARENT_ACC_ID!=0');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function get_sub_acc() {
        $this->db->select('acc_id, parent_acc_id, acc_code, acc_name, tin_no, acc_mode, type, opening_balance');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG =1');
        $this->db->where('TYPE ="s"');
        $this->db->order_by('ACC_NAME', 'asc');
        $query = $this->db->get();
        return $query;
    }

}

?>