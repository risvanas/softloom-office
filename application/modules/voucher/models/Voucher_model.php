<?php

class Voucher_model extends CI_Model {

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

    function select_book_num($table) {
        $this->db->select_max('BOOK_NUMBER');
        $this->db->where('BOOK_NAME', 'PV');
        $query = $this->db->get($table);
        return $query;
    }

    function delete_data1($table, $data, $buk_num, $acc_year) {
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('ACC_YEAR_CODE', $acc_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('BOOK_NAME', 'PV');
        $this->db->where('DEL_FLAG=1');
        $this->db->update($table, $data);
    }

    function select_info($table, $buk_num, $accounting_year) {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->join('tbl_account', 'tbl_transaction.ACC_ID = tbl_account.ACC_ID');
        $this->db->where('BOOK_NAME', 'PV');
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('DEBIT IS NOT NULL', null, FALSE);
        $this->db->where('tbl_transaction.DEL_FLAG=1');
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $this->db->where('tbl_transaction.COMPANY', $company);
        $this->db->where('tbl_transaction.ACC_YEAR_CODE', $accounting_year);
        $res = $this->db->get();
        return $res;
    }

    function select_sub_acc() {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG=1');

        //$this->db->where('ACC_MODE!=','CUSTOMER');
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