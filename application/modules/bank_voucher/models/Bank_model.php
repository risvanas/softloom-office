<?php

class Bank_model extends CI_Model {

    function select_All($table, $acc_name) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->LIKE('ACC_NAME', $acc_name);
        $this->db->where('DEL_FLAG=1');
        $this->db->where('TYPE=', 'M');
        $this->db->order_by("ACC_NAME", "asc");
        $this->db->limit(10);
        $query = $this->db->get();
        return $query;
    }

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_acc_code($table) {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_TYPE', 'BANK');
        $query = $this->db->get();
        return $query;
    }

//    function select_book_num($table) {
//        $this->db->select_max('BOOK_NUMBER');
//        $this->db->where('BOOK_NAME', 'BV');
//        $query = $this->db->get($table);
//        return $query;
//    }

    function delete_data1($table, $data, $buk_num, $acc_year) {
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('ACC_YEAR_CODE', $acc_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('BOOK_NAME', 'BV');
        $this->db->where('DEL_FLAG=1');
        $this->db->update($table, $data);
    }

    function select_info($table, $buk_num, $accounting_year) {
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
//        $accounting_year = $sess_array['accounting_year'];
        $query = $this->db->query("SELECT TRANS_TYPE FROM tbl_transaction WHERE BOOK_NUMBER='$buk_num' AND BOOK_NAME='BV' and COMPANY='$company' and ACC_YEAR_CODE=$accounting_year AND DEL_FLAG=1   LIMIT 1");
        $row = $query->row_array();
        $transtype = $row['TRANS_TYPE'];
        if ($transtype == "") {
            return $query;
        }
        if ($transtype == "Deposit") {
            $this->db->select('*');
            $this->db->from('tbl_transaction');
            $this->db->join('tbl_account', 'tbl_transaction.ACC_ID = tbl_account.ACC_ID');
            $this->db->where('BOOK_NAME', 'BV');
            $this->db->where('BOOK_NUMBER', $buk_num);
            $this->db->where('CREDIT IS NOT NULL', null, FALSE);
            $this->db->where('tbl_transaction.DEL_FLAG=1');
            $this->db->where('tbl_transaction.COMPANY', $company);
            $this->db->where('tbl_transaction.ACC_YEAR_CODE', $accounting_year);
            $res = $this->db->get();
            return $res;
        }
        if ($transtype == "Withdrawal") {
            $this->db->select('*');
            $this->db->from('tbl_transaction');
            $this->db->join('tbl_account', 'tbl_transaction.ACC_ID = tbl_account.ACC_ID');
            $this->db->where('BOOK_NAME', 'BV');
            $this->db->where('BOOK_NUMBER', $buk_num);
            $this->db->where('DEBIT IS NOT NULL', null, FALSE);
            $this->db->where('tbl_transaction.DEL_FLAG=1');
            $this->db->where('tbl_transaction.COMPANY', $company);
            $this->db->where('tbl_transaction.ACC_YEAR_CODE', $accounting_year);
            $res = $this->db->get();
            return $res;
        }
    }

    function select_sub_acc() {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG=1');
        $this->db->where('TYPE=', 'S');
        $this->db->order_by("ACC_NAME", "asc");
        $res = $this->db->get();
        return $res;
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