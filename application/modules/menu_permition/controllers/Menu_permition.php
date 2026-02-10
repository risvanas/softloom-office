<?php

class Menu_permition extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('Menu_permition_model');
        $this->load->library('encryption');
    }

    function index() {
        $this->form_validation->set_rules('drp_user', 'required', 'required');
        if ($this->form_validation->run() != TRUE) {
            $data['user'] = $this->Menu_permition_model->select_user();
            $data['menu'] = $this->Menu_permition_model->select_all('tbl_menu');
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_menu_permition', 'title' => 'Menu Permition', 'data' => $data);
            render_template($layout);
        } else {

            $repeat = $this->input->post('count');
            $user = $this->input->post('drp_user');
            $sql = "update tbl_permition set DEL_FLAG=0 where USER_ID=$user";
            $this->db->query($sql);
            for ($count = 1; $count <= $repeat; $count++) {
                $menu = $this->input->post('txt_menu[' . $count . ']');
                $add = $this->input->post('add[' . $count . ']');
                $edit = $this->input->post('edit[' . $count . ']');
                $delete = $this->input->post('delete[' . $count . ']');
                $view = $this->input->post('view[' . $count . ']');
                $sql1 = "update tbl_permition set DEL";
                if ($add != '' || $edit != '' || $delete != '' || $view != '') {
                    $data = array('USER_ID' => $user,
                        'MENU_ID' => $menu,
                        'ADD' => $add,
                        'EDIT' => $edit,
                        'DELETE' => $delete,
                        'VIEW' => $view,
                        'DEL_FLAG' => 1);
                    $this->Menu_permition_model->insert('tbl_permition', $data);
                }
            }
            $data['user'] = $this->Menu_permition_model->select_user();
            $data['menu'] = $this->Menu_permition_model->select_all('tbl_menu');
            $data['msg'] = "Permission Added Successfully";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_menu_permition', 'title' => 'Menu Permission', 'data' => $data);
            render_template($layout);
        }
    }

    function select_permition() {
        $data['menu'] = $this->Menu_permition_model->select_all('tbl_menu');
        $data['user'] = $this->input->post('user');
        $this->load->view('form_search', $data);
    }

    function permission_view_checking_api() {
        $this->form_validation->set_rules('menu_id', 'Menu Id', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $this->load->library('../controllers/permition_checker_api');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied') {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
            } else {
                $data['status'] = 1;
                $data['msg'] = "Access granted";
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

}

?>