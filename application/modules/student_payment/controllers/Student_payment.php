<?php
class Student_payment extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
	}
	
	function index()
	{
		
		
   		$layout = array('page' => 'form_student_payment','title'=>'Customer Payment Details');	
		render_template($layout);		
		  			
	}


	function payment()
	{
		$this->load->model('studentpayment_model');
		$data['cond']=$this->studentpayment_model-> payment_details();
		$layout = array('page' => 'form_paymentlist','data'=>$data);
		render_template($layout);	
	}
}
?>