<?php
class Ledger extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('finance_model');
	}
	
	function index()
	{
		$menu_id=36;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
		$this->load->model('finance_model');
		$data['cond']=$this->finance_model->selectAll('tbl_account');	
		$data['sub_acc']=$this->finance_model->select_sub_acc('tbl_account');	
		$layout = array('page' => 'form_studledger','title'=>'Finance','data'=>$data);
		render_template($layout);
	}
	
	 
		function sub_accounts()
		{
			 $accid=$this->input->post('accid');
			 $data['acc_name']=$this->finance_model->select_acc_name('tbl_account',$accid);
			 $this->load->view('form_acc_name',$data);
		
		}
		function search_details()
		{
			
			//echo $calc=$this->input->post('calc');
			$from_date=$this->input->post('fromdate');
			$to_date=$this->input->post('todate');
			$acc=$this->input->post('acc');
			$subacc=$this->input->post('subacc');
			
		    //$rdate=substr($calc,0,10);
			$from_date = strtotime($from_date);
		    $from=date("Y-m-d",$from_date);
			//echo "<br>";
			//$ddate=substr($calc,12);
            $to_date = strtotime($to_date);
            $to=date("Y-m-d", $to_date);
			
			if($acc !="" && $subacc=="")
			{
				$openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from' "); 
				$balance=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='$acc'");
				
				$opening=$openings->row_array();
				$balance1=$balance->row_array();
				$opening['opening'];
				$balance1['balance'];
				$data['opening_balance'] =  $balance1['balance'] + $opening['opening'] ;
			}
			if($acc !="" && $subacc!="")
			{
				$openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc'
				AND tbl_transaction.SUB_ACC =  '$subacc'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from' "); 
				//$balance=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='$acc'");
				
				$opening=$openings->row_array();
				//$balance1=$balance->row_array();
				$opening['opening'];
				//$balance1['balance'];
				$data['opening_balance'] =  $opening['opening'] ;
			}

		 $data['sel']=$this->finance_model->multi_search($acc,$subacc,$from,$to);
		 $this->load->view('form_ledger_list',$data);
			
		}
		
		
		
	
}
?>