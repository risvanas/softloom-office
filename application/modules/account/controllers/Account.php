<?php

class Account extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('account_model');
    }

    function index() {
        $menu_id = 13;
        $this->load->library('../controllers/permition_checker');
        $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');

        $data['msg'] = "";
        $this->form_validation->set_rules('txt_acc_code', 'Acc_code', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_accreg', 'title' => 'Account', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $acc_code = $this->input->post('txt_acc_code');
            $acc_name = $this->input->post('txt_name');
            $acc_level = $this->input->post('drp_acc_level');
            $parent_acc = $this->input->post('drp_acc_parent');
            $acc_group = $this->input->post('txt_acc_group');
            $status = $this->input->post('drp_status');
            $acc_type = $this->input->post('drp_acc_type');
            $opng_balance = $this->input->post('txt_opng_balance');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $data = array('COMPANY_ID' => '1',
                'ACC_LEVEL' => $acc_level,
                'PARENT_ACC_ID' => $parent_acc,
                'ACC_CODE' => $acc_code,
                'ACC_NAME' => $acc_name,
                'ACC_GROUP' => $acc_group,
                'STATUS' => $status,
                'ACC_TYPE' => $acc_type,
                'TYPE' => 'M',
                'OPENING_BALANCE' => $opng_balance,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details
            );

            $this->account_model->acc_insert('tbl_account', $data);
            $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');
            $data['msg'] = 'New Account added successfully';
            $layout = array('page' => 'form_accreg', 'title' => 'Account', 'data' => $data);
            render_template($layout);
        }
    }

    function subaccount() {
        $menu_id = 15;
        $this->load->library('../controllers/permition_checker');

        $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');
        $this->form_validation->set_rules('drp_account', 'Account', 'required');
        $data['msg'] = "";
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_subaccount', 'title' => 'Account', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $acc_code = $this->input->post('txt_acc_code');
            $acc_name = $this->input->post('txt_name');
            $parent_acc = $this->input->post('drp_account');
            $status = $this->input->post('drp_status');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $data = array('COMPANY_ID' => '1',
                'PARENT_ACC_ID' => $parent_acc,
                'ACC_CODE' => $acc_code,
                'ACC_NAME' => $acc_name,
                'STATUS' => $status,
                'TYPE' => 'S',
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $this->account_model->acc_insert('tbl_account', $data);

            $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');
            $data['msg'] = 'New Sub Account added successfully';
            $layout = array('page' => 'form_subaccount', 'title' => 'Account', 'data' => $data);
            render_template($layout);
        }
    }

    function staff_register() {
        $menu_id = 17;
        $this->load->library('../controllers/permition_checker');
        $data['desi'] = $this->account_model->select_designation('tbl_designation');
        $this->form_validation->set_rules('txt_staff_name', 'Staff_name', 'required');
        $data['msg'] = "";
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_staff_register', 'title' => 'Staff', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $staff_name = $this->input->post('txt_staff_name');
            $staff_code = $this->input->post('txt_staff_code');
            $staff_bio_code = $this->input->post('txt_staff_bio');
            $address1 = $this->input->post('txt_address1');
            $address2 = $this->input->post('txt_address2');
            $contact = $this->input->post('txt_contact');
            $email = $this->input->post('txt_email');
            $designation = $this->input->post('txt_staff_desi');
            $year = $this->input->post('txt_year');
            $mnth = $this->input->post('txt_staff_month');
            $joining_date = $this->input->post('txt_staff_jdate');
            $joining_date = strtotime($joining_date);
            $joining_date = date("Y-m-d", $joining_date);
            $cust_dob = $this->input->post('txt_staff_dobdate');
            $cust_dob = strtotime($cust_dob);
            $cust_dob = date("Y-m-d", $cust_dob);
            $genger = $this->input->post('rad_gender');
            $status = $this->input->post('status');
            $salary = $this->input->post('staff_salary');
            $remark = $this->input->post('txt_remark');
            $username = $this->input->post('txt_username');
            $password = $this->input->post('txt_password');
            $staff_mode = $this->input->post('staff_mode');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']	= '2048000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $data['err_msg'] = array('error' => $this->upload->display_errors());
                $profile_photo = "";
            } else {
                $profile_photo = $this->upload->data()['file_name'];
            }
            $data = array('COMPANY_ID' => '1',
                'PARENT_ACC_ID' => '46',
                'ACC_NAME' => $staff_name,
                'BIOMETRIC_CODE' => $staff_bio_code,
                'ACC_CODE' => $staff_code,
                'ADDRESS_ONE' => $address1,
                'ADDRESS_TWO' => $address2,
                'PHONE' => $contact,
                'ACC_EMAIL' => $email,
                'DESIGNATION' => $designation,
                'YEAR_OF_EXPRIANS' => $year,
                'MNTH_OF_EXPRIANS' => $mnth,
                'JOINING_DATE' => $joining_date,
                'PROFILE_PHOTO' => $profile_photo,
                'GENDER' => $genger,
                'CUST_DOB' => $cust_dob,
                'STATUS' => $status,
                'SALARY' => $salary,
                'ACC_MODE' => 'STAFF',
                'TYPE' => 'S',
                'REMARK' => $remark,
                'USER_NAME' => $username,
                'PASSWORD' => $password,
                'STAFF_MODE' => $staff_mode,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $this->account_model->acc_insert('tbl_account', $data);

            $data['desi'] = $this->account_model->select_designation('tbl_designation');
            $data['msg'] = 'New Staff added successfully';
            $layout = array('page' => 'form_staff_register', 'title' => 'Staff', 'data' => $data);
            render_template($layout);
        }
    }

    function customer_register() {
        $menu_id = 19;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txt_cust_name', 'customer_name', 'required');
        $data['msg'] = "";
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $layout = array('page' => 'form_customer_register', 'title' => 'Customer', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $cust_name = $this->input->post('txt_cust_name');
            $address1 = $this->input->post('txt_address1');
            $address2 = $this->input->post('txt_address2');
            $contact = $this->input->post('txt_contact');
            $email = $this->input->post('txt_email');
            $gst_no = $this->input->post('txt_gst_no');
//            $cust_dob = $this->input->post('txt_cust_dobdate');
//            $cust_dob = strtotime($cust_dob);
//            $cust_dob = date("Y-m-d", $cust_dob);
//            $genger = $this->input->post('rad_gender');
            $status = $this->input->post('status');
            $remark = $this->input->post('txt_remark');
            $op_balance = $this->input->post('txt_balance');
            $contact_person = $this->input->post('txt_contactperson');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");
            $data = array('COMPANY_ID' => '1',
                'PARENT_ACC_ID' => '47',
                'ACC_NAME' => $cust_name,
                'ADDRESS_ONE' => $address1,
                'ADDRESS_TWO' => $address2,
                'CONTACT_PERSON' => $contact_person,
                'PHONE' => $contact,
                'ACC_EMAIL' => $email,
                'TIN_NO' => $gst_no,
//                'GENDER' => $genger,
//                'CUST_DOB' => $cust_dob,
                'STATUS' => $status,
                'ACC_MODE' => 'CUSTOMER',
                'TYPE' => 'S',
                'REMARK' => $remark,
                'OPENING_BALANCE' => $op_balance,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $this->account_model->acc_insert('tbl_account', $data);
            $data['msg'] = 'New Customer added successfully';
            $layout = array('page' => 'form_customer_register', 'title' => 'Customer', 'data' => $data);
            render_template($layout);
        }
    }

    function mainaccount_list() {
        $menu_id = 14;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['cond'] = $this->account_model->select_mainaccount('tbl_account');
        $layout = array('page' => 'form_mainaccount_list', 'title' => 'Main Account List', 'data' => $data);
        render_template($layout);
    }

    function subaccount_list() {
        $menu_id = 16;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['cond'] = $this->account_model->select_subaccount('tbl_account');
        $layout = array('page' => 'form_subaccount_list', 'title' => 'Sub Account List', 'data' => $data);
        render_template($layout);
    }

    function staff_list() {
        $menu_id = 18;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['desi'] = $this->account_model->select_designation('tbl_designation');
        $per_page = 10;
        $total_row = $this->account_model->record_count('tbl_account', 'STAFF');
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['staff_list'] = $this->account_model->selectAll('tbl_account', 0, $per_page);
        $data['sl_no'] = ($page - 1) * $per_page + 1;
        $layout = array('page' => 'form_staff_list', 'title' => 'Staff List', 'data' => $data);
        render_template($layout);
    }

    function customer_list() {
        $menu_id = 20;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $per_page = 10;
        $total_row = $this->account_model->record_count('tbl_account', 'STAFF');
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $total_pages = ceil($total_row / $per_page);
        $this->load->library('../controllers/pagination');
        $data['pagination'] = $this->pagination->create_pagination($per_page, $page, $total_row, $total_pages);
        $data['sl_no'] = ($page - 1) * $per_page + 1;
        $data['customer_list'] = $this->account_model->selectcustomer('tbl_account',0, $per_page);
        $layout = array('page' => 'form_customer_list', 'title' => 'Customer List', 'data' => $data);
        render_template($layout);
    }

    function account_edit() {
        $menu_id = 13;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');
        $data['account_edit'] = $this->account_model->edit('tbl_account', $id);
        $layout = array('page' => 'form_account_edit', 'data' => $data);
        render_template($layout);
    }

    function subaccount_edit() {
        $menu_id = 15;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $data['accounts'] = $this->account_model->select_mainaccount('tbl_account');
        //$data['status']=$this->account_model->select_status('tbl_status');
        $data['subaccount_edit'] = $this->account_model->edit('tbl_account', $id);
        $layout = array('page' => 'form_subaccount_edit', 'data' => $data);
        render_template($layout);
    }

    function staff_edit() {
        $menu_id = 17;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);

        $data['desi'] = $this->account_model->select_designation('tbl_designation');
        $data['staff_edit'] = $this->account_model->edit('tbl_account', $id);
        $layout = array('page' => 'form_staff_edit', 'data' => $data);
        render_template($layout);
    }

    function customer_edit() {
        $menu_id = 19;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        echo $id = $this->uri->segment(3);
        $data['cust_edit'] = $this->account_model->edit('tbl_account', $id);
        $layout = array('page' => 'form_customer_edit', 'data' => $data);
        render_template($layout);
    }

    function mainaccount_update() {
        $id = $this->input->post('txt_acc_id');
        $acc_code = $this->input->post('txt_acc_code');
        $acc_name = $this->input->post('txt_name');
        $acc_level = $this->input->post('drp_acc_level');
        $parent_acc = $this->input->post('drp_acc_parent');
        $acc_group = $this->input->post('txt_acc_group');
        $status = $this->input->post('drp_status');
        $acc_type = $this->input->post('drp_acc_type');
        $opng_balance = $this->input->post('txt_opng_balance');
        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        $data = array('COMPANY_ID' => '1',
            'ACC_LEVEL' => $acc_level,
            'PARENT_ACC_ID' => $parent_acc,
            'ACC_CODE' => $acc_code,
            'ACC_NAME' => $acc_name,
            'ACC_GROUP' => $acc_group,
            'STATUS' => $status,
            'ACC_TYPE' => $acc_type,
            'TYPE' => 'M',
            'OPENING_BALANCE' => $opng_balance,
            'MODIFIED_BY' => $modified_by,
            'MODIFIED_ON' => $modified_on,
            'LOCATION_DETAILS' => $location_details
        );
        $this->account_model->acc_update('tbl_account', $data, $id);
        $this->mainaccount_list();
    }

    function subaccount_update() {

        $id = $this->input->post('txt_acc_id');
        $acc_code = $this->input->post('txt_acc_code');
        $acc_name = $this->input->post('txt_name');
        $parent_acc = $this->input->post('drp_account');
        $status = $this->input->post('drp_status');
        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        $data = array('COMPANY_ID' => '1',
            'PARENT_ACC_ID' => $parent_acc,
            'ACC_CODE' => $acc_code,
            'ACC_NAME' => $acc_name,
            'STATUS' => $status,
            'TYPE' => 'S',
            'MODIFIED_BY' => $modified_by,
            'MODIFIED_ON' => $modified_on,
            'LOCATION_DETAILS' => $location_details);
        $this->account_model->acc_update('tbl_account', $data, $id);
        $this->subaccount_list();
    }

    function staff_update() {
        $id = $this->input->post('txt_id');
        $staff_name = $this->input->post('txt_staff_name');
        $staff_code = $this->input->post('txt_staff_code');
        $staff_bio_code = $this->input->post('txt_staff_bio');
        $address1 = $this->input->post('txt_address1');
        $address2 = $this->input->post('txt_address2');
        $contact = $this->input->post('txt_contact');
        $email = $this->input->post('txt_email');
        $cust_dob = $this->input->post('txt_staff_dobdate');
        $cust_dob = strtotime($cust_dob);
        $cust_dob = date("Y-m-d", $cust_dob);
        $genger = $this->input->post('rad_gender');
        $designation = $this->input->post('txt_staff_desi');
        $year = $this->input->post('txt_year');
        $mnth = $this->input->post('txt_staff_month');
        $joining_date = $this->input->post('txt_staff_jdate');
        $joining_date = strtotime($joining_date);
        $joining_date = date("Y-m-d", $joining_date);
        $inactive_date = $this->input->post('txt_inactive_date');
        $inactive_date = strtotime($inactive_date);
        $inactive_date = date("Y-m-d", $inactive_date);
        $status = $this->input->post('status');
        $salary = $this->input->post('staff_salary');
        $remark = $this->input->post('txt_remark');
        $username = $this->input->post('txt_username');
        $password = $this->input->post('txt_password');
        $staff_mode = $this->input->post('staff_mode');
        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']	= '2048000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $data['err_msg'] = array('error' => $this->upload->display_errors());
            $profile_photo = "";
//            echo $this->upload->display_errors();
//            exit();
        } else {
            $profile_photo = $this->upload->data()['file_name'];
        }
