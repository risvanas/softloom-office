<?php
class Trialbalance extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
	}
	
	function index()
	{
		
		
   		$layout = array('page' => 'form_trial_balance','title'=>'Trial Balance');	
		render_template($layout);		
		  			
	}
	
		function account_list()
	{
		$this->load->model('trialbalance_model');
		$data['cond']=$this->trialbalance_model->join_trans();
		$data['cond1']=$this->trialbalance_model->join_trans1();
		$data['cond2']=$this->trialbalance_model->join_trans2();
		$data['cond3']=$this->trialbalance_model->join_trans3();
       // $this->load->view('form_acclist',$data);
		
	
		$layout = array('page' => 'form_acclist','data'=>$data);
		render_template($layout);	
	}
	
	
	
}
?>