<?php

class Student_list extends MX_Controller

{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		
	}

	 function index()
	   {
		
			redirect('student/student_list');
		

        }
}
?>