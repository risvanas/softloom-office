<?php

class Day_book_model extends CI_Model {

    function diff_date($first_date, $second_date, $company_code) {
        $this->db->select('DATE_OF_TRANSACTION');
        $this->db->distinct();
        $this->db->from('tbl_transaction');
        $this->db->where('DATE_OF_TRANSACTION >=', $first_date);
        $this->db->where('DATE_OF_TRANSACTION <=', $second_date);
        $this->db->where('DEL_FLAG', '1');
        $this->db->where('ACC_ID !=', '39');
        //$this->db->where('COMPANY', $company_code);
        $this->db->order_by('DATE_OF_TRANSACTION', 'asc');
        $res = $this->db->get();
        return $res;
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

    /* function opng_blance($table,$first_date)
      {
      $this->db->select_sum('CREDIT');
      $this->db->select_sum('DEBIT');
      $this->db->where('DATE_OF_TRANSACTION <',$first_date);
      $this->db->where('DEL_FLAG','1');
      $this->db->where('ACC_ID !=','39');
      $query = $this->db->get($table);
      return $query;

      } */
}

?>