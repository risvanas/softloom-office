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
		$data['msg']='';
		$layout = array('page' => 'accounting_form','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
	}
	function insert_accounting_year()
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
			$data=array('YEAR_CODE'=>$year_code,
			            'FROM_DATE'=>$from,
						'TO_DATE'=>$to,
						'STATUS'=>$status,
						'DEL_FLAG'=>1);
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
	  $data['list']=$this->accounting_year_model->select_all('tbl_accounting_year');
	  $layout = array('page' => 'accounting_form_list','title'=>'Accounting Year','data'=>$data);	
		render_template($layout);
  }
  function account_year_edit()
  {
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
			$data=array('YEAR_CODE'=>$year_code,
			            'FROM_DATE'=>$from,
						'TO_DATE'=>$to,
						'STATUS'=>$status);
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
	  $id=$this->uri->segment(3);
	  $data=array('DEL_FLAG'=>0);
	  $this->accounting_year_model->delete_data('tbl_accounting_year',$data,$id);
	   redirect(base_url('accounting_year/account_year_list'));
  }
}
?>