<?php

class Day_book extends MX_Controller

{

	function __construct()

	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('day_book_model');

	}

	function index()

	{
		$menu_id=34;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
   		$layout = array('page' => 'form_daybook','title'=>'DAYBOOK');	
		render_template($layout);		
	}

	function diff_date()
	{
			    $from_date=$this->input->post('fromdate');
				$to_date=$this->input->post('todate');
			   // $rdate=substr($calc,0,10);
			    $rdate = strtotime($from_date);
		        $from_date=date("Y-m-d", $rdate);
			   // $ddate=substr($calc,12);
                $ddate = strtotime($to_date);
                $to_date=date("Y-m-d",$ddate);
			
			 $openings=$this->db->query("SELECT IFNULL( SUM( CREDIT ) , 0 ) - IFNULL( SUM( DEBIT ) , 0 ) AS opening FROM tbl_transaction WHERE tbl_transaction.DEL_FLAG =  '1' AND tbl_transaction.ACC_ID != 39 AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ");
			 
			  	$opening=$openings->row_array();
			    $opening['opening'];
				//echo "<br>";
				$balance=$this->db->query("SELECT IFNULL( SUM(OPENING_BALANCE), 0) AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID =39 ");
				
				$balance1=$balance->row_array();
				 $balance1['balance'];
				//echo "<br>";
				$data['opening_balance'] =  $balance1['balance'] + $opening['opening'] ;
				
		 $data['list']=$this->day_book_model->diff_date($from_date,$to_date);
	     $this->load->view('form_viewdaybook3',$data);
		
	}


}

?>