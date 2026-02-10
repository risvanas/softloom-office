<?php
class Invoice_cancelation_model extends CI_Model
{
	function invoice_edit($buk_num)
	{
		$this->db->select('*');
		$this->db->from('tbl_invoice');
		//$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
	    $this->db->where('BOOK_NUMBER',$buk_num);
		$this->db->where('DEL_FLAG=1');
		$val='CANCELED';
		$this->db->where('CANCEL_STATUS="ACTIVE"');
		$query=$this->db->get();
		return $query;
	}
	function invoice_edit2($buk_num)
	{
		$this->db->select('*');
		$this->db->from('tbl_invoice');
		//$this->db->join('tbl_invoicedetails','tbl_invoice.INVOICE_ID = tbl_invoice.INVOICE_ID');
	    $this->db->where('BOOK_NUMBER',$buk_num);
		$this->db->where('DEL_FLAG=1');
		//$this->db->where('CANCEL_STATUS !=','CANCELED');
		$query=$this->db->get();
		return $query;
	}
	function insert($table,$data)
	{
		$this->db->insert($table,$data);
	}
	function update($table,$data,$no,$name)
	{
		$this->db->where('BOOK_NUMBER',$no);
		$this->db->where('BOOK_NAME',$name);
		$this->db->where('DEL_FLAG',1);
		$this->db->update($table,$data);
	}
}

?>