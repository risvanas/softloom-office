<?php

class User_managing extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->load->helper('date');
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('user_managing_model');
    }

    function index() {
        $this->form_validation->set_rules('txt_username', 'required', 'required');
        if ($this->form_validation->run() != TRUE) {
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_adduser', 'title' => 'Menu Permition', 'data' => $data);
            render_template($layout);
        } else {
            $username = $this->input->post('txt_username');
            $firstname = $this->input->post('first_name');
            $lastname = $this->input->post('last_name');
            $password = $this->input->post('txt_password');
            $data = array('USER_NAME' => $username,
                'FIRST_NAME' => $firstname,
                'LAST_NAME' => $lastname,
                'PASSWORD' => $password,
                'DEL_FLAG' => 1);
            $this->user_managing_model->insert('tbl_user', $data);
            $data['msg'] = "New User Added Successfully";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_adduser', 'title' => 'User list', 'data' => $data);
            render_template($layout);
        }
    }

    function userlist() {
        $data['list'] = $this->user_managing_model->select_all('tbl_user');
        $layout = array('page' => 'form_userlist', 'title' => 'User List', 'data' => $data);
        render_template($layout);
    }

    function useredit() {
        $id = $this->uri->segment(3);
        $data['msg'] = "";
        $data['errmsg'] = "";
        $data['edit'] = $this->user_managing_model->select_one('tbl_user', $id);
        $layout = array('page' => 'form_useredit', 'title' => 'User List', 'data' => $data);
        render_template($layout);
    }

    function update() {
        $id = $this->input->post('txt_id');
        $this->form_validation->set_rules('txt_username', 'required', 'required');
        if ($this->form_validation->run() != TRUE) {
            $data['msg'] = "";
            $data['errmsg'] = "Some Error in Entered Data";
            $layout = array('page' => 'form_adduser', 'title' => 'Menu Permition', 'data' => $data);
            render_template($layout);
        } else {
            $username = $this->input->post('txt_username');
            $firstname = $this->input->post('first_name');
            $lastname = $this->input->post('last_name');
            $password = $this->input->post('txt_password');
            $data = array('USER_NAME' => $username,
                'FIRST_NAME' => $firstname,
                'LAST_NAME' => $lastname,
                'PASSWORD' => $password,
                'DEL_FLAG' => 1);
            $this->user_managing_model->update('tbl_user', $data, $id);
            redirect('user_managing/userlist');
        }
    }

    function user_delete() {
        $id = $this->uri->segment(3);
        $data = array('DEL_FLAG' => 0);
        $this->user_managing_model->update('tbl_user', $data, $id);
        redirect('user_managing/userlist');
    }
    
    
    function api() {
        $this->load->library('curl');
        $result = $this->curl->simple_get('http://craft.softloom.com/api_category');
        echo "<pre>";
        var_dump($result);
        $result = json_decode($result);
        print_r($result);
        foreach ($result->data as $key => $value) {
            print_r($value);
            $data = array(
                'NAME' => $value->name,
                'SHORT_NAME' => $value->short_name,
                'TYPE' => $value->type
            );
            $this->user_managing_model->insert('tabl_test', $data);
        }
    }

}

?>