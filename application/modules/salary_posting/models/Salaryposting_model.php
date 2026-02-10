<?php
class Salaryposting_model extends CI_Model
{
	function selectAll($table)
	{
	   $this->db->select('*');
	   $this->db->from( $table);
	   $this->db->where('DEL_FLAG =1');
	   $this->db->where('ACC_MODE =','STAFF');
	   $this->db->where('TYPE ="S"');
	   $this->db->where('STATUS ="ACTIVE"');
	   $this->db->order_by("ACC_NAME","asc");
	   $query = $this->db->get();
	   return $query;
	}
	function insert_data($table,$data)
	{
		$this->db->insert($table,$data);
	}

	function staff_details($table)
	{
		$this->db->select('*');
		$this->db->from($table);
        $this->db->where('PARENT_ACC_ID=46');
		$this->db->where('DEL_FLAG=1');
		$this->db->where('STATUS ="ACTIVE"');
		$this->db->order_by("ACC_NAME","asc");
		$query=$this->db->get();
		return $query;
				
	}
	function select_info($table,$buk_num)
	{
		$this->db->select('*');
		$this->db->from('tbl_transaction');
		$this->db->join('tbl_account','tbl_transaction.SUB_ACC = tbl_account.ACC_ID');
		$this->db->where('tbl_transaction.BOOK_NAME','SLA');
		$this->db->where('tbl_transaction.BOOK_NUMBER',$buk_num);
		$this->db->where('tbl_transaction.DEL_FLAG=1');
		$this->db->where('tbl_transaction.ACC_ID=42');
		//$this->db->where('CREDIT IS NOT NULL', null, FALSE);
		$res=$this->db->get();
		return $res;
	}
	
	
	function delete_data($table,$data,$buk_num)
	{
		$this->db->where('BOOK_NUMBER',$buk_num);
		$this->db->where('BOOK_NAME','SLA');
		$this->db->where('DEL_FLAG=1');
		$this->db->update($table,$data);
	}
}
?>