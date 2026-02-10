<?php
class Service extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('service_model');
		
	}
	
	function index()
	{
		
		$menu_id=26;
         $this->load->library('../controllers/permition_checker');
		$data['parent_account']=$this->service_model->selectAll('tbl_account');
		$data['msg']="";
		$this->form_validation->set_rules('txt_acc_name','Acc_name','required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->permition_checker->permition_viewprocess($menu_id);
   		$layout = array('page' => 'form_service_reg','title'=>'Service Registration','data'=>$data);	
		render_template($layout);
		}
		else
		{
			$this->permition_checker->permition_addprocess($menu_id);
			  $acc_id= $this->input->post('txt_acc_name');
			  $dm_name= $this->input->post('txt_dm_name');
			  $acc_type= $this->input->post('drp_acc_type');
			  $reg_date= $this->input->post('txt_reg_date');
			  $reg_date = strtotime($reg_date);
		      $reg_date=date("Y-m-d", $reg_date);
			  $renw_date= $this->input->post('txt_renewal_date');
			  $renw_date = strtotime($renw_date);
		      $renw_date=date("Y-m-d", $renw_date);
			  $amt= $this->input->post('txt_amount');
			  $uname= $this->input->post('txt_uname');
			  $pass= $this->input->post('txt_pass');
			  $domain_uname= $this->input->post('txt_domain_uname');
			  $domain_pass= $this->input->post('txt_domain_pass');
			  $status= $this->input->post('drp_acc_status');
			  $acc_info= $this->input->post('txt_acc_info');
			  $remark= $this->input->post('txt_remark');
		      $sess_array=$this->session->userdata('logged_in');
			   $create_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $create_on=gmdate("Y-m-d H:i:s");
					$data = array(
					'D_S_NAME'=>$dm_name ,
					'ACC_ID'=>$acc_id,
					'ACC_TYPE'=> $acc_type,
					'REG_DATE'=> $reg_date,
					'RENEWAL_DATE'=>$renw_date,
					'USERNAME'=> $uname,
					'PASSWORD'=> $pass,
					'DOMAIN_UNAME'=>$domain_uname,
					'DOMAIN_PASSWD'=>$domain_pass,
					'STATUS'=>$status,
					'AMOUNT'=>$amt,
					'REMARKS'=> $remark,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details);
			$this->service_model->service_insert('tbl_service',$data);
			$data['msg']='New Service added successfully';
			$data['parent_account']=$this->service_model->selectAll('tbl_account');
			$layout = array('page' => 'form_service_reg','title'=>'Service Registration','data'=>$data);	
		    render_template($layout);
		   }
	}
	
	
	function service_list()
	{
		$menu_id=27;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
		$data['service_list']=$this->service_model->join_service_list('tbl_service');
		$layout = array('page' => 'form_service_list','title'=>'Service List','data'=>$data);
		render_template($layout);	
	}
	

	 function service_edit()
	{
		$menu_id=26;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_editprocess($menu_id);
		echo  $id = $this->uri->segment(3);
		$this->load->model('service_model');
		$data['service_edit']=$this->service_model->edit('tbl_service',$id);
		$data['res']=$this->service_model->selectAll('tbl_account');
		$layout = array('page' => 'form_service_edit','title'=>'Service Editt','data'=>$data);
		render_template($layout);	
		
	}
	 
	 
	 
function service_update()
	{	
	       $id=$this->input->post('txt_id');
		   $acc_id= $this->input->post('txt_acc_name');
		   $dm_name= $this->input->post('txt_dm_name');
		   $acc_type= $this->input->post('drp_acc_type');
		   $reg_date= $this->input->post('txt_reg_date');
		   $reg_date = strtotime($reg_date);
		   $reg_date=date("Y-m-d", $reg_date);
		   $renw_date= $this->input->post('txt_renewal_date');
		   $renw_date = strtotime($renw_date);
		   $renw_date=date("Y-m-d", $renw_date);
		   $amt= $this->input->post('txt_amount');
		   $uname= $this->input->post('txt_uname');
		   $pass= $this->input->post('txt_pass');
		   $domain_uname= $this->input->post('txt_domain_uname');
		   $domain_pass= $this->input->post('txt_domain_pass');
		   $status= $this->input->post('drp_acc_status');
		   $acc_info= $this->input->post('txt_acc_info');
		   $remark= $this->input->post('txt_remark');
			$sess_array=$this->session->userdata('logged_in');
			   $modified_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $modified_on=gmdate("Y-m-d H:i:s");
	
	$data = array(
	'D_S_NAME'=>$dm_name ,
	'ACC_ID'=>$acc_id,
	'ACC_TYPE'=> $acc_type,
	'REG_DATE'=>  $reg_date,
	'RENEWAL_DATE'=>$renw_date,
	'USERNAME'=> $uname,
	'PASSWORD'=> $pass,
	'DOMAIN_UNAME'=>$domain_uname,
	'DOMAIN_PASSWD'=>$domain_pass,
	'STATUS'=>$status,
	'AMOUNT'=>$amt,
	'ACC_INFO'=> $acc_info,
	'REMARKS'=> $remark,
	'MODIFIED_BY'=>$modified_by,
	'MODIFIED_ON'=>$modified_on,
	'LOCATION_DETAILS'=>$location_details);
	
	$this->load->model('service_model');	
	$this->service_model->service_update('tbl_service',$data,$id);
    $this->service_list();
	
	}
	 
	function service_delete()
	{
		$menu_id=26;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_deleteprocess($menu_id);
		$sess_array=$this->session->userdata('logged_in');
	    $deleted_by=$sess_array['user_id'];
		$this->load->library('../controllers/lockdate');
		$location_details=$this->lockdate->location_details();
		$deleted_on=gmdate("Y-m-d H:i:s");
		$id = $this->uri->segment(3);
		$dat =array('DEL_FLAG'=>'0',
		            'DELETED_BY'=>$deleted_by,
					'DELETED_ON'=>$deleted_on,
					'LOCATION_DETAILS'=>$location_details);
		$this->load->model('service_model');	
		$this->service_model->delete('tbl_service',$id,$dat);	
		$this->service_list();
	}
	
	function day1()
	{
		$this->load->view('form_day');
	}
	
	
}
?>