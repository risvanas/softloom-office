<?php
class Sample extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
	}
	
	function index()
	{
		
   		$layout = array('page' => 'welcome','title'=>'Blankpage');	
		render_template($layout);
			
	
		
	}
}
?>