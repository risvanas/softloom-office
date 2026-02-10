<?php
class Trialbalance_model extends CI_Model
{
	
	
	function  join_trans()
	{
		$this->db->select('*');
	    $this->db->select("tbl_account.ACC_ID");
	    $this->db->select("tbl_account.ACC_CODE");
		$this->db->select("tbl_account.ACC_NAME");
		$this->db->select("sum(CREDIT) as mycreditsum");
		$this->db->select("sum(DEBIT) as mydebitsum");
		$this->db->from( 'tbl_transaction' );
	    $this->db->join( 'tbl_account','tbl_account.ACC_ID=tbl_transaction.ACC_ID' );
		$array="  ACC_NAME='cash'    ";
	    $this->db->where($array);
	    $query = $this->db->get();
	    return $query;
	}
	
	
	function  join_trans1()
	{
		$this->db->select('*');
	    $this->db->select("tbl_account.ACC_ID");
	    $this->db->select("tbl_account.ACC_CODE");
		$this->db->select("tbl_account.ACC_NAME");
		$this->db->select("sum(CREDIT) as mycreditsum");
		$this->db->select("sum(DEBIT) as mydebitsum");
		$this->db->from( 'tbl_transaction' );
	    $this->db->join( 'tbl_account','tbl_account.ACC_ID=tbl_transaction.ACC_ID' );
        $array="  ACC_NAME='SEO'    ";
	    $this->db->where($array);
	    $query = $this->db->get();
	    return $query;
	}
	
	function  join_trans2()
	{
		$this->db->select('*');
	    $this->db->select("tbl_account.ACC_ID");
	    $this->db->select("tbl_account.ACC_CODE");
		$this->db->select("tbl_account.ACC_NAME");
		$this->db->select("sum(CREDIT) as mycreditsum");
		$this->db->select("sum(DEBIT) as mydebitsum");
		$this->db->from( 'tbl_transaction' );
	    $this->db->join( 'tbl_account','tbl_account.ACC_ID=tbl_transaction.ACC_ID' );
        $array="  ACC_NAME='PHP'    ";
	    $this->db->where($array);
	    $query = $this->db->get();
	    return $query;
	}
	
	
	function  join_trans3()
	{
		$this->db->select('*');
	    $this->db->select("tbl_account.ACC_ID");
	    $this->db->select("tbl_account.ACC_CODE");
		$this->db->select("tbl_account.ACC_NAME");
		$this->db->select("sum(CREDIT) as mycreditsum");
		$this->db->select("sum(DEBIT) as mydebitsum");
		$this->db->from( 'tbl_transaction' );
	    $this->db->join( 'tbl_account','tbl_account.ACC_ID=tbl_transaction.ACC_ID' );
        $array="  ACC_NAME='DotNet' AND (BOOK_NAME='PV' OR BOOK_NAME='CR' ) ";
	    $this->db->where($array);
	    $query = $this->db->get();
	    return $query;
	}
	
}