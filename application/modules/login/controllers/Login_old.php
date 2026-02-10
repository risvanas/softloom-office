<?php
class Login extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array( 'template'));
		$this->template->set_template('admin_template');   
		$this->load->library('form_validation');
		$this->load->model('login_model');
	}
	
	function index()
	{
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password','trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['msg']='';
			$this->load->view('login',$data);
		}
		else
		{
			$username= $this->input->post('username');
			$password=$this->input->post('password');
			$result = $this->login_model->login($username, $password);
			if($result==FALSE)
			{
				$data['msg']='Invalid username or password';
				$this->load->view('login',$data);
			}
			else
			{
				$sess_array = array();
				foreach($result as $row)
				{
					$sess_array = array('user_id' => $row->USER_ID,'user_name' => $row->FIRST_NAME.' '. $row->LAST_NAME);
					$this->session->set_userdata('logged_in', $sess_array);
				}
				redirect('dashboard', 'refresh');
			}
		}	
	}
	
	function log_out()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
?>