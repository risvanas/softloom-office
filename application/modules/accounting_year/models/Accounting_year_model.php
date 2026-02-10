<?php
class Accounting_year_model extends CI_model
{
	
	function insert_all($table,$data)
 	{
	   $this->db->insert($table,$data);
 	}
	function select_all($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('DEL_FLAG',1);
		$query=$this->db->get();
		return $query;
	}
	function select_unique($table,$id)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('DEL_FLAG',1);
		$this->db->where('AY_ID',$id);
		$query=$this->db->get();
		return $query;
	}
	function update_data($table,$data,$id)
	{
		$this->db->where('AY_ID',$id);
		$this->db->update($table,$data);
	}
	function delete_data($table,$data,$id)
	{
		$this->db->where('AY_ID',$id);
		$this->db->update($table,$data);
	}
	function update_status($table,$data)
	{
		$this->db->update($table,$data);
	}
}
?>