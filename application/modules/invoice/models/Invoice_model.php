<?php

class Invoice_model extends CI_Model {

    function select_All($table, $acc_name) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->LIKE('account_herd', $acc_name);
        $this->db->where('DEL_FLAG=1');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query;
    }

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function get_invoice($temp_inv_id,$accounting_year) {
        $this->db->select('*');
        $this->db->from('tbl_temp_invoice');
        //$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
        $this->db->where('INVOICE_ID', $temp_inv_id);
        $this->db->where('ACC_YEAR_CODE', $accounting_year);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

    function invoice_edit($buk_num, $accounting_year, $company, $invoiceId) {
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        //$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
        $this->db->where('INVOICE_ID', $invoiceId);
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('ACC_YEAR_CODE', $accounting_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

    function invoice_list($company) {
        $sess_array=$this->session->userdata('logged_in');
        $id=$sess_array['accounting_year'];
        $sql="select * from tbl_accounting_year where AY_ID=$id";
        $query=$this->db->query($sql);
        $val=$query->row_array();
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_invoice_description','tbl_invoice.DESCRIPTION = tbl_invoice_description.id');
        $this->db->where('DEL_FLAG=1');
        $this->db->where("tbl_invoice.INVOICE_TYPE ='with_tax'");
        $this->db->where("tbl_invoice.COMPANY", $company);
        $this->db->where("tbl_invoice.INVOICE_DATE >=", $val['FROM_DATE']);
        $this->db->limit(10);
        $this->db->order_by("INVOICE_DATE", "desc");
        $this->db->order_by("BOOK_NUMBER", "desc");
        $query = $this->db->get();
        return $query;
    }

    function select_customer_details($table, $cust_id) {
        $this->db->select('*');
        $this->db->where('ACC_ID', $cust_id);
        $this->db->where('ACC_MODE', 'CUSTOMER');
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get($table);
        return $query;
    }

    function delete_data1($table, $data, $buk_num, $acc_year) {
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('BOOK_NAME', 'INVOE');
        $this->db->where('ACC_YEAR_CODE', $acc_year);
        $this->db->where('DEL_FLAG=1');
        $this->db->update($table, $data);
    }

    function select_info($table, $buk_num) {
        $this->db->select('*');
        $this->db->from('tbl_transaction');
        $this->db->join('tbl_account', 'tbl_transaction.ACC_ID = tbl_account.ACC_ID');
        $this->db->where('BOOK_NAME', 'PV');
        $this->db->where('BOOK_NUMBER', $buk_num);
        $this->db->where('DEBIT IS NOT NULL', null, FALSE);
        $this->db->where('tbl_transaction.DEL_FLAG=1');
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

    function invoice_update($table, $data, $id) {
        $this->db->where('INVOICE_ID =' . "'" . $id . "'");
        $this->db->where('BOOK_NAME', 'INVOE');
        $this->db->where('DEL_FLAG=1');
        $this->db->update($table, $data);
    }

    function invo_delete($table, $data, $id) {
        $this->db->where('INVOICE_ID =' . "'" . $id . "'");
        $this->db->where('DEL_FLAG=1');
        $this->db->update($table, $data);
    }

    function multipe_select($dat_from, $dat_to, $key_words, $inv_type) {
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_invoice.CUSTOMER_ID');
        $this->db->join('tbl_invoice_description','tbl_invoice.DESCRIPTION = tbl_invoice_description.id');
        $this->db->where('tbl_invoice.DEL_FLAG =1');
        if($inv_type != "") {
            $this->db->where("tbl_invoice.INVOICE_TYPE", $inv_type);
        } else {
            $this->db->where("tbl_invoice.INVOICE_TYPE ='with_tax'");
        }
        $this->db->where("tbl_invoice.COMPANY", $company);

        if ($dat_from != "" && $dat_to != "") {
            $this->db->where('tbl_invoice.INVOICE_DATE >=', $dat_from);
            $this->db->where('tbl_invoice.INVOICE_DATE <=', $dat_to);
            //return $result=$this->db->get();
        }
        if ($key_words != "") {
            $this->db->where("(tbl_invoice.BOOK_NUMBER LIKE '%$key_words%' OR tbl_account.ACC_NAME LIKE '%$key_words%' OR tbl_account.PHONE LIKE '%$key_words%')");
//			$this->db->or_like('tbl_account.ACC_NAME',$key_words);
//			$this->db->or_like('tbl_account.PHONE',$key_words);
            //return $result=$this->db->get();
        }
//		if($dat_from!="" && $dat_to!="" && $key_words!="" )
//		{
//			$this->db->where('tbl_invoice.INVOICE_DATE >=',$dat_from);
//			$this->db->where('tbl_invoice.INVOICE_DATE <=',$dat_to);
//			$this->db->like('tbl_invoice.BOOK_NUMBER',$key_words);
//			
//			//return $result=$this->db->get();
//		}
//		if($key_words!="" && $dat_from=="" && $dat_to=="")
//		{
//			$this->db->like('tbl_invoice.BOOK_NUMBER',$key_words);
//			$this->db->or_like('tbl_account.ACC_NAME',$key_words);
//			$this->db->or_like('tbl_account.PHONE',$key_words);
//			//return $result=$this->db->get();
//		}
//		if($dat_from!="" && $dat_to!="" && $key_words=="")
//		{
//			$this->db->where('tbl_invoice.INVOICE_DATE >=',$dat_from);
//			$this->db->where('tbl_invoice.INVOICE_DATE <=',$dat_to);
//			//return $result=$this->db->get();
//		}
        $this->db->order_by("tbl_invoice.INVOICE_DATE", "desc");
        $this->db->order_by("tbl_invoice.BOOK_NUMBER", "desc");

        $result = $this->db->get();
        return $result;
    }

    function get_gst_invoice_list($dat_from, $dat_to, $key_words, $company) {
//        $sess_array = $this->session->userdata('logged_in');
//        $company = $sess_array['comp_code'];
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_invoice.CUSTOMER_ID');
        $this->db->join('tbl_invoice_description','tbl_invoice.DESCRIPTION = tbl_invoice_description.id');
        $this->db->where('tbl_invoice.DEL_FLAG =1');
        if($company != "") {
            $this->db->where("tbl_invoice.COMPANY", $company);
        }
        $this->db->where("tbl_invoice.INVOICE_TYPE ='with_tax'");

        if ($dat_from != "" && $dat_to != "") {
            $this->db->where('tbl_invoice.INVOICE_DATE >=', $dat_from);
            $this->db->where('tbl_invoice.INVOICE_DATE <=', $dat_to);
            //return $result=$this->db->get();
        }
        if ($key_words != "") {
            $this->db->where("(tbl_invoice.BOOK_NUMBER LIKE '%$key_words%' OR tbl_account.ACC_NAME LIKE '%$key_words%' OR tbl_account.PHONE LIKE '%$key_words%')");
        }
        $this->db->order_by("tbl_invoice.INVOICE_DATE", "desc");
        $this->db->order_by("tbl_invoice.BOOK_NUMBER", "desc");

        $result = $this->db->get();
        return $result;
    }
    
    function recurring_invoice_list($date) {
//        $final = date("Y-m-d", strtotime("+1 month", $date));
        $this->db->select('*');
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_account', 'tbl_account.ACC_ID=tbl_invoice.CUSTOMER_ID');
        $this->db->where('tbl_invoice.DEL_FLAG=1');
        $this->db->where("NEXT_INVOICE_DATE >= '$date'");
        $this->db->where("NEXT_INVOICE_DATE!='1970-01-01'");
        $this->db->where("NEXT_INVOICE_DATE!=0");
        $this->db->where("(INVOICE_ID in(select  MAX(INVOICE_ID) from tbl_invoice GROUP by CUSTOMER_ID))");
        $this->db->order_by("NEXT_INVOICE_DATE", "asc");
        $query = $this->db->get();
        return $query;
    }
    
    function select_description() {
        $this->db->select('*');
        $this->db->from('tbl_invoice_description');
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


    function select_temp_inv_details($temp_inv_no, $accounting_year, $company) {
        $this->db->select('*');
        $this->db->from('tbl_temp_invoice');
        $this->db->where('INVOICE_ID', $temp_inv_no);
        $this->db->where('ACC_YEAR_CODE', $accounting_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

    function select_temp_invoice_details($temp_inv_no, $accounting_year, $company) {
        $this->db->select('*');
        $this->db->from('tbl_temp_invoice');
        $this->db->where('INVOICE_ID', $temp_inv_no);
        $this->db->where('ACC_YEAR_CODE', $accounting_year);
        $this->db->where('COMPANY', $company);
        $this->db->where('DEL_FLAG=1');
        $query = $this->db->get();
        return $query;
    }

}

?>