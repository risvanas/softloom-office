<?php
class Trainingrefund_model extends CI_Model
{
		
	function selectAll($table)
	{
	   $this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('PARENT_ACC_ID','31');
	   $query = $this->db->get();
	   return $query;
	}
	
	function select_st_name($table)
	{
	 
	  $this->db->select('*');
	   $this->db->from( $table );
	   $query = $this->db->get();
	   return $query;
	}
	
	function select_acc_type($table)
	{
	 
	  $this->db->select('*');
	   $this->db->from( $table );
	   $query = $this->db->get();
	   return $query;
	}
	function select_acc_code($table)
	{
	 
	  $this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('ACC_TYPE','BANK');
	   $query = $this->db->get();
	   return $query;
	}
	
	function select_data($table,$id)
	{
	   $this->db->distinct();
	   $this->db->select('*');
	   $this->db->from( $table);
	   $this->db->where('PAYMENT_ID',$id);
	   $query = $this->db->get();
	   return $query;
	}
	function select($table)
	{
		$this->db->select('*');
	   $this->db->from( $table );
	   $this->db->where('DEL_FLAG =1');
	   $query = $this->db->get();
	   return $query;
	}
	
	function course_com_student($table,$student_id)
	{
		$this->db->select('*');
	    $this->db->from( $table );
	    $this->db->where('DEL_FLAG =1');
		$this->db->where('STUDENT_ID',$student_id);
		$this->db->where('DEL_FLAG =1');
	    $query = $this->db->get();
	    return $query;
	}
	
	function delete($table,$id,$data)
	{
		$this->db->where('STUDENT_ID',$id);
		$this->db->update($table,$data);
	}
	
	function fee_edit_data($table,$id)
	{
		$this->db->select('tbl_student.NAME,tbl_student.COURSE,tbl_payment.*');
		$this->db->from($table);
		$this->db->join('tbl_student','tbl_student.STUDENT_ID=tbl_payment.STUDENT_ID');
		$this->db->where('tbl_payment.PAY_ID=',$id);
		$this->db->where('tbl_payment.DEL_FLAG=1');
		$this->db->where('tbl_payment.TYPE="PAYRFD"');
		$query=$this->db->get();
	    return $query;
	}
	
	function fee_update($table, $data, $id)
	{
		$this->db->where('PAY_ID ='."'". $id ."'");
		$this->db->update($table,$data);
	}
	
	function trans_ins($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	function select_pay_num($table)
	{
		$this->db->select_max('PAY_NUMBER');
	    $query=$this->db->get($table);
		return  $query;
	}
	
	
	function stud_details($table,$sid)
	{
		$this->db->distinct();
		$this->db->select('*');
		$this->db->from($table);
		
        $this->db->where('SRC_ID',$sid);
		
		$this->db->where('ACC_ID = 38');
		$this->db->where('DEL_FLAG=1');
		$query=$this->db->get();
		return $query;
	}
	
	
	
	function select_course($table,$sid)
	{
		$this->db->distinct();
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('tbl_account','tbl_account.ACC_ID=tbl_student.COURSE');
		$this->db->where('tbl_student.STUDENT_ID',$sid);
		$this->db->where('tbl_student.DEL_FLAG=1');
		$query=$this->db->get();
		return $query;
	}
	function sel_name($table,$id)
	{
		$this->db->select('*');
	    $this->db->from( $table );
		$this->db->where('STUDENT_ID',$id);
	   $query = $this->db->get();
	   return $query;
		
	}
	
	
	function cash_acc_id($table)
	{
		$this->db->select('*');
		$this->db->where('ACC_NAME','Cash A/C');
		$query=$this->db->get($table);
		return $query;
	}
	function select_stud_name($table,$cname)
   {
	    $this->db->distinct();
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('tbl_account','tbl_account.ACC_ID=tbl_student.COURSE');
		$this->db->where('tbl_student.COURSE',$cname);
		$this->db->where('tbl_student.DEL_FLAG=1');
		$this->db->where('tbl_student.STATUS !=8');
		$this->db->order_by("tbl_student.NAME");
		$query=$this->db->get();
		return $query;
   }
	
	
	function stud_acc_id($table)
	{
		$this->db->select('*');
		$this->db->where('ACC_NAME','student A/C');
		$query=$this->db->get($table);
		return $query;
	}
	
	function bank_acc_id($table)
	{
		$this->db->select('*');
		$this->db->where('ACC_NAME','Bank A/C');
		$query=$this->db->get($table);
		return $query;
	}
	
	function delete_data($table,$data,$pay_num)
	{
		$this->db->where('PAY_ID',$pay_num);
		$this->db->where('TYPE','PAYRFD');
		$this->db->where('DEL_FLAG=1');
		$this->db->update($table,$data);
		
	}
	function delete_data1($table,$data,$pay_num)
	{
		$this->db->where('PAYMENT_ID',$pay_num);
		$this->db->where('BOOK_NAME','RFD');
		$this->db->where('DEL_FLAG=1');
		$this->db->update($table,$data);
		
	}
}

	
	


?>