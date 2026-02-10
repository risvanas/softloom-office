<?php
ini_set('memory_limit', '-1');
class Backup extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		
	}
	
	function index()
	{
	    $this->load->dbutil();
         // Backup your entire database and assign it to a variable
       $backup = $this->dbutil->backup();

         // Load the file helper and write the file to your server
        $this->load->helper('file');
      write_file('/path/to/mybackup.gz', $backup);

       // Load the download helper and send the file to your desktop
       $this->load->helper('download');
	   $date_now=date('Y-M-d H-i-s');
       force_download('Wesmosis'.$date_now.'.gz', $backup);  
	}
}
?>