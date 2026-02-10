<?php

class Finance_model extends CI_Model {

    function selectAll($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DEL_FLAG =1');
        //$this->db->where('ACC_MODE !=','CUSTOMER');
        // $this->db->where('ACC_MODE !=','STAFF');
        $this->db->where('TYPE ="M"');
        $this->db->where('PARENT_ACC_ID!=0');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function select_sub_acc($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DEL_FLAG =1');
        $this->db->where('TYPE ="s"');
        $this->db->order_by('ACC_NAME', 'asc');
        $query = $this->db->get();
        return $query;
    }

    function stud_details($table, $sid) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('STUDENT_ID', $sid);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

    function select_acc_name($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('PARENT_ACC_ID', $id);
        $this->db->where('DEL_FLAG =1');
        $this->db->order_by("ACC_NAME", "asc");
        $query = $this->db->get();
        return $query;
    }

    function multi_search($acc, $subacc, $from_date, $to_date, $company_code) {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->where('tbl_transaction.DEL_FLAG =1');
        $this->db->order_by('DATE_OF_TRANSACTION asc');
        if ($company_code != "") {
            $this->db->where('COMPANY', $company_code);
        }
        if ($from_date != "" && $to_date != "" && $acc != "" && $subacc == "") {
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION >=', $from_date);
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION <=', $to_date);
            $this->db->where('tbl_transaction.ACC_ID', $acc);
            $query = $this->db->get();
            return $query;
        }

        if ($from_date != "" && $to_date != "" && $acc != "" && $subacc != "") {
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION >=', $from_date);
            $this->db->where('tbl_transaction.DATE_OF_TRANSACTION <=', $to_date);
            //$this->db->where('tbl_transaction.ACC_ID',$acc);
            $this->db->where('tbl_transaction.ACC_ID', $acc);
            $this->db->where('tbl_transaction.SUB_ACC', $subacc);
            $this->db->where('tbl_transaction.DEL_FLAG =1');
            $query = $this->db->get();
            return $query;
        }
        $query = $this->db->get();
        return $query;
    }

    function invoice_edit($buk_num, $accounting_year, $company) {
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        //$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('ACC_YEAR_CODE', $accounting_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

    function select_invo_acc() {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG=1');

        //$this->db->where('ACC_MODE!=','CUSTOMER');
        $this->db->where('TYPE=', 'S');
        $this->db->order_by("ACC_NAME", "asc");
        $res = $this->db->get();
        return $res;
    }

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

    function search_status_subaccount($table, $status) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DEL_FLAG =1');
        $this->db->where('TYPE ="s"');
        if ($status != '') {
            $this->db->where('STATUS', $status);
        }
        $this->db->order_by('ACC_NAME', 'asc');
        $query = $this->db->get();
        return $query;
    }

    function invoice_edit2($buk_num) {
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        //$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('DEL_FLAG=1');
        //$this->db->where('CANCEL_STATUS !=','CANCELED');
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