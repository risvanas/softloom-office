<?php
class User_managing_model extends CI_Model
{
 function insert($table,$data)
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
function select_one($table,$id)
{
	$this->db->select('*');
	$this->db->from($table);
	$this->db->where('DEL_FLAG',1);
	$this->db->where('USER_ID',$id);
	$query=$this->db->get();
	return $query;
}
function update($table,$data,$id)
{
	$this->db->where('USER_ID',$id);
	$this->db->update($table,$data);
}
}

?>