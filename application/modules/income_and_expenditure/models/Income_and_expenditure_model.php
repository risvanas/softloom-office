<?php

class Income_and_expenditure_model extends CI_Model {

    function multi_search($acc, $from_date, $to_date, $company_code) {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->where('tbl_transaction.DEL_FLAG =1');
        $this->db->order_by('DATE_OF_TRANSACTION asc');
        if($from_date != "" && $from_date != '1970-01-01') {
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION >=', $from_date);
        }
        if($to_date != "" && $to_date != '1970-01-01') {
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION <=', $to_date);
        }
        $this->db->where('tbl_transaction.ACC_ID', $acc);
        if ($company_code != "") {
            $this->db->where('COMPANY', $company_code);
        }
        $query = $this->db->get();
        return $query;
    }
    
    function select_company($company_id = "") {
        $this->db->select('*');
        $this->db->from('tbl_company');
        if ($company_id != "") {
            $this->db->where('ID', $company_id);
        }
        $res = $this->db->get();
        return $res;
    }

}

?>