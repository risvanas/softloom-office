<?php

class Followup extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('template'));
        $this->template->set_template('admin_template');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $this->load->library('form_validation');
        $this->load->model('Followupmodel');
    }

    function Index() {
        $menu_id = 48;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_addprocess($menu_id);
        $en_id = $this->input->post('txt_en_id');
        $frm = $this->input->post('txt_frm');
        $status = $this->input->post('txtstatus');
        $fdate1 = $this->input->post('txtfdate');
        $x = strtotime($fdate1);
        $fdate = date('Y-m-d', $x);
        $nfdate1 = $this->input->post('txtnfdate');
        $y = strtotime($nfdate1);
        $nfdate = date('Y-m-d', $y);
        $desp = $this->input->post('txtdesp');
        $entrydate = date('Y-m-d');
        $sess_array = $this->session->userdata('logged_in');
        $create_by = $sess_array['user_id'];
        $data = array('EN_ID' => $en_id,
            'STATUS' => $status,
            'FDATE' => $fdate,
            'NEXTFDATE' => $nfdate,
            'description' => $desp,
            'DEL_FLAG' => '1',
            'FOLLOWUP_ADDED_BY' => $create_by,
            'ENTRY_DATE' => $entrydate);
        $this->Followupmodel->insert_data('tbl_followup', $data);
        $data2 = array(
            'STATUS' => $status,
            'NEXTFDATE' => $nfdate,
            'LASTFDATE' => $fdate
        );
        $this->Followupmodel->enquiry_update('tbl_enquiry', $data2, $en_id);
        if($frm == 'followup') {
            redirect('enquiry/followup_history');
        } else if($frm == 'followup_db') {
            redirect('enquiry/followup_db_history');
        } else {
            redirect('enquiry/enquiry_details');
        }
        $layout = array('page' => 'form_enquiry', 'title' => 'Registration');
        render_template($layout);
    }

    function followup_details() {
        $menu_id = 48;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['x'] = $this->Followupmodel->statustype('tbl_status');
        $page = 1;
        $per_page = 10;
        $currnt_date = date('Y-m-d');
        $total_row = $this->Followupmodel->followup_count($currnt_date,$currnt_date,'Entrydate');
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['s'] = $this->Followupmodel->select_data(0, $per_page);
        $data['eid'] = $this->Followupmodel->select_en_id('tbl_followup');
        $layout = array('page' => 'form_followuplist', 'title' => 'view followups', 'data' => $data);
        render_template($layout);
    }

    function delete_followup_details() {
        $menu_id = 48;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
        $data = array('DEL_FLAG' => '0');
        $this->Followupmodel->fupdate_data('tbl_followup', $data, $id);
        $this->followup_details();
    }

    function find_followup_details() {
        $menu_id = 48;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $eid = $this->uri->segment(4);
        $data['status'] = $this->Followupmodel->statustype('tbl_status');
        $data['s'] = $this->Followupmodel->fselectbyid_data('tbl_followup', $id);
        $layout = array('page' => 'form_followup_edit', 'title' => 'edit followup', 'data' => $data);
        render_template($layout);
    }

    function update_followup_details() {
        $id = $this->input->post('txtid');
        $eid = $this->input->post('txt_eid');
        $status = $this->input->post('txtstatus');
        $fdate1 = $this->input->post('txtfdate');
        $fd = strtotime($fdate1);
        $fdte = date('Y-m-d', $fd);
        $nfdate1 = $this->input->post('txtnfdate');
        $nfd = strtotime($nfdate1);
        $nfdte = date('Y-m-d', $nfd);
        $desp = $this->input->post('txtdesp');
        $entrydate = date('Y-m-d');
        $data = array(
            'STATUS' => $status,
            'FDATE' => $fdte,
            'NEXTFDATE' => $nfdte,
            'DESCRIPTION' => $desp,
            'ENTRY_DATE' => $entrydate);
        $enq_data = array(
            'NEXTFDATE' => $nfdte,
            'LASTFDATE' => $fdte,
        );
        $this->Followupmodel->update_data('tbl_followup', $data, $id);
        $this->Followupmodel->update_enquiry_data('tbl_enquiry', $enq_data, $eid);
        $this->followup_details();
    }

    function search_details() {
        $d1 = $this->input->post('datefrom');
        $d2 = $this->input->post('dateto');
        $dtype = $this->input->post('dtype');
        $stype = $this->input->post('stype');
        $sort = $this->input->post('sorttype');
        $sr = $this->input->post('searcher');
        $per_page = $this->input->post('per_page');
        $cur_page = $this->input->post('cur_page');
//        $d1 = substr($dat, 0, 10);
//        $d2 = substr($dat, 12);
        $dat = $d1 . " - " . $d2;
        $x = strtotime($d1);
        $y = strtotime($d2);
        $from = date('Y-m-d', $x);
        $to = date('Y-m-d', $y);
        $total_row = $this->Followupmodel->followup_count($from, $to, $dtype, $stype, $sort, $sr, $dat);
        $data['sl_no'] = ($cur_page - 1) * $per_page;
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $cur_page, $total_row, $total_pages);
        $data['s'] = $this->Followupmodel->multiple_select($dtype, $stype, $sort, $from, $to, $sr, $dat,($cur_page - 1) * $per_page, $per_page);
        $this->load->view('search_data', $data);
    }

    function api_followup_history()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        $this->form_validation->set_rules('date','Date','trim|required');
        $this->form_validation->set_rules('status','Status','trim');
        $this->form_validation->set_rules('sort','Sort','trim');
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
                 $date = $this->input->post('date') ?  $this->input->post('date') : 'LASTFDATE';
                 $status = $this->input->post('status');
                 $sort = $this->input->post('sort');
                 $key_words = $this->input->post('key_words');
                 $dat = $from_date . " - " . $to_date;
                 $cur_page = $this->input->post('current_page');
                 $total_row = $this->Followupmodel->followup_count($from_date, $to_date, $date, $status, $sort, $key_words, $dat);
                 $total_pages = ceil($total_row / 10);
                 $data = $this->Followupmodel->multiple_select($date, $status, $sort, $from_date, $to_date, $key_words, $dat,($cur_page - 1) * $per_page, $per_page)->result();
                 if(count($data) > 0)
                 { 
                    foreach ($data as $key => $value) {
                        $value->NAME = strtoupper($value->NAME);
                        if (array_key_exists("ENTRY_DATE",$value)) {
                            $value->FOLLOWUP_ENTRY_DATE = $value->ENTRY_DATE;
                            unset($value->ENTRY_DATE);
                        }
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

    function api_new_followup() {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('enquiry_id','Enquiry Id','trim|required');
        $this->form_validation->set_rules('enquiry_status','Enquiry Status','trim|required');
        $this->form_validation->set_rules('followup_date','Followup Date','trim|required');
        $this->form_validation->set_rules('next_followup_date','Next Followup date','trim');
        $this->form_validation->set_rules('description','Description','trim|required');
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
            } 
            else 
            {
                $en_id = $this->input->post('enquiry_id');
                $status = $this->input->post('enquiry_status');
                $fdate1 = $this->input->post('followup_date');
                $x = strtotime($fdate1);
                $fdate = date('Y-m-d', $x);
                $nfdate1 = $this->input->post('next_followup_date');
                $y = strtotime($nfdate1);
                $nfdate = date('Y-m-d', $y);
                $desp = $this->input->post('description');
                $entrydate = date('Y-m-d');
                $data = array('EN_ID' => $en_id,
                    'STATUS' => $status,
                    'FDATE' => $fdate,
                    'NEXTFDATE' => $nfdate,
                    'description' => $desp,
                    'DEL_FLAG' => '1',
                    'FOLLOWUP_ADDED_BY' => $user_id,
                    'ENTRY_DATE' => $entrydate);
                $this->Followupmodel->insert_data('tbl_followup', $data);
                $data2 = array(
                    'STATUS' => $status,
                    'NEXTFDATE' => $nfdate,
                    'LASTFDATE' => $fdate
                );
                $this->Followupmodel->enquiry_update('tbl_enquiry', $data2, $en_id);
                $return = array(
                    'status' => 1,
                    'enquiry_id' => $en_id,
                    'enquiry_status' => $status,
                    'followup_date' => $fdate1,
                    'next_followup_date' => $nfdate1,
                    'description' => $desp
                );
                header('Content-Type: application/json');
                echo json_encode($return);
            }
        }
        
    }

    function api_followup_edit(){
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('followup_id', 'Follow Up Id','trim|required');
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
                $id = $this->input->post('followup_id');
                $data['status'] = 1;
                $result = $this->Followupmodel->fselectbyid_data('tbl_followup', $id, 'api')->row_array();
                $result['Followup_Status'] = $this->Followupmodel->statustype('tbl_status',$result['STATUS'])->row_array()['status'];
                if (array_key_exists("STATUS",$result)) {
                    $result['follwup_status'] = $result['STATUS'];
                    unset($result['STATUS']);
                }
                $return = array_merge($data, $result);
                header('Content-Type: application/json');
                echo json_encode($return); 
            }
        }
    }

    function api_update_followup_details() {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('enquiry_id','Enquiry Id','trim|required');
        $this->form_validation->set_rules('followup_id','Followup Id','trim|required');
        $this->form_validation->set_rules('enquiry_status','Enquiry Status','trim|required');
        $this->form_validation->set_rules('followup_date','Followup Date','trim|required');
        $this->form_validation->set_rules('next_followup_date','Next Followup date','trim');
        $this->form_validation->set_rules('description','Description','trim|required');
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

                $id = $this->input->post('followup_id');
                $eid = $this->input->post('enquiry_id');
                $status = $this->input->post('enquiry_status');
                $fdate1 = $this->input->post('followup_date');
                $fd = strtotime($fdate1);
                $fdte = date('Y-m-d', $fd);
                $nfdate1 = $this->input->post('next_followup_date');
                $nfd = strtotime($nfdate1);
                $nfdte = date('Y-m-d', $nfd);
                $desp = $this->input->post('description');
                $entrydate = date('Y-m-d');
                $data = array(
                    'STATUS' => $status,
                    'FDATE' => $fdte,
                    'NEXTFDATE' => $nfdte,
                    'DESCRIPTION' => $desp,
                    'ENTRY_DATE' => $entrydate);
                $enq_data = array(
                    'NEXTFDATE' => $nfdte,
                    'LASTFDATE' => $fdte,
                );
                $this->Followupmodel->update_data('tbl_followup', $data, $id);
                $this->Followupmodel->update_enquiry_data('tbl_enquiry', $enq_data, $eid);
                $return = array(
                    'status' => 1,
                    'followup_id' => $id,
                    'enquiry_id' => $eid,
                    'enquiry_status' => $status,
                    'followup_date' => $fdate1,
                    'next_followup_date' => $nfdate1,
                    'description' => $desp
                );
                header('Content-Type: application/json');
                echo json_encode($return);
            }
        }
    }

}

?>