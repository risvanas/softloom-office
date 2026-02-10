<?php

class Login extends MX_Controller {

    function __construct() {
        parent::__construct();


        $this->load->helper(array('template'));
        //$temp = new template();
        //$temp->set_template('admin_template');
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->helper('email');
        $this->load->model('login_model');
    }

    function index() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('company_code', 'Company Code', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['msg'] = '';
            $this->load->view('login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $company_code = $this->input->post('company_code');
            $password = str_replace('"', '', $password);
            $password = str_replace("'", '', $password);
            $result = $this->login_model->login($username, $password);
            if ($result == FALSE) {
                $data['msg'] = 'Invalid username or password';
                $this->load->view('login', $data);
            } else {
                $sql1 = "SELECT * FROM `tbl_company` WHERE `COMP_CODE`='$company_code' limit 1";
                $query2 = $this->db->query($sql1);
                if ($query2->num_rows() == 1) {
                    $val1 = $query2->row_array();
                    $sess_array = array();
                    foreach ($result as $row) {
                        $sql = "select * from tbl_accounting_year where DEL_FLAG=1 and STATUS='active' limit 1";
                        $query1 = $this->db->query($sql);
                        $val = $query1->row_array();
                        $id = $val['AY_ID'];
                        $acc_code = $val['YEAR_CODE'];
                        $sess_array = array('user_id' => $row->ACC_ID, 'user_name' => $row->ACC_NAME, 'accounting_year' => $id, 'year_code' => $acc_code, 'user_type' => $row->USER_TYPE, 'profile_pic' => $row->PROFILE_PHOTO, 'comp_code' => $val1['ID']);
                        $this->session->set_userdata('logged_in', $sess_array);
                    }
                    $sess_arr = $this->session->userdata('logged_in');
                    $user = $sess_arr['user_id'];
                    $time = gmdate("Y-m-d H:i:s");
                    $this->load->library('../controllers/lockdate');
                    $location_details = $this->lockdate->location_details();
                    $data = array('USER' => $user,
                        'DATE_TIME' => $time,
                        'DEVICE' => $location_details,
                        'DEL_FLAG' => 1);
                    $this->login_model->insert('tbl_logindetails', $data);
                    redirect('dashboard');//, 'refresh');
                } else {
                    $data['msg'] = 'Invalid company code';
                    $this->load->view('login', $data);
                }
            }
        }
    }

    function log_out() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    function api_login() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('company_code', 'Company Code', 'trim|required');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $company_code = $this->input->post('company_code');
            $device_type = $this->input->post('device_type');
            $device_id = $this->input->post('device_id');
            $password = str_replace('"', '', $password);
            $password = str_replace("'", '', $password);
            $result = $this->login_model->login($username, $password);
            if ($result == FALSE) {
                //     $data['msg'] = 'Invalid username or password';
                //     $this->load->view('login', $data);
                $data['status'] = 0;
                $data['msg'] = 'Invalid username or password';
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $sql1 = "SELECT * FROM `tbl_company` WHERE `COMP_CODE`='$company_code' limit 1";
                $query2 = $this->db->query($sql1);
                if ($query2->num_rows() == 1) {
                    $val1 = $query2->row_array();
                    $sess_array = array();
                    foreach ($result as $row) {
                        $sql = "select * from tbl_accounting_year where DEL_FLAG=1 and STATUS='active' limit 1";
                        $query1 = $this->db->query($sql);
                        $val = $query1->row_array();
                        $id = $val['AY_ID'];
                        $acc_code = $val['YEAR_CODE'];
                        $sess_array = array('status' => 1,'user_id' => $row->ACC_ID, 'user_name' => $row->ACC_NAME, 'accounting_year' => $id, 'year_code' => $acc_code, 'user_type' => $row->USER_TYPE, 'profile_pic' => $row->PROFILE_PHOTO, 'comp_code' => $val1['ID']);
                        // $this->session->set_userdata('logged_in', $sess_array);
                    }
                    // $sess_arr = $this->session->userdata('logged_in');
                    $user = $sess_array['user_id'];
                    $time = gmdate("Y-m-d H:i:s");
                    // $this->load->library('../controllers/lockdate');
                    // $location_details = $this->lockdate->location_details();
                    $location_details = $device_type . " " . $device_id;
                    $data = array('USER' => $user,
                        'DATE_TIME' => $time,
                        'DEVICE' => $location_details,
                        'DEL_FLAG' => 1);
                    $this->login_model->insert('tbl_logindetails', $data);
                    // redirect('dashboard', 'refresh');
                    header('Content-Type: application/json');
                    echo json_encode($sess_array);
                } else {
                    $data['status'] = 0;
                    $data['msg'] = 'Invalid company code';
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
            }
        }
    }
    
    function api_login_firebase() {
        $this->form_validation->set_rules('username', 'Username', 'trim|valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $device_type = $this->input->post('device_type');
            $device_id = $this->input->post('device_id');
            $result = $this->login_model->login_firebase($username, $password);
            if ($result == FALSE) {
                //     $data['msg'] = 'Invalid username or password';
                //     $this->load->view('login', $data);
                $data['status'] = 0;
                $data['msg'] = 'No Data Found';
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $sess_array = array();
                foreach ($result as $row) {
                    $sql = "select * from tbl_accounting_year where DEL_FLAG=1 and STATUS='active' limit 1";
                    $query1 = $this->db->query($sql);
                    $val = $query1->row_array();
                    $id = $val['AY_ID'];
                    $acc_code = $val['YEAR_CODE'];
                    $sess_array = array('status' => 1, 'user_id' => $row->ACC_ID, 'user_name' => $row->ACC_NAME, 'accounting_year' => $id, 'year_code' => $acc_code, 'user_type' => $row->USER_TYPE, 'profile_pic' => $row->PROFILE_PHOTO);
                    //$this->session->set_userdata('logged_in', $sess_array);
                }
                //$sess_arr = $this->session->userdata('logged_in');
                $user = $sess_array['user_id'];
                $time = gmdate("Y-m-d H:i:s");
                // $this->load->library('../controllers/lockdate');
                // $location_details = $this->lockdate->location_details();
                $data = array('USER' => $user,
                    'DATE_TIME' => $time,
                    'DEVICE' => $device_type . "," . $device_id,
                    'DEL_FLAG' => 1);
                $this->login_model->insert('tbl_logindetails', $data);

                //	$sql1 = "select 1 as status,* from tbl_account where DEL_FLAG=1 and USER_NAME='$username' and PASSWORD='$password' LIMIT 1";
                // $query2 = $this->db->query($sql1);
                //$result = $query2->row_array();
                header('Content-Type: application/json');
                echo json_encode($sess_array);
                // redirect('dashboard', 'refresh');
            }
        }
    }
    
    

}

?>