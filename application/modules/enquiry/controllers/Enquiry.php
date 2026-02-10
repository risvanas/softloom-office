<?php

class Enquiry extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('template'));
        $this->template->set_template('admin_template');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $this->load->library('form_validation');
        $this->load->model('Enquirymodel');
    }

    function Index() {
        $menu_id = 46;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txtname', 'Name', 'required');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['msg'] = "";
            $data['data_status'] = $this->Enquirymodel->sel_status('tbl_status');
            $data['enquiry_for'] = $this->Enquirymodel->enqtype('tbl_account');
            $data['followup'] = $this->Enquirymodel->followup('tbl_followupvia');
            $layout = array('page' => 'form_enquiry', 'title' => 'New Enquiry', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $name = $this->input->post('txtname');
            $add1 = $this->input->post('txtadd1');
            $add2 = $this->input->post('txtadd2');
            $add3 = $this->input->post('txtadd3');
            $enqtype = $this->input->post('txtenqtype');
            $phno = $this->input->post('txtphno');
            $mobileno = $this->input->post('txtmobileno');
            $email = $this->input->post('txtemail');
            $desp = $this->input->post('txtdesp');
            $followupvia = $this->input->post('txtfollowupvia');
            $regdt = $this->input->post('txtregdate');
            $regdte = strtotime($regdt);
            $regdate = date('Y-m-d', $regdte);
            $entrydate = date('Y-m-d');
            $nfdate1 = $this->input->post('txtnfdate');
            $nfdte = strtotime($nfdate1);
            $nfdate = date('Y-m-d', $nfdte);
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];

            $status = $this->input->post('txtstatus');
            $data = array('NAME' => $name,
                'ADD1' => $add1,
                'ADD2' => $add2,
                'ADD3' => $add3,
                'ENQTYPE' => $enqtype,
                'PHNO' => $phno,
                'MOBILENO' => $mobileno,
                'EMAIL' => $email,
                'DESCRIPTION' => $desp,
                'FOLLOWUPVIA' => $followupvia,
                'ENQIRY_ADDED_BY' => $create_by,
                'REG_DATE' => $regdate,
                'ENTRYDATE' => $entrydate,
                'LASTFDATE' => $entrydate,
                'NEXTFDATE' => $nfdate,
                'STATUS' => $status,
                'DEL_FLAG' => '1');
            $this->Enquirymodel->insert_data('tbl_enquiry', $data);
            $enqid = $this->db->insert_id();
            $followupdata = array('EN_ID' => $enqid,
                'STATUS' => $status,
                'FDATE' => $entrydate,
                'NEXTFDATE' => $nfdate,
                'description' => $desp,
                'FOLLOWUP_ADDED_BY' => $create_by,
                'DEL_FLAG' => '1',
                'ENTRY_DATE' => $entrydate
            );
            $this->Enquirymodel->insert_data('tbl_followup', $followupdata);
            $data['msg'] = "Successfully saved enquiry details";
            $data['data_status'] = $this->Enquirymodel->sel_status('tbl_status');
            $data['enquiry_for'] = $this->Enquirymodel->enqtype('tbl_account');
            $data['followup'] = $this->Enquirymodel->followup('tbl_followupvia');
            $layout = array('page' => 'form_enquiry', 'title' => 'New Enquiry', 'data' => $data);
            render_template($layout);
        }
    }

    function enquiry_details() {
        $menu_id = 47;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['Status'] = $this->Enquirymodel->sel_status('tbl_status');
        $current_date = date('Y-m-d');
        $first_date = date('Y-m-01');
        $page = 1;
        $per_page = 10;
        $total_row = $this->Enquirymodel->followup_count('list',$first_date, $current_date, 'LASTFDATE');
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['Enquiry'] = $this->Enquirymodel->select_data("", $first_date, $current_date,"1",0,10);
        $layout = array('page' => 'form_enquirylist', 'title' => 'Enquiry List', 'data' => $data);
        render_template($layout);
    }

    function followup_history() {
        $menu_id = 64;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['Status'] = $this->Enquirymodel->sel_status('tbl_status');
        $page = 1;
        $per_page = 10;
        $total_row = $this->Enquirymodel->followup_count('flwup_histry');
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['Enquiry'] = $this->Enquirymodel->select_data("","","",1,0, $per_page);
        $layout = array('page' => 'form_followup_histry', 'title' => 'Follow up history', 'data' => $data);
        render_template($layout);
    }

    function enquiry_report() {
        $menu_id = 63;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['Status'] = $this->Enquirymodel->sel_status('tbl_status');
//        $data['Enquiry'] = $this->Enquirymodel->select_data();
        $data['Enquiry'] = $this->Enquirymodel->select_enqury_count();
        $layout = array('page' => 'form_enquiry_report', 'title' => 'Enquiry List', 'data' => $data);
        render_template($layout);
    }

    function followup_details() {
        echo "Follow up Details";
        $EnquiryId = $this->input->post('eid');
        $data['en_id'] = $this->Enquirymodel->selectbyid_data($EnquiryId);
        $this->load->view('form_table', $data);
    }

    function profile_details() {
        echo "Profile Details";
        $EnquiryId = $this->input->post('eid');
        $Enquiry_type = $this->input->post('enq_type');
        $data['en_id'] = $this->Enquirymodel->select_data($EnquiryId,"","",$Enquiry_type);
        $this->load->view('form_profile', $data);
    }

    function search_enquiry_details() {
        $dtype = $this->input->post('dtype');
        $stype = $this->input->post('stype');
        $sort = $this->input->post('sorttype');
        $d1 = $this->input->post('datefrom');
        $d2 = $this->input->post('dateto');
        $key_words = $this->input->post('key_words');
        $type = $this->input->post('type');
        $per_page = $this->input->post('per_page');
        $cur_page = $this->input->post('cur_page');
        $college = $this->input->post('college');
        $course = $this->input->post('course');
        $sem = $this->input->post('sem');
//        $d1 = substr($dat, 0, 10);
//        $d2 = substr($dat, 12);
        $x = strtotime($d1);
        $y = strtotime($d2);
        $from = date('Y-m-d', $x);
        $to = date('Y-m-d', $y);
        $data['type'] = $type;
        
        if ($type == 'enq_rep') {
            $data['SearchCondition'] = $this->Enquirymodel->select_enqury_count($from, $to);
            $data['sl_no'] = 0;
            $data['pagination'] = "";
        } else {
            $total_row = $this->Enquirymodel->followup_count($type,$from, $to, $dtype, $stype, $sort, $key_words,$college,$course, $sem);
            $data['SearchCondition'] = $this->Enquirymodel->multiple_select($from, $to, $dtype, $stype, $sort, $key_words, $type, $college,$course, $sem, ($cur_page - 1) * $per_page, $per_page);
            $data['sl_no'] = ($cur_page - 1) * $per_page;
            $total_pages = ceil($total_row / $per_page);
            $this->load->library('../controllers/pagination');
            $data['pagination'] = $this->pagination->create_pagination($per_page, $cur_page, $total_row, $total_pages);
        }
        $this->load->view('form_search_data', $data);
    }

    function delete_enquiry_details() {
        $menu_id = 46;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
//        $frm = $this->uri->segment(4);
        $data = array('DEL_FLAG' => '0');
        $this->Enquirymodel->update_data('tbl_enquiry', $data, $id);
        $this->Enquirymodel->update_follow('tbl_followup', $data, $id);
//        $this->enquiry_details();
        redirect('enquiry/enquiry_details');
    }

    function find_enquiry_details() {
        $menu_id = 46;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $EnquiryId = $this->uri->segment(3);
        $followupvia = $this->input->post('txtfollowupvia');
        $data['data_status'] = $this->Enquirymodel->sel_status('tbl_status');
        $data['enquiry_for'] = $this->Enquirymodel->enqtype('tbl_account');
        $data['edit_data'] = $this->Enquirymodel->sel_edit_id('tbl_enquiry', $EnquiryId);
        $data['followup'] = $this->Enquirymodel->followup('tbl_followupvia');
        $layout = array('page' => 'form_enquiry_edit', 'title' => 'Enquiry', 'data' => $data);
        render_template($layout);
    }

    function update_enquiry_details() {
        $id = $this->input->post('txtid');
        $name = $this->input->post('txtname');
        $add1 = $this->input->post('txtadd1');
        $add2 = $this->input->post('txtadd2');
        $add3 = $this->input->post('txtadd3');
        $enqtype = $this->input->post('txtenqtype');
        $phno = $this->input->post('txtphno');
        $mobileno = $this->input->post('txtmobileno');
        $email = $this->input->post('txtemail');
        $college = $this->input->post('txtcollege');
        $desp = $this->input->post('txtdesp');
        $regdt = $this->input->post('txtregdate');
        $regdte = strtotime($regdt);
        $regdate = date('Y-m-d', $regdte);
        $followupvia = $this->input->post('txtfollowupvia');
        $nfdate1 = $this->input->post('txtnfdate');
        $y = strtotime($nfdate1);
        $nfdate = date('Y-m-d', $y);
        $status = $this->input->post('txtstatus');
        $data = array(
            'NAME' => $name,
            'ADD1' => $add1,
            'ADD2' => $add2,
            'ADD3' => $add3,
            'ENQTYPE' => $enqtype,
            'PHNO' => $phno,
            'MOBILENO' => $mobileno,
            'EMAIL' => $email,
            'COLLEGE' => $college,
            'FOLLOWUPVIA' => $followupvia,
            'REG_DATE' => $regdate,
            'NEXTFDATE' => $nfdate,
            'STATUS' => $status,
            'DEL_FLAG' => '1'
        );


        $this->Enquirymodel->update_data('tbl_enquiry', $data, $id);
        /* $followupdata=array('STATUS'=>$status,
          'NEXTFDATE'=>$nfdate,
          'description'=>$desp);

          $this->Enquirymodel->update_data('tbl_followup',$followupdata,$id); */
//        $this->enquiry_details();
        redirect('enquiry/enquiry_details');
    }
    
    function followup_db_history() {
        $menu_id = 77;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['Status'] = $this->Enquirymodel->sel_status('tbl_status');
        $data['College'] = $this->Enquirymodel->select_college();
        $data['Course'] = $this->Enquirymodel->select_course();
        $data['Semester'] = $this->Enquirymodel->select_sem();
        $page = 1;
        $per_page = 10;
        $total_row = $this->Enquirymodel->followup_count('flwup_db_histry');
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['Enquiry'] = $this->Enquirymodel->select_data("","","",'0',0, $per_page);
        $layout = array('page' => 'form_followup_db_histry', 'title' => 'Follow up history', 'data' => $data);
        render_template($layout);
    }
	function enquiry_db_details()
	{
		$menu_id = 79;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
		$data['Status'] = $this->Enquirymodel->sel_status('tbl_status');
        $data['College'] = $this->Enquirymodel->select_college();
        $data['Course'] = $this->Enquirymodel->select_course();
        $data['Semester'] = $this->Enquirymodel->select_sem();
        $page = 1;
        $per_page = 10;
		$current_date = date('Y-m-d');
		$first_date = date('Y-m-01');
        $total_row = $this->Enquirymodel->followup_count('enqry_db_list', $first_date, $current_date, 'REG_DATE');
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['Enquiry'] = $this->Enquirymodel->select_data("", $first_date, $current_date,"0",0,$per_page,'REG_DATE');
        $layout = array('page' => 'form_enquirylist_db', 'title' => 'Enquiry List', 'data' => $data);
        render_template($layout);
	}
	function api_new_enqry()
	{
        $this->load->library('../controllers/Permition_checker_api');
		$this->form_validation->set_rules('menu_id','Menu Id','trim|required');
		$this->form_validation->set_rules('user_id','User Id','trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('address1', 'Address Line 1','trim');
		$this->form_validation->set_rules('address2', 'Address Line 2','trim');
		$this->form_validation->set_rules('address3', 'Address Line 3','trim');
		$this->form_validation->set_rules('phno', 'Phone No', 'trim');	
		$this->form_validation->set_rules('mobileno', 'Mobile No','trim|required');		
		$this->form_validation->set_rules('email', 'Email-Id','trim');
        $this->form_validation->set_rules('enquiry_from', 'Enquiry From', 'trim|required');
		$this->form_validation->set_rules('enquiry_for', 'Enquiry For', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('next_followup_date', 'Next Followup_Date','trim');
		$this->form_validation->set_rules('regdate', 'Registration Date','trim');
		$this->form_validation->set_rules('description', 'Description','trim');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
		if ($this->form_validation->run() != TRUE) 
		{
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_addprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data); 
            } else {
                
                $name = $this->input->post('name');
                $add1 = $this->input->post('address1');
                $add2 = $this->input->post('address2');
                $add3 = $this->input->post('address3');
                $phno = $this->input->post('phno');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $enqtype = $this->input->post('enquiry_for');
                $desp = $this->input->post('description');
                $followupvia = $this->input->post('enquiry_from');
                $regdt = $this->input->post('regdate');
                $regdte = strtotime($regdt);
                $regdate = date('Y-m-d', $regdte);
                $entrydate = date('Y-m-d');
                $nfdate1 = $this->input->post('next_followup_date');
                $nfdte = strtotime($nfdate1);
                $nfdate = date('Y-m-d', $nfdte);
                $status = $this->input->post('status');
                $data = array('NAME' => $name,
                    'ADD1' => $add1,
                    'ADD2' => $add2,
                    'ADD3' => $add3,
                    'ENQTYPE' => $enqtype,
                    'PHNO' => $phno,
                    'MOBILENO' => $mobileno,
                    'EMAIL' => $email,
                    'DESCRIPTION' => $desp,
                    'FOLLOWUPVIA' => $followupvia,
                    'ENQIRY_ADDED_BY' => $user_id,
                    'REG_DATE' => $regdate,
                    'ENTRYDATE' => $entrydate,
                    'LASTFDATE' => $entrydate,
                    'NEXTFDATE' => $nfdate,
                    'STATUS' => $status,
                    'DEL_FLAG' => '1');
                $this->Enquirymodel->insert_data('tbl_enquiry', $data);
                $enqid = $this->db->insert_id();
                $followupdata = array('EN_ID' => $enqid,
                    'STATUS' => $status,
                    'FDATE' => $entrydate,
                    'NEXTFDATE' => $nfdate,
                    'description' => $desp,
                    'FOLLOWUP_ADDED_BY' => $user_id,
                    'DEL_FLAG' => '1',
                    'ENTRY_DATE' => $entrydate
                );
                $this->Enquirymodel->insert_data('tbl_followup', $followupdata);
                $return_value = array('status' => 1,
                    'name' => $name,
                    'address1' => $add1,
                    'address2' => $add2,
                    'address3' => $add3,
                    'enquiry_for' => $enqtype,
                    'phno' => $phno,
                    'mobileno' => $mobileno,
                    'email' => $email,
                    'description' => $desp,
                    'enquiry_from' => $followupvia,
                    'regdate' => $regdate,
                    'next_followup_date' => $nfdate,
                    'enquiry_status' => $status);
                header('Content-Type: application/json');
                echo json_encode($return_value); 
            }
		}
	}
    function api_enqry_from_list()
    {
       $result['status'] = 1;
        $result['data'] = $this->Enquirymodel->followup('tbl_followupvia')->result();
        if(count($result['data']) > 0) 
        {
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
        else 
        {
            unset($result['data']);
            $result['status'] = 0;
            $result['msg'] = 'No Data Found';
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
    }
    function api_enqry_for_list()
    {
       $result['status'] = 1;
        $result['data'] = $this->Enquirymodel->enqtype('tbl_account')->result();
        if(count($result['data']) > 0) 
        {
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
        else 
        {
            unset($result['data']);
            $result['status'] = 0;
            $result['msg'] = 'No Data Found';
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
    }
    function api_enqry_status_list()
    {
       $result['status'] = 1;
        $result['data'] = $this->Enquirymodel->sel_status('tbl_status')->result();
        if(count($result['data']) > 0) 
        {
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
        else 
        {
            unset($result['data']);
            $result['status'] = 0;
            $result['msg'] = 'No Data Found';
            header('Content-Type: application/json');
            echo json_encode($result);
        } 
    }
    function api_enquiry_list()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('from_date', 'From Date', 'trim');
        $this->form_validation->set_rules('to_date', 'To Date', 'trim');
        $this->form_validation->set_rules('date', 'Date', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'trim');
        $this->form_validation->set_rules('sort_by', 'Sort by', 'trim');
        $this->form_validation->set_rules('key_words', 'Key Words', 'trim');
        $this->form_validation->set_rules('current_page', 'Current Page', 'trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_addprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data); 
            } else {
                $per_page = 10;
                $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : date('Y-m-01');
                $from_date = strtotime($from_date);
                $from_date = date('Y-m-d', $from_date);
                $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : date('Y-m-d');
                $to_date = strtotime($to_date);
                $to_date = date('Y-m-d', $to_date);
                $date = $this->input->post('date') ?  $this->input->post('date') : 'LASTFDATE';
                $status = $this->input->post('status');
                $sort_by = $this->input->post('sort_by') ? $this->input->post('sort_by') : 'LASTFDATE';
                $key_words = $this->input->post('key_words');
                $cur_page = $this->input->post('current_page');
                $total_row = $this->Enquirymodel->followup_count('list',$from_date,$to_date, $date, $status, $sort_by, $key_words);
                $total_pages = ceil($total_row / 10);
                $SearchCondition = $this->Enquirymodel->multiple_select($from_date,$to_date, $date, $status, $sort_by, $key_words ,'list',"","","",($cur_page - 1) * $per_page, $per_page)->result();
                if(count($SearchCondition) > 0)
                { 
                    foreach ($SearchCondition as $key => $value) {
                        $value->NAME = strtoupper($value->NAME);
                    }
                    $return_value = array('status' => 1, 'data' => $SearchCondition);
                    $return_value['total_pages'] = $total_pages;
                    $return_value['total_row'] = $total_row;
                    header('Content-Type: application/json');
                    echo json_encode($return_value);
                }
                else
                {
                    $data['status'] = 0;
                    $data['msg'] = "No Data Found";
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }  
            }       
        }      
    }
    function api_enquiry_edit()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('enqry_id', 'Enquiry Id','trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_editprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data); 
            } 
            else 
            {
                $enqry_id = $this->input->post('enqry_id');
                $data['status'] = 1;
                $result = $this->Enquirymodel->sel_edit_id('tbl_enquiry', $enqry_id)->row_array();
                $sql = "select * from tbl_followupvia where id=" . $result['FOLLOWUPVIA'];
                $query = $this->db->query($sql);
                $val = $query->row_array();
                $result['ENQUIRY_FROM'] = $val['methods'];
                $result['Enquiry_Status'] = $this->Enquirymodel->sel_status('tbl_status',$result['STATUS'])->row_array()['status'];
                $result['enquiry_for'] = $this->Enquirymodel->enqtype('tbl_account', $result['ENQTYPE'])->row_array()['ACC_NAME'];
                if (array_key_exists("STATUS",$result)) {
                    $result['enqury_status'] = $result['STATUS'];
                    unset($result['STATUS']);
                }
                $return = array_merge($data, $result);
                header('Content-Type: application/json');
                echo json_encode($return); 
            }
        }   
    }
    function api_enquiry_update()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('enqry_id','Enquiry Id','trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('address1', 'Address Line 1','trim');
        $this->form_validation->set_rules('address2', 'Address Line 2','trim');
        $this->form_validation->set_rules('address3', 'Address Line 3','trim');
        $this->form_validation->set_rules('phno', 'Phone No', 'trim'); 
        $this->form_validation->set_rules('mobileno', 'Mobile No','trim|required');      
        $this->form_validation->set_rules('email', 'Email-Id','trim');
        $this->form_validation->set_rules('enquiry_from', 'Enquiry From', 'trim|required');
        $this->form_validation->set_rules('enquiry_for', 'Enquiry For', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('next_followup_date', 'Next Followup_Date','trim');
        $this->form_validation->set_rules('regdate', 'Registration Date','trim');
        $this->form_validation->set_rules('description', 'Description','trim');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required','trim');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required','trim');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_editprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data); 
            } 
            else 
            {                
                $enqry_id = $this->input->post('enqry_id');
                $name = $this->input->post('name');
                $add1 = $this->input->post('address1');
                $add2 = $this->input->post('address2');
                $add3 = $this->input->post('address3');
                $phno = $this->input->post('phno');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $enqtype = $this->input->post('enquiry_for');
                $desp = $this->input->post('description');
                $followupvia = $this->input->post('enquiry_from');
                $regdt = $this->input->post('regdate');
                $regdte = strtotime($regdt);
                $regdate = date('Y-m-d', $regdte);
                $entrydate = date('Y-m-d');
                $nfdate1 = $this->input->post('next_followup_date');
                $nfdte = strtotime($nfdate1);
                $nfdate = date('Y-m-d', $nfdte);
                $status = $this->input->post('status');
                $data = array(
            'NAME' => $name,
            'ADD1' => $add1,
            'ADD2' => $add2,
            'ADD3' => $add3,
            'ENQTYPE' => $enqtype,
            'PHNO' => $phno,
            'MOBILENO' => $mobileno,
            'EMAIL' => $email,
            'FOLLOWUPVIA' => $followupvia,
            'REG_DATE' => $regdate,
            'NEXTFDATE' => $nfdate,
            'STATUS' => $status,
            'DEL_FLAG' => '1'
        );
            $this->Enquirymodel->update_data('tbl_enquiry', $data, $enqry_id);
                 $return_value = array('status' => 1,
                    'name' => $name,
                    'address1' => $add1,
                    'address2' => $add2,
                    'address3' => $add3,
                    'enquiry_for' => $enqtype,
                    'phno' => $phno,
                    'mobileno' => $mobileno,
                    'email' => $email,
                    'description' => $desp,
                    'enquiry_from' => $followupvia,
                    'regdate' => $regdate,
                    'next_followup_date' => $nfdate,
                    'enquiry_status' => $status);
                header('Content-Type: application/json');
                echo json_encode($return_value); 
                
            } 
        }          
    }
    function api_enquiry_count()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data); 
            }
            else
            {
                 $from_date = $this->input->post('from_date');
                 $from_date = strtotime($from_date);
                 $from_date = date('Y-m-d', $from_date);
                 $to_date = $this->input->post('to_date');
                 $to_date = strtotime($to_date);
                 $to_date = date('Y-m-d', $to_date);
                 $data= $this->Enquirymodel->select_enqury_count($from_date, $to_date)->result();
                 if(count($data) > 0)
                 { 
                     $retrn_value = array('status' => 1, 'data'=> $data);
                   header('Content-Type: application/json');
                   echo json_encode($retrn_value);
                }
                else
                {
                     $data['status'] = 0;
                     $data['msg'] = "No Data Found";
                     header('Content-Type: application/json');
                     echo json_encode($data);
                }    
            }
        }        
    }
    function api_follow_up()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('date','Date','trim|required');
        $this->form_validation->set_rules('status','Status','trim');
        $this->form_validation->set_rules('sort','Sort','trim|required');
        $this->form_validation->set_rules('key_words','Key Words','trim');
        $this->form_validation->set_rules('current_page', 'Current Page', 'trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data);
            } 
            else
            {
                $per_page = 10;
                $date = $this->input->post('date') ? $this->input->post('date') : date('Y-m-d');
                $date = strtotime($date);
                $date = date('Y-m-d', $date);
                $status = $this->input->post('status');
                $sort = $this->input->post('sort');
                $key_words = $this->input->post('key_words');
                $cur_page = $this->input->post('current_page');
                $total_row = $this->Enquirymodel->followup_count('flwup_histry',' ',$date,' ',$status, $sort, $key_words);
                $total_pages = ceil($total_row / 10);
                $data = $this->Enquirymodel->multiple_select(' ',$date,' ',$status,$sort,$key_words,'flwup_histry',"","","",($cur_page - 1) * $per_page, $per_page)->result();
                if(count($data) > 0)
                 { 
                    foreach ($data as $key => $value) {
                        $value->NAME = strtoupper($value->NAME);
                    }
                     $return_value = array('status' => 1, 'data'=> $data);
                     $return_value['total_pages'] = $total_pages;
                     $return_value['total_row'] = $total_row;
                     header('Content-Type: application/json');
                     echo json_encode($return_value);
                    
                }
                else
                {
                     $data['status'] = 0;
                     $data['msg'] = "No Data Found";
                     header('Content-Type: application/json');
                     echo json_encode($data);
                }
            }      
        }    
    }
    function api_follow_up_database()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('date','Date','trim|required');
        $this->form_validation->set_rules('college','College','trim');
        $this->form_validation->set_rules('course','Course','trim');
        $this->form_validation->set_rules('sem_year','Semester/Year','trim');
        $this->form_validation->set_rules('status','Status','trim');
        $this->form_validation->set_rules('sort','Sort','trim|required');
        $this->form_validation->set_rules('key_words','Key Words','trim');
        $this->form_validation->set_rules('current_page', 'Current Page', 'trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data);
            } 
            else
            {
                $per_page = 10;
                $date = $this->input->post('date') ? $this->input->post('date') : date('Y-m-d');
                $date = strtotime($date);
                $date = date('Y-m-d', $date);
                $college = $this->input->post('college');
                $course = $this->input->post('course');
                $sem_year = $this->input->post('sem_year');
                $status = $this->input->post('status');
                $sort = $this->input->post('sort');
                $key_words = $this->input->post('key_words');
                $cur_page = $this->input->post('current_page');
                $total_row = $this->Enquirymodel->followup_count('flwup_db_histry','',$date,'',$status,$sort,$key_words, $college, $course,$sem_year);
                $total_pages = ceil($total_row / 10);
                $data = $this->Enquirymodel->multiple_select('',$date,'',$status,$sort,$key_words,'flwup_db_histry',$college,$course, $sem_year,($cur_page - 1) * $per_page, $per_page)->result();
                if(count($data) > 0)
                 { 
                    foreach ($data as $key => $value) {
                        $value->NAME = strtoupper($value->NAME);
                    }
                     $return_value = array('status' => 1, 'data'=> $data);
                     $return_value['total_pages'] = $total_pages;
                     $return_value['total_row'] = $total_row;
                     header('Content-Type: application/json');
                     echo json_encode($return_value);
                    
                }
                else
                {
                     $data['status'] = 0;
                     $data['msg'] = "No Data Found";
                     header('Content-Type: application/json');
                     echo json_encode($data);
                }
            }   
        }    
    }
    function api_enquiry_list_database()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        $this->form_validation->set_rules('college','College','trim');
        $this->form_validation->set_rules('course','Course','trim');
        $this->form_validation->set_rules('sem_year','Semester/Year','trim');
        $this->form_validation->set_rules('status','Status','trim');
        $this->form_validation->set_rules('sort','Sort','trim|required');
        $this->form_validation->set_rules('key_words','Key Words','trim');
        $this->form_validation->set_rules('current_page', 'Current Page', 'trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data);
            } 
            else
            {
                $per_page = 10;
                $from_date = $this->input->post('from_date') ? $this->input->post('from_date') : date('Y-m-01');
                $from_date = strtotime($from_date);
                $from_date = date('Y-m-d', $from_date);
                $to_date = $this->input->post('to_date') ? $this->input->post('to_date') : date('Y-m-d');
                $to_date = strtotime($to_date);
                $to_date = date('Y-m-d', $to_date);
                $college = $this->input->post('college');
                $course = $this->input->post('course');
                $sem_year = $this->input->post('sem_year');
                $status = $this->input->post('status');
                $sort = $this->input->post('sort');
                $key_words = $this->input->post('key_words');
                $cur_page = $this->input->post('current_page');
                $total_row = $this->Enquirymodel->followup_count('enqry_db_list',$from_date,$to_date,'REG_DATE', $status,$sort,$key_words,$college, $course,$sem_year);
                $total_pages = ceil($total_row / 10);
                $data = $this->Enquirymodel->multiple_select($from_date,$to_date,'REG_DATE',$status,$sort,$key_words,'enqry_db_list',$college,$course, $sem_year,($cur_page - 1) * $per_page, $per_page)->result();
                if(count($data) > 0)
                 { 
                    foreach ($data as $key => $value) {
                        $value->NAME = strtoupper($value->NAME);
                    }
                     $return_value = array('status' => 1, 'data'=> $data);
                     $return_value['total_pages'] = $total_pages;
                     $return_value['total_row'] = $total_row;
                     header('Content-Type: application/json');
                     echo json_encode($return_value);
                    
                }
                else
                {
                     $data['status'] = 0;
                     $data['msg'] = "No Data Found";
                     header('Content-Type: application/json');
                     echo json_encode($data);
                }
            }
        }
    } 

    function api_followup_details() {
        $this->form_validation->set_rules('enquiry_id','Enquiry Id','trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $data['status'] = 1;
            $EnquiryId = $this->input->post('enquiry_id');
            $data['data'] = $this->Enquirymodel->selectbyid_data($EnquiryId,'api')->result();
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    } 

    function api_profile_details() {
        $this->form_validation->set_rules('enquiry_id','Enquiry Id','trim|required');
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else
        {
            $data['status'] = 1;
            $EnquiryId = $this->input->post('enquiry_id');
            $result = $this->Enquirymodel->select_data($EnquiryId)->row_array();
            if(count($data) > 0) { 
                $sql = "select * from tbl_followupvia where id=" . $result['FOLLOWUPVIA'];
                $query = $this->db->query($sql);
                $val = $query->row_array();
                $result['ENQUIRY_FROM'] = $val['methods'];
                if (array_key_exists("status",$result)) {
                    $result['enquiry_status'] = $result['status'];
                    unset($result['status']);
                }
                $return = array_merge($data, $result);
                header('Content-Type: application/json');
                echo json_encode($return);
            } else {
                $data['status'] = 0;
                $data['msg'] = "No Data Found";
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }
    function website_contact_form() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('Email', 'Email', 'required');
        $this->form_validation->set_rules('Phone', 'Phone', 'required|min_length[10]|max_length[14]');
        if ($this->form_validation->run() != false) 
        {
            $form_type = $this->input->post('form_type');
            $email = $this->input->post('Email');
            $phno = $this->input->post('Phone');
            $create_by = 199;
            $current_date = date("Y-m-d");
            if($form_type == 1)//Conatct Us Form and Training Popup Form
            {
                $name = $this->input->post('name');
                $msg = $this->input->post('message');
                $page_title = $this->input->post('entry_from');
                $description = $msg."</br>".$page_title;
                $data = array('NAME' => $name,
                // 'ENQTYPE' => $enqtype,
                'PHNO' => $phno,
                'MOBILENO' => $phno,
                'EMAIL' => $email,
                'DESCRIPTION' => $description,
                'FOLLOWUPVIA' => 10,
                'ENQIRY_ADDED_BY' => $create_by,
                'REG_DATE' => $current_date,
                'ENTRYDATE' => $current_date,
                'LASTFDATE' => $current_date,
                'NEXTFDATE' => $current_date,
                'STATUS' => 1,
                'DEL_FLAG' => 1,
                'ENQUIRY_TYPE' => 1);
            }
            if($form_type == 2)//Training Footer Contact
            {
                $Firstname = $this->input->post('name');
                $Lastname = $this->input->post('lastname');
                $name = $Firstname." ".$Lastname;
                $enquiry_for = $this->input->post('enquiry_for');
                $Subject = $this->input->post('Subject');
                $Message = $this->input->post('message');
                $page_title = $this->input->post('entry_from');
                $description = $Subject."-".$Message."</br>".$page_title;
                $data = array('NAME' => $name,
                'ENQTYPE' => $enquiry_for,
                'PHNO' => $phno,
                'MOBILENO' => $phno,
                'EMAIL' => $email,
                'DESCRIPTION' => $description,
                'FOLLOWUPVIA' => 10,
                'ENQIRY_ADDED_BY' => $create_by,
                'REG_DATE' => $current_date,
                'ENTRYDATE' => $current_date,
                'LASTFDATE' => $current_date,
                'NEXTFDATE' => $current_date,
                'STATUS' => 1,
                'DEL_FLAG' => 1,
                'ENQUIRY_TYPE' => 1);
            }
            if($form_type == 3)//Global Footer Contact(Request for services)
            {
                $Firstname = $this->input->post('name');
                $Lastname = $this->input->post('lastname');
                $name = $Firstname." ".$Lastname;
                $service_type = $this->input->post('service_type');
                $Subject = $this->input->post('Subject');
                $Message = $this->input->post('message');
                $page_title = $this->input->post('entry_from');
                $description = $service_type."-".$Subject."-".$Message."</br>".$page_title;
                $data = array('NAME' => $name,
                'PHNO' => $phno,
                'MOBILENO' => $phno,
                'EMAIL' => $email,
                'DESCRIPTION' => $description,
                'FOLLOWUPVIA' => 10,
                'ENQIRY_ADDED_BY' => $create_by,
                'REG_DATE' => $current_date,
                'ENTRYDATE' => $current_date,
                'LASTFDATE' => $current_date,
                'NEXTFDATE' => $current_date,
                'STATUS' => 1,
                'DEL_FLAG' => 1,
                'ENQUIRY_TYPE' => 1);
            }
            if($form_type == 4)//HTML from https://softloom.com//training/
            {
                $name = $this->input->post('name');
                $enqtype = $this->input->post('enguiry_for');
                $enquiry_from = $this->input->post('enquiry_from');
                $contact_message = $this->input->post('contact_message');
                $description = $contact_message."</br>".$enquiry_from;
                $data = array('NAME' => $name,
                'ENQTYPE' => $enqtype,
                'PHNO' => $phno,
                'MOBILENO' => $phno,
                'EMAIL' => $email,
                'DESCRIPTION' => $description,
                'FOLLOWUPVIA' => 10,
                'ENQIRY_ADDED_BY' => $create_by,
                'REG_DATE' => $current_date,
                'ENTRYDATE' => $current_date,
                'LASTFDATE' => $current_date,
                'NEXTFDATE' => $current_date,
                'STATUS' => 1,
                'DEL_FLAG' => 1,
                'ENQUIRY_TYPE' => 1);
            }
            $this->Enquirymodel->insert_data('tbl_enquiry', $data);
            $enqid = $this->db->insert_id();
            $followupdata = array('EN_ID' => $enqid,
                'STATUS' => 1,
                'FDATE' => $current_date,
                'NEXTFDATE' => $current_date,
                'description' => $description,
                'FOLLOWUP_ADDED_BY' => $create_by,
                'DEL_FLAG' => 1,
                'ENTRY_DATE' => $current_date
            );
            $this->Enquirymodel->insert_data('tbl_followup', $followupdata);
            $this->Enquirymodel->delete_spam_messages('tbl_enquiry','ENQIRY_ADDED_BY');
            $this->Enquirymodel->delete_spam_messages('tbl_followup','FOLLOWUP_ADDED_BY');
            redirect('https://softloom.com/contact/');
        }
    }        
}