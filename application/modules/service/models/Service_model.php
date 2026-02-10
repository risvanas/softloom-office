<?php
class Service_model extends CI_Model
{
	function service_insert($tab,$dat)
	{
		 $this->db->insert($tab,$dat);	 	
	}
	
	function selectAll($table)
	{
	   $this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('ACC_MODE','CUSTOMER');
	   $query = $this->db->get();
	   return $query;
	}
	
	function select_status($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
	    return $query;	
	}
	function select_All($table)
	{
	   $this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('DEL_FLAG =1');
	   $this->db->where('STATUS=','ACTIVE');
	   $this->db->order_by("ACC_NAME","asc");
	   $query = $this->db->get();
	   return $query;
	}
	
	
	function edit($table,$id)
	{
	   $this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('ID ='."'". $id ."'");
	   $this->db->where('DEL_FLAG =1');
	   $query = $this->db->get();
		return $query;
	}
	
	function service_update($table, $data, $id)
	{
		$this->db->where('ID ='."'". $id ."'");
		$this->db->update($table,$data);
	}
	
	
	function delete($table,$id,$dat)
	{
		$this->db->where('ID',$id); 
		$this->db->update($table,$dat);
	}
	
	function join_service_list()
	{
		 $this->db->select('tbl_service.*,tbl_account.ACC_ID,tbl_account.PHONE');
		 $this->db->from('tbl_service');
		 $this->db->join('tbl_account','tbl_service.ACC_ID=tbl_account.ACC_ID');	
	     $this->db->where('tbl_service.DEL_FLAG =1');
		 $this->db->where('tbl_service.STATUS=','ACTIVE');
		 $this->db->order_by('tbl_service.RENEWAL_DATE','asc');
		 $this->db->order_by('tbl_service.D_S_NAME','asc');
		 $res=$this->db->get();
		 return $res;

	}
	
	
	
	
}
	
	


?>