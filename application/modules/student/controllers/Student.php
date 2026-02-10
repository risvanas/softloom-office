<?php

class Student extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->load->helper('date');
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('student_model');
    }

    function index() {
        $menu_id = 23;
        $this->load->library('../controllers/permition_checker');
        $data['parent_account'] = $this->student_model->selectAll('tbl_student');
        $data['course'] = $this->student_model->sel_course('tbl_account');
        $data['status'] = $this->student_model->select_status('tbl_status');
        $data['district'] = $this->student_model->select_district('tbl_districts');

        $this->form_validation->set_rules('txt_stud_name', 'Student_name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['msg'] = "";
            $data['errmsg'] = '';
            $layout = array('page' => 'form_student_reg', 'title' => 'Student', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $stud_name = $this->input->post('txt_stud_name');
            $address1 = $this->input->post('txt_address1');
            $address2 = $this->input->post('txt_address2');
            $address3 = $this->input->post('txt_address3');
            $contact = $this->input->post('txt_contact');
            $contact2 = $this->input->post('txt_contact2');
            $pinnum = $this->input->post('txt_pinnum');
            $district = $this->input->post('txt_district');
            $email = $this->input->post('txt_email');
            $gender = $this->input->post('rad_gender');
            $stud_dob = $this->input->post('txt_stud_dobdate');
            $course = $this->input->post('txt_stud_course');
            $status = $this->input->post('status');
            $reg_date = $this->input->post('txt_stud_regdate');
            $time1 = strtotime($reg_date);
            $reg_date1 = date("Y-m-d", $time1);

            $due_date = $this->input->post('txt_stud_duedate');
            $time2 = strtotime($due_date);
            $d1 = date("Y-m-d", $time2);

            $fee_amount = $this->input->post('txt_feeamt');
            $ad_amount = $this->input->post('txt_advance');
            $remark = $this->input->post('txt_remark');

            $course1 = $this->input->post('txt_course1');
            $college1 = $this->input->post('txt_college1');
            $year1 = $this->input->post('txt_year1');
            $mark1 = $this->input->post('txt_marks1');
            $course2 = $this->input->post('txt_course2');
            $college2 = $this->input->post('txt_college2');
            $year2 = $this->input->post('txt_year2');
            $mark2 = $this->input->post('txt_marks2');
            $course3 = $this->input->post('txt_course3');
            $college3 = $this->input->post('txt_college3');
            $year3 = $this->input->post('txt_year3');
            $mark3 = $this->input->post('txt_marks3');

            $entry_date = date('Y-m-d');
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($reg_date);
            $check_status = $this->lockdate->check_date($reg_date);
            $message_display = $this->lockdate->message_val($reg_date, $check_status);
            if ($check_status == 'true') {
                $data['msg'] = '';
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_student_reg', 'title' => 'Student', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $query = $this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=$course ");
            $row = $query->row_array();
            $course_name = $row['ACC_NAME'];
            $remarks = $course_name . " Course Fee for" . " " . $stud_name;

            $dat = array(
                'NAME' => $stud_name,
                'ADDRESS1' => $address1,
                'ADDRESS2' => $address2,
                'ADDRESS3' => $address3,
                'DISTRICT' => $district,
                'PIN_NUM' => $pinnum,
                'CONTACT_NO' => $contact,
                'CONTACT_NO2' => $contact2,
                'STUD_EMAIL' => $email,
                'GENDER' => $gender,
                'STUDENT_DOB' => $stud_dob,
                'COURSE' => $course,
                'STATUS' => $status,
                'REG_DATE' => $reg_date1,
                'DUE_DATE' => $d1,
                'FEE_AMOUNT' => $fee_amount,
                'ADVANCE_AMT' => $ad_amount,
                'COURSE_NAME' => $course1,
                'COLLEGE_NAME' => $college1,
                'YEAR' => $year1,
                'MARKS' => $mark1,
                'COURSE_NAME1' => $course2,
                'COLLEGE_NAME1' => $college2,
                'YEAR1' => $year2,
                'MARKS1' => $mark2,
                'COURSE_NAME2' => $course3,
                'COLLEGE_NAME2' => $college3,
                'YEAR2' => $year3,
                'MARKS2' => $mark3,
                'REMARK' => $remark,
                'CREATED_DATE' => $entry_date,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);
            $this->student_model->stud_insert('tbl_student', $dat);
            $stud_id = $this->db->insert_id();

            $sess_array = $this->session->userdata('logged_in');
            $company_code = $sess_array['comp_code'];

            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SAL' and COMPANY='$company_code' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1 ");

            $row = $query->row_array();
            $book_num = $row['BOOK_NUMBER'];


            $trn_data = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 31,
                'DATE_OF_TRANSACTION' => $reg_date1,
                'CREDIT' => $fee_amount,
                'REMARKS' => $remarks,
                /* 'TRANS_TYPE'=>'cash', */
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'SAL',
                'SRC_ID' => $stud_id,
                'SUB_ACC' => $course,
                'COMPANY' => $company_code,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);
            $trn_data1 = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 38,
                'DATE_OF_TRANSACTION' => $reg_date1,
                'DEBIT' => $fee_amount,
                'REMARKS' => $remarks,
                /* TRANS_TYPE'=>'cash', */
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'SAL',
                'SRC_ID' => $stud_id,
                'SUB_ACC' => $course,
                'COMPANY' => $company_code,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);

            $this->student_model->stud_insert('tbl_transaction', $trn_data);
            $this->student_model->stud_insert('tbl_transaction', $trn_data1);

            $query = $this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 100)+1 AS PAY_NUMBER FROM tbl_payment WHERE TYPE='STD' and COMPANY='$company_code' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1 ");
            $row = $query->row_array();
            $pay_num = $row['PAY_NUMBER'];

            if ($ad_amount != "") {
                $pay_data = array('PAY_NUMBER' => $pay_num,
                    'STUDENT_ID' => $stud_id,
                    'AMOUNT' => $ad_amount,
                    'TRANSACTION_TYPE' => 'cash',
                    'ENTRY_DATE' => $entry_date,
                    'PAYMENT_DATE' => $reg_date1,
                    'REMARKS' => 'ADVANCE',
                    'TYPE' => 'STD',
                    'FIN_YEAR_ID' => 2,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'ACC_YEAR_CODE' => $year_code);
                $this->student_model->stud_insert('tbl_payment', $pay_data);
                $last_ins_payid = $this->db->insert_id();
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER
                    FROM tbl_transaction WHERE BOOK_NAME='PAY' and COMPANY='$company_code' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1 ");

                $row = $query->row_array();
                $book_num = $row['BOOK_NUMBER'];

                $trn_data2 = array('FIN_YEAR_ID' => 2,
                    'ACC_ID' => 39,
                    'DATE_OF_TRANSACTION' => $reg_date1,
                    'DEBIT' => $ad_amount,
                    'REMARKS' => $remarks,
                    /* 'TRANS_TYPE'=>'cash', */
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    /* 'SRC_ID'=>$stud_id,
                      'SUB_ACC'=>$course, */
                    'PAYMENT_ID' => $last_ins_payid,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'ACC_YEAR_CODE' => $year_code);

                $trn_data3 = array('FIN_YEAR_ID' => 2,
                    'ACC_ID' => 38,
                    'DATE_OF_TRANSACTION' => $reg_date1,
                    'CREDIT' => $ad_amount,
                    'REMARKS' => $remarks,
                    /* 	 'TRANS_TYPE'=>'cash', */
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    'SRC_ID' => $stud_id,
                    'SUB_ACC' => $course,
                    'PAYMENT_ID' => $last_ins_payid,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'ACC_YEAR_CODE' => $year_code);

                $this->student_model->stud_insert('tbl_transaction', $trn_data2);
                $this->student_model->stud_insert('tbl_transaction', $trn_data3);
            }
            $data['msg'] = 'New student added successfully';
            $data['errmsg'] = '';
            $layout = array('page' => 'form_student_reg', 'title' => 'New Student', 'data' => $data);
            render_template($layout);
        }
    }

    function student_list() {
        $menu_id = 24;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['status'] = $this->student_model->select_status('tbl_status');
        $data['course'] = $this->student_model->sel_course('tbl_account');
        $data['course_list'] = $this->student_model->join_course_list('tbl_student');
        $layout = array('page' => 'form_studentlist', 'title' => 'Student List', 'data' => $data);
        render_template($layout);
    }

    function student_edit() {
        $menu_id = 23;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $this->load->model('student_model');
        $data['student_edit'] = $this->student_model->edit('tbl_student', $id);
        $data['parent_account'] = $this->student_model->selectAll('tbl_student');
        $data['dis'] = $this->student_model->select_district('tbl_districts');
        $data['res'] = $this->student_model->sel_course('tbl_account');
        $data['stat'] = $this->student_model->select_status('tbl_status');
        $layout = array('page' => 'form_student_edit', 'data' => $data);
        render_template($layout);
    }

    function student_update() {

        $this->form_validation->set_rules('txt_stud_name', 'Student_name', 'required');

        if ($this->form_validation->run() != FALSE) {
            $id = $this->input->post('txt_id');
            $stud_name = $this->input->post('txt_stud_name');
            $address1 = $this->input->post('txt_address1');
            $address2 = $this->input->post('txt_address2');
            $address3 = $this->input->post('txt_address3');
            $contact = $this->input->post('txt_contact');
            $contact2 = $this->input->post('txt_contact2');
            $district = $this->input->post('txt_district');
            $pinnum = $this->input->post('txt_pinnum');
            $email = $this->input->post('txt_email');
            $gender = $this->input->post('rad_gender');
            $stud_dob = $this->input->post('txt_stud_dobdate');
            $course = $this->input->post('txt_acc_name');
            $hdd_course = $this->input->post('hidden_acc_name');
            $status = $this->input->post('status');
            $reg_date = $this->input->post('txt_stud_regdate');
            $time1 = strtotime($reg_date);
            $reg_date1 = date("Y-m-d", $time1);

            $hdd_reg_date = $this->input->post('hdd_stud_regdate');
            $time1 = strtotime($hdd_reg_date);
            $hdd_reg_date1 = date("Y-m-d", $time1);

            $entry_date = date("Y-m-d");

            $due_date = $this->input->post('txt_stud_duedate');
            $time2 = strtotime($due_date);
            $due_date1 = date("Y-m-d", $time2);
            $fee_amount = $this->input->post('txt_feeamt');
            $hdd_fee_amount = $this->input->post('hidden_stud_feeamt');

            $ad_amount = $this->input->post('txt_advance');
            $hdd_ad_amount = $this->input->post('hidden_advance_amt');

            $remark = $this->input->post('txt_remark');

            $course1 = $this->input->post('txt_course1');
            $college1 = $this->input->post('txt_college1');
            $year1 = $this->input->post('txt_year1');
            $mark1 = $this->input->post('txt_marks1');
            $course2 = $this->input->post('txt_course2');
            $college2 = $this->input->post('txt_college2');
            $year2 = $this->input->post('txt_year2');
            $mark2 = $this->input->post('txt_marks2');
            $course3 = $this->input->post('txt_course3');
            $college3 = $this->input->post('txt_college3');
            $year3 = $this->input->post('txt_year3');
            $mark3 = $this->input->post('txt_marks3');
            $sess_array = $this->session->userdata('logged_in');
            $modified_by = $sess_array['user_id'];
            $year_code = $sess_array['accounting_year'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $modified_on = gmdate("Y-m-d H:i:s");
            $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_student where STUDENT_ID=$id AND DEL_FLAG=1");
            $val2 = $query2->row_array();
            $acc_year = $val2['ACC_YEAR_CODE'];
            if ($year_code != $acc_year) {
                $data['parent_account'] = $this->student_model->selectAll('tbl_student');
                $data['course'] = $this->student_model->sel_course('tbl_account');
                $data['status'] = $this->student_model->select_status('tbl_status');
                $data['district'] = $this->student_model->select_district('tbl_districts');

                $data['msg'] = "";
                $data['errmsg'] = 'Accounting Year Do not Match';
                $layout = array('page' => 'form_student_reg', 'title' => 'Student', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($reg_date);
            $check_status = $this->lockdate->check_date($reg_date);
            $message_display = $this->lockdate->message_val($reg_date, $check_status);
            if ($check_status == 'true') {
                $data['parent_account'] = $this->student_model->selectAll('tbl_student');
                $data['course'] = $this->student_model->sel_course('tbl_account');
                $data['status'] = $this->student_model->select_status('tbl_status');
                $data['district'] = $this->student_model->select_district('tbl_districts');

                $data['msg'] = "";
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_student_reg', 'title' => 'Student', 'data' => $data);
                render_template($layout);
                return FALSE;
            }

            $dat = array(
                'NAME' => $stud_name,
                'ADDRESS1' => $address1,
                'ADDRESS2' => $address2,
                'ADDRESS3' => $address3,
                'DISTRICT' => $district,
                'PIN_NUM' => $pinnum,
                'CONTACT_NO' => $contact,
                'CONTACT_NO2' => $contact2,
                'STUD_EMAIL' => $email,
                'GENDER' => $gender,
                'STUDENT_DOB' => $stud_dob,
                'COURSE' => $course,
                'STATUS' => $status,
                'REG_DATE' => $reg_date1,
                'DUE_DATE' => $due_date1,
                'FEE_AMOUNT' => $fee_amount,
                'ADVANCE_AMT' => $ad_amount,
                'COURSE_NAME' => $course1,
                'COLLEGE_NAME' => $college1,
                'YEAR' => $year1,
                'MARKS' => $mark1,
                'COURSE_NAME1' => $course2,
                'COLLEGE_NAME1' => $college2,
                'YEAR1' => $year2,
                'MARKS1' => $mark2,
                'COURSE_NAME2' => $course3,
                'COLLEGE_NAME2' => $college3,
                'YEAR2' => $year3,
                'MARKS2' => $mark3,
                'REMARK' => $remark,
                'MODIFIED_BY' => $modified_by,
                'MODIFIED_ON' => $modified_on,
                'LOCATION_DETAILS' => $location_details);

            $this->load->model('student_model');
            $this->student_model->stud_update('tbl_student', $dat, $id);

            $sess_array = $this->session->userdata('logged_in');
            $company_code = $sess_array['comp_code'];

            if ($hdd_fee_amount != $fee_amount || $hdd_course != $course || $hdd_reg_date != $reg_date) {
                $query = $this->db->query("select * from tbl_transaction where SRC_ID=$id AND BOOK_NAME='SAL' and COMPANY='$company_code'");
                if ($query->num_rows() > 0) {
                    $row = $query->row_array();
                    $book_num = $row['BOOK_NUMBER'];


                    $this->db->query("update tbl_transaction set DEL_FLAG=0 where SRC_ID=$id AND BOOK_NAME='SAL' and COMPANY='$company_code' ");

                    $query = $this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=$course ");
                    $row = $query->row_array();
                    $course_name = $row['ACC_NAME'];
                    $remarks = $course_name . " Course Fee for" . " " . $stud_name;



                    $trn_data = array('FIN_YEAR_ID' => 2,
                        'ACC_ID' => 31,
                        'DATE_OF_TRANSACTION' => $reg_date1,
                        'CREDIT' => $fee_amount,
                        'REMARKS' => $remarks,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'SAL',
                        'SRC_ID' => $id,
                        'SUB_ACC' => $course,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details,
                        'ACC_YEAR_CODE' => $year_code);
                    $trn_data1 = array('FIN_YEAR_ID' => 2,
                        'ACC_ID' => 38,
                        'DATE_OF_TRANSACTION' => $reg_date1,
                        'DEBIT' => $fee_amount,
                        'REMARKS' => $remarks,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'SAL',
                        'SRC_ID' => $id,
                        'SUB_ACC' => $course,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details,
                        'ACC_YEAR_CODE' => $year_code);

                    $this->student_model->stud_insert('tbl_transaction', $trn_data);
                    $this->student_model->stud_insert('tbl_transaction', $trn_data1);
                } else {
                    $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER
                        FROM tbl_transaction WHERE BOOK_NAME='SAL' and COMPANY = '$company_code' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1 ");
                    $row = $query->row_array();
                    $book_num = $row['BOOK_NUMBER'];

                    $trn_data = array('FIN_YEAR_ID' => 2,
                        'ACC_ID' => 31,
                        'DATE_OF_TRANSACTION' => $reg_date1,
                        'CREDIT' => $fee_amount,
                        'REMARKS' => $remarks,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'SAL',
                        'SRC_ID' => $id,
                        'SUB_ACC' => $course,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details,
                        'ACC_YEAR_CODE' => $year_code);
                    $trn_data1 = array('FIN_YEAR_ID' => 2,
                        'ACC_ID' => 38,
                        'DATE_OF_TRANSACTION' => $reg_date1,
                        'DEBIT' => $fee_amount,
                        'REMARKS' => $remarks,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'SAL',
                        'SRC_ID' => $id,
                        'SUB_ACC' => $course,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details,
                        'ACC_YEAR_CODE' => $year_code);

                    $this->student_model->stud_insert('tbl_transaction', $trn_data);
                    $this->student_model->stud_insert('tbl_transaction', $trn_data1);
                }
            }
        }

        //PaymentAmount_updateCode

        $this->student_list();
    }

    function student_delete() {
        $menu_id = 23;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $year_code = $sess_array['accounting_year'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $id = $this->uri->segment(3);
        $query2 = $this->db->query("select ACC_YEAR_CODE,REG_DATE from tbl_student where STUDENT_ID=$id AND DEL_FLAG=1");
        $val2 = $query2->row_array();
        $acc_year = $val2['ACC_YEAR_CODE'];
        $this->load->library('../controllers/lockdate');
        $reg_date = $val2['REG_DATE'];
        $check_status = $this->lockdate->check_date($reg_date);
        $message_display = $this->lockdate->message_val($reg_date, $check_status);
        if ($message_display == '') {
            $message_display = 'Accounting Year Do not Match';
        }
        if ($year_code == $acc_year && $check_status == 'false') {
            $dat = array('DEL_FLAG' => '0',
                'DELETED_BY' => $deleted_by,
                'DELETED_ON' => $deleted_on,
                'LOCATION_DETAILS' => $location_details);
            $this->load->model('student_model');
            $this->student_model->delete('tbl_student', $id, $dat);
            $this->student_list();
        } else {
            $data['parent_account'] = $this->student_model->selectAll('tbl_student');
            $data['course'] = $this->student_model->sel_course('tbl_account');
            $data['status'] = $this->student_model->select_status('tbl_status');
            $data['district'] = $this->student_model->select_district('tbl_districts');
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_student_reg', 'title' => 'Student', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
    }

    function mult_search() {
//        $calc = $this->input->post('calc');
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $dtype = $this->input->post('dat');
        $course = $this->input->post('course');
        $stat = $this->input->post('stat');
        $key_words = $this->input->post('key_words');
        $generate_pdf = $this->input->post('generate_pdf');
        $from_date = $this->input->post('fromdate');
        $to_date = $this->input->post('todate');
        $sort_by = $this->input->post('sort_by');
		$type=$this->input->post('type');
		$data['type']=$type;
//        $rdate = substr($calc, 0, 10);
//        $time1 = strtotime($rdate);
//        $from = date("Y-m-d", $time1);
        $from_date = strtotime($from_date);
        $from = date("Y-m-d", $from_date);

//        $ddate = substr($calc, 12);
//        $time2 = strtotime($ddate);
//        $to = date("Y-m-d", $time2);
        $to_date = strtotime($to_date);
        $to = date("Y-m-d", $to_date);

        $this->load->model('Student_model');
        $data['company'] = $this->Student_model->select_company($company);
        $data['s'] = $this->Student_model->multipe_select($from, $to, $dtype, $course, $stat, $key_words, $sort_by);
        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
            $html = $this->load->view('studentlist_pdf', $data, true);
            $filename = 'studentlist_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'studentlist_report_' . time() . '.xls';
            $html = $this->load->view('studentlist_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
			if($type=="rpt") 
			{
				$this->load->view('form_student_search_report',$data);
			}
			else
			{
            $this->load->view('form_search_data', $data);
			}
        }
    }
	function student_report()
	{
        $menu_id = 78;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['status'] = $this->student_model->select_status('tbl_status');
        $data['course'] = $this->student_model->sel_course('tbl_account');
		$sess_array = $this->session->userdata('logged_in');
		$year_code = $sess_array['accounting_year'];
		$data['accounting_year'] = $this->student_model->select_year($year_code);
        $layout = array('page' => 'form_studentreport', 'title' => 'Fee Summary', 'data' => $data);
        render_template($layout);
    }

    ////$data['search']=$this->Student_model-> sample('tbl_student',$sname,$cname,$stat);
}

?>