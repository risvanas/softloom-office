<?php
class Accounting_year extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array( 'template'));
		$this->template->set_template('admin_template');   
		$this->load->library('form_validation');
		$this->load->model('accounting_year_model');
	}
	function new_accounting_year()
	{
		$menu_id=21;
       $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
		$data['msg']='';
		$layout = array('page' => 'accounting_form','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
	}
	function insert_accounting_year()
	{
		$menu_id=21;
        $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_addprocess($menu_id);
		$this->form_validation->set_rules('year_code','required','required');
		if($this->form_validation->run() == FALSE)
		{
			//$data['msg']='required';
			redirect(base_url('accounting_year/new_accounting_year'));
		}
		else
		{
			$year_code=$this->input->post('year_code');
			$from=$this->input->post('txt_from');
			if($from != '')
			{
				$from=strtotime($from);
				$from=date('Y-m-d',$from);
			}
			$to=$this->input->post('txt_to');
			if($to != '')
			{
				$to=strtotime($to);
				$to=date('Y-m-d',$to);
			}
			$status=$this->input->post('drp_status');
			$sess_array=$this->session->userdata('logged_in');
			   $create_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $create_on=gmdate("Y-m-d H:i:s");
			$data=array('YEAR_CODE'=>$year_code,
			            'FROM_DATE'=>$from,
						'TO_DATE'=>$to,
						'STATUS'=>$status,
						'DEL_FLAG'=>1,
						'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details);
			if($status == 'active')
			{
				$data1=array('STATUS'=>'inactive');
				$this->accounting_year_model->update_status('tbl_accounting_year',$data1);
			}
			$this->accounting_year_model->insert_all('tbl_accounting_year',$data);
			$data['msg']='Data Successfully Inserted';
		$layout = array('page' => 'accounting_form','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
			
		}
	}
  function account_year_list()
  {
	  $menu_id=22;
   $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
 
	  $data['list']=$this->accounting_year_model->select_all('tbl_accounting_year');
	  $layout = array('page' => 'accounting_form_list','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
  }
  function account_year_edit()
  {
	  $menu_id=21;
			$this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_editprocess($menu_id);
			 
	  $id=$this->uri->segment(3);
	  $data['msg']='';
	  $data['edit_list']=$this->accounting_year_model->select_unique('tbl_accounting_year',$id);
	  $layout = array('page' => 'accounting_form_edit','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
  }
  function accounting_year_update()
  {
	  $this->form_validation->set_rules('year_code','required','required');
		if($this->form_validation->run() == FALSE)
		{
			//$data['msg']='required';
			redirect(base_url('accounting_year/new_accounting_year'));
		}
		else
		{
			$year_code=$this->input->post('year_code');
			$from=$this->input->post('txt_from');
			if($from != '')
			{
				$from=strtotime($from);
				$from=date('Y-m-d',$from);
			}
			$to=$this->input->post('txt_to');
			if($to != '')
			{
				$to=strtotime($to);
				$to=date('Y-m-d',$to);
			}
			$status=$this->input->post('drp_status');
			$sess_array=$this->session->userdata('logged_in');
			   $modified_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $modified_on=gmdate("Y-m-d H:i:s");
			$data=array('YEAR_CODE'=>$year_code,
			            'FROM_DATE'=>$from,
						'TO_DATE'=>$to,
						'STATUS'=>$status,
						'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details);
			if($status == 'active')
			{
				$data1=array('STATUS'=>'inactive');
				$this->accounting_year_model->update_status('tbl_accounting_year',$data1);
			}
			$id=$this->input->post('aid');
			$this->accounting_year_model->update_data('tbl_accounting_year',$data,$id);
		   redirect(base_url('accounting_year/account_year_list'));
		}
  }
  function account_delete()
  {
	  $menu_id=21;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_deleteprocess($menu_id);
	  $id=$this->uri->segment(3);
	  $sess_array=$this->session->userdata('logged_in');
			   $deleted_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $deleted_on=gmdate("Y-m-d H:i:s");
	  $data=array('DEL_FLAG'=>0,
	              'DELETED_BY'=>$deleted_by,
					'DELETED_ON'=>$deleted_on,
					'LOCATION_DETAILS'=>$location_details);
	  $this->accounting_year_model->delete_data('tbl_accounting_year',$data,$id);
	   redirect(base_url('accounting_year/account_year_list'));
  }
}
?>