<?php

class Lockdate extends MX_Controller

{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->library('user_agent');

	}

	function index($date="")
	{
		if($date=="")
		{
			$menu_id=28;
         $this->load->library('../controllers/permition_checker');
		 $this->permition_checker->permition_viewprocess($menu_id);
			 $data['msg']='';
			 $data['errmsg']='';
			 $layout = array('page' =>'form_addlockdate','title'=>'lockdate','data'=>$data);	
		     render_template($layout);
		}
		if($date !="")
		{
		//$date='08-12-2015';
		 $date = strtotime($date);
		 $date=date("Y-m-d", $date);
	 $lockdate=$this->db->query("SELECT LOCK_DATE As lockdate  FROM tbl_lockdate WHERE DEL_FALG = 1 ");
	 $lockdate=$lockdate->row_array();
		if($lockdate['lockdate'] > $date)
		{
			redirect('lockdate/error');
			
			//$this->load->view('form_error');
			//return FALSE;
		}
		/*else
		{
			redirect('receipt');
		}*/
		}
		
	}
	function check_date($date)
	{
		//echo $date;
		//exit;
		if($date != '')
		{
			$date=strtotime($date);
			$date=date('Y-m-d',$date);
		}
		$sess_array=$this->session->userdata('logged_in');
		$id=$sess_array['accounting_year'];
		$sql="select * from tbl_accounting_year where AY_ID=$id";
		$query=$this->db->query($sql);
		$val=$query->row_array();
		$cur_date=date('Y-m-d');
		if($val['FROM_DATE'] > $date || $val['TO_DATE'] < $date || $cur_date < $date)
		{
           $value='true';
		   return $value;
				
		}
		else
		{
			$value='false';
		   return $value;
		}
	}
	function message_val($date,$val)
	{
		if($date != '')
		{
			$date=strtotime($date);
			$date=date('Y-m-d',$date);
		}
		if($val == 'true')
		{
			$sess_array=$this->session->userdata('logged_in');
		$id=$sess_array['accounting_year'];
		$sql="select * from tbl_accounting_year where AY_ID=$id";
		$query=$this->db->query($sql);
		$val=$query->row_array();
			$cur_date=date('Y-m-d');
	if($val['FROM_DATE'] > $date || $val['TO_DATE'] < $date)
		{
          $message="Date is Out of Accounting Year";
		}
		else
			{
				$message="Entered Date is Greater Than Current date";
			}
			return $message;
		}
	}
	 function error()
	{
		//$this->load->view('form_error');
		
		  $layout=array('page'=>'form_error','title'=>'Lockdate');
				render_template($layout);
	} 
	function date_register()
	{
		 $this->form_validation->set_rules('txt_lockdate', 'Lockdate','required');
		
		 if ($this->form_validation->run() != FALSE)
		 {
			 $menu_id=28;
         $this->load->library('../controllers/permition_checker');
		 $this->permition_checker->permition_addprocess($menu_id);
		 $lock_date=$this->input->post('txt_lockdate');
		 $lock_date = strtotime($lock_date);
		 $lock_date=date("Y-m-d", $lock_date);
		 $set_date=date('Y-m-d');
		$this->db->query("update tbl_lockdate set `DEL_FALG`=0 WHERE `DEL_FALG`=1");
		$this->db->query("INSERT INTO tbl_lockdate(LOCK_DATE,SET_DATE)VALUES('$lock_date','$set_date')");
		// $data['msg']='Payment added successfully';
		$data['msg']='Lockdate Added Successfully';
			 $data['errmsg']='';
		 $layout = array('page' =>'form_addlockdate','title'=>'Lockdate','data'=>$data);	
		 render_template($layout);	
		 }
		 else
		 {
			 $data['msg']='';
			 $data['errmsg']='';
			$layout=array('page'=>'form_addlockdate','title'=>'Lockdate','data'=>$data);
		    render_template($layout); 
		 }
	}
	
	function location_details()
	{
 /* function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();

//echo $user_ip; // Output IP address [Ex: 177.87.193.134]
function detectDevice(){
	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	$devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
 	foreach($devicesTypes as $deviceType => $devices) {           
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
 	}
  $device=detectDevice();
  $user_agent = $_SERVER['HTTP_USER_AGENT']; */
  $this->load->library('user_agent');

if ($this->agent->is_browser())
{
        $agent = $this->agent->browser().' '.$this->agent->version();
}
elseif ($this->agent->is_robot())
{
        $agent = $this->agent->robot();
}
elseif ($this->agent->is_mobile())
{
        $agent = $this->agent->mobile();
}
else
{
        $agent = 'Unidentified User Agent';
}

$plat=$this->agent->platform();
$ip = $this->input->ip_address();
  return $details=$ip.','.$plat.','.$agent; 
	}
	

}

?>