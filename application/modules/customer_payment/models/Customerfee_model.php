<?php

class Customerfee_model extends CI_Model {

    function select_customer($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_MODE=', 'CUSTOMER');
        $this->db->where('DEL_FLAG =1');
        $this->db->where('STATUS=', 'ACTIVE');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function trans_ins($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_acc_code($table) {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_TYPE', 'BANK');
        $query = $this->db->get();
        return $query;
    }

    function select_cust_details($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('ACC_ID', $id);
        $query = $this->db->get();
        return $query;
    }

    function select_info($table, $buk_num) {
        $this->db->select('*');
        $this->db->from('tbl_payment');
        $this->db->where('PAY_NUMBER', $buk_num);
        $this->db->where('tbl_payment.DEL_FLAG=1');
        $this->db->where('TYPE=', 'CUSTOMER');
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $year_code = $sess_array['accounting_year'];
        $this->db->where('COMPANY', $company_code);
        $this->db->where('ACC_YEAR_CODE', $year_code);
        $res = $this->db->get();
        return $res;
    }

    function select_data($table, $id) {
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('PAYMENT_ID', $id);
        $this->db->where('DEL_FLAG =1');
        $query = $this->db->get();
        return $query;
    }

    function delete_data($table, $data, $pay_num) {
        $this->db->where('PAY_NUMBER', $pay_num);
        $this->db->where('TYPE', 'CUSTOMER');
        $this->db->where('DEL_FLAG=1');
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $this->db->where('COMPANY', $company_code);
        $this->db->update($table, $data);
    }

    function delete_data1($table, $data, $pay_num) {
        $this->db->where('BOOK_NUMBER', $pay_num);
        $this->db->where('BOOK_NAME', 'PAYD');
        $this->db->where('DEL_FLAG=1');
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $this->db->where('COMPANY', $company_code);
        $this->db->update($table, $data);
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