//        print_r($profile_photo);exit();
        $data = array('COMPANY_ID' => '1',
            'PARENT_ACC_ID' => '46',
            'ACC_NAME' => $staff_name,
            'BIOMETRIC_CODE' => $staff_bio_code,
            'ACC_CODE' => $staff_code,
            'ADDRESS_ONE' => $address1,
            'ADDRESS_TWO' => $address2,
            'PHONE' => $contact,
            'ACC_EMAIL' => $email,
            'GENDER' => $genger,
            'CUST_DOB' => $cust_dob,
            'DESIGNATION' => $designation,
            'YEAR_OF_EXPRIANS' => $year,
            'MNTH_OF_EXPRIANS' => $mnth,
            'JOINING_DATE' => $joining_date,
            'STATUS' => $status,
            'SALARY' => $salary,
            'INACTIVE_DATE' => $inactive_date,
            'ACC_MODE' => 'STAFF',
            'TYPE' => 'S',
            'REMARK' => $remark,
            'USER_NAME' => $username,
            'PASSWORD' => $password,
            'STAFF_MODE' => $staff_mode,
            'MODIFIED_BY' => $modified_by,
            'MODIFIED_ON' => $modified_on,
            'LOCATION_DETAILS' => $location_details);
        if($profile_photo != "") {
            $data['PROFILE_PHOTO'] = $profile_photo;
        }
        $this->account_model->acc_update('tbl_account', $data, $id);
        $this->staff_list();
    }

    function customer_update() {
        $id = $this->input->post('txt_id');
        $cust_name = $this->input->post('txt_cust_name');
        $address1 = $this->input->post('txt_address1');
        $address2 = $this->input->post('txt_address2');
        $contact = $this->input->post('txt_contact');
        $email = $this->input->post('txt_email');
        $gst_no = $this->input->post('txt_gst_no');
//        $cust_dob = $this->input->post('txt_cust_dobdate');
//        $cust_dob = strtotime($cust_dob);
//        $cust_dob = date("Y-m-d", $cust_dob);
//        $genger = $this->input->post('rad_gender');
        $status = $this->input->post('status');
        $remark = $this->input->post('txt_remark');
        $op_balance = $this->input->post('txt_balance');
        $contact_person = $this->input->post('txt_contactperson');
        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        $data = array('COMPANY_ID' => '1',
            'PARENT_ACC_ID' => '47',
            'ACC_NAME' => $cust_name,
            'ADDRESS_ONE' => $address1,
            'ADDRESS_TWO' => $address2,
            'CONTACT_PERSON' => $contact_person,
            'PHONE' => $contact,
            'ACC_EMAIL' => $email,
            'TIN_NO' => $gst_no,
//            'GENDER' => $genger,
//            'CUST_DOB' => $cust_dob,
            'STATUS' => $status,
            'ACC_MODE' => 'CUSTOMER',
            'TYPE' => 'S',
            'REMARK' => $remark,
            'OPENING_BALANCE' => $op_balance,
            'MODIFIED_BY' => $modified_by,
            'MODIFIED_ON' => $modified_on,
            'LOCATION_DETAILS' => $location_details);
        $this->account_model->acc_update('tbl_account', $data, $id);
        $this->customer_list();
    }

    function account_delete() {
        //ob_start();
        $menu_id = 13;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $dat = array('DEL_FLAG' => '0',
            'DELETED_BY' => $deleted_by,
            'DELETED_ON' => $deleted_on,
            'LOCATION_DETAILS' => $location_details);
        $this->load->model('account_model');
        $this->account_model->delete('tbl_account', $id, $dat);
        //redirect($_SERVER['HTTP_REFERER']);
        $this->mainaccount_list();
    }

    function test() {
        ob_start();
        //redirect('/dashboard');
        //header ('Location: http://wesmosis.softloom.com/dashboard/');

        $newURL = "http://wesmosis.softloom.com/dashboard/";

        // echo $redirect_url="http://callnconnect.com/ad/".$row['SLUG']."/";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $newURL");
        exit();
        //wesmosis.softloom.com/dashboard/
        //redirect($_SERVER['HTTP_REFERER']);
    }

    function subaccount_delete() {
        $menu_id = 15;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);

        $id = $this->uri->segment(3);
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $dat = array('DEL_FLAG' => '0',
            'DELETED_BY' => $deleted_by,
            'DELETED_ON' => $deleted_on,
            'LOCATION_DETAILS' => $location_details);
        $this->load->model('account_model');
        $this->account_model->delete('tbl_account', $id, $dat);
        $this->subaccount_list();
    }
    
    function mult_search() {
        $menu_id = 20;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        //echo $calc=$this->input->post('calc');
        $designation = $this->input->post('dename');
        $search_name = $this->input->post('srname');
        $search_status = $this->input->post('statu');
        $per_page = $this->input->post('per_page');
        $cur_page = $this->input->post('cur_page');
        $type = $this->input->post('type');
        $acc_mode = $this->input->post('acc_mode');
        $data['type'] = $type;
        $generate_pdf = $this->input->post('generate_pdf');
        $total_row = $this->account_model->record_count('tbl_account', $acc_mode, $search_name, $search_status, $designation);
        if ($generate_pdf == 'generate_pdf' || $generate_pdf == 'generate_excel')
            $data['customer_list'] = $this->account_model->mult_search('tbl_account', $acc_mode, $search_name, $search_status, $designation, 0, $total_row);
        else
            $data['customer_list'] = $this->account_model->mult_search('tbl_account', $acc_mode, $search_name, $search_status, $designation, ($cur_page - 1) * $per_page, $per_page);
        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
            $html = $this->load->view('customer_list_pdf', $data, true);
            $filename = 'customer_list_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'customer_list_report_' . time() . '.xls';
            $html = $this->load->view('customer_list_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $data['acc_mode'] = $acc_mode;
            if ($type == 'rep') {
                $data['sl_no'] = 1;
                $total_pages = 1;
                $data['pagination'] = "";
            } else {
                $data['sl_no'] = ($cur_page - 1) * $per_page + 1;
                $total_pages = ceil($total_row / $per_page);
                $this->load->library('../controllers/pagination');
                $data['pagination'] = $this->pagination->create_pagination($per_page, $cur_page, $total_row, $total_pages);
            }
            $this->load->view('form_customer_search_list', $data);
        }
    }

    function get_account_list_api() {
        $result['status'] = 1;
        $result['data'] = $this->account_model->get_account()->result();
        if(count($result['data']) > 0) {
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            unset($result['data']);
            $result['status'] = 0;
            $result['msg'] = 'No Data Found';
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }

    function get_sub_account_list_api() {
        $result['status'] = 1;
        $result['data'] = $this->account_model->get_sub_acc()->result();
        if(count($result['data']) > 0) {
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            unset($result['data']);
            $result['status'] = 0;
            $result['msg'] = 'No Data Found';
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }

}

?>