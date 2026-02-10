<?php

class Menu_management extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('menu_management_model');
        $this->load->library('encryption');
    }

    function index() {
        $menu_id = 52;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txt_sub_menu', 'required', 'required');
        $data['pmenu'] = $this->menu_management_model->select_pmenu('tbl_menu');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_addmenu', 'title' => 'Add menu', 'data' => $data);
            render_template($layout);
            //$this->load->view('form_invoice',$data);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $p_menu = $this->input->post('drp_prt_menu');
            $s_menu = $this->input->post('txt_sub_menu');
            $url = $this->input->post('txt_url');
            $icon = $this->input->post('txt_icon');
            $source = $this->input->post('txt_source');
            $order = $this->input->post('txt_order');
            $order = $this->input->post('txt_order');
            $mobile_menu = $this->input->post('drp_mobile_view');
            $data = array('P_MENU_ID' => $p_menu,
                'SUB_MENU' => $s_menu,
                'URL' => $url,
                'ICON' => $icon,
                'SOURCE' => $source,
                'DEL_FLAG' => 1,
                'MENU_SHOW_ON_MOBILE' => $mobile_menu,
                'MENU_ORDER' => $order);
            $this->menu_management_model->insert_data('tbl_menu', $data);
            $data['pmenu'] = $this->menu_management_model->select_pmenu('tbl_menu');
            $data['msg'] = "New Menu Added Successfully";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_addmenu', 'title' => 'Add menu', 'data' => $data);
            render_template($layout);
        }
    }

    function menulist() {
        $menu_id = 53;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['list'] = $this->menu_management_model->select_all();
        $data['msg'] = "";
        $data['errmsg'] = "";
        $layout = array('page' => 'form_menulist', 'title' => 'Add menu', 'data' => $data);
        render_template($layout);
    }

    function menuedit() {
        $menu_id = 52;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $data['pmenu'] = $this->menu_management_model->select_pmenu('tbl_menu');
        $data['menu'] = $this->menu_management_model->select_individual('tbl_menu', $id);
        $data['msg'] = "";
        $data['errmsg'] = "";
        $layout = array('page' => 'form_menuedit', 'title' => 'Add menu', 'data' => $data);
        render_template($layout);
    }

    function menu_update() {
        $this->form_validation->set_rules('txt_sub_menu', 'required', 'required');
        if ($this->form_validation->run() != TRUE) {
            $data['msg'] = "";
            $data['errmsg'] = "Please Enter Data";
            $layout = array('page' => 'form_addmenu', 'title' => 'Add menu', 'data' => $data);
            render_template($layout);
            //$this->load->view('form_invoice',$data);
        } else {
            $p_menu = $this->input->post('drp_prt_menu');
            $s_menu = $this->input->post('txt_sub_menu');
            $url = $this->input->post('txt_url');
            $icon = $this->input->post('txt_icon');
            $source = $this->input->post('txt_source');
            $order = $this->input->post('txt_order');
            $mobile_menu = $this->input->post('drp_mobile_view');
            $data = array('P_MENU_ID' => $p_menu,
                'SUB_MENU' => $s_menu,
                'URL' => $url,
                'ICON' => $icon,
                'SOURCE' => $source,
                'MENU_SHOW_ON_MOBILE' => $mobile_menu,
                'MENU_ORDER' => $order);
            $id = $this->input->post('m_id');
            $this->menu_management_model->update('tbl_menu', $id, $data);
            $data['list'] = $this->menu_management_model->select_all();
            redirect('menu_management/menulist');
        }
    }

    function menu_delete() {
        $menu_id = 52;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
        $data = array('DEL_FLAG' => 0);
        $this->menu_management_model->update('tbl_menu', $id, $data);
        redirect('menu_management/menulist');
    }
    
    function menu_list_api() {
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        if ($this->form_validation->run() != TRUE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else {
            $user_id = $this->input->post('user_id');
            $result['status'] = 1;
            $result['data'] = $this->menu_management_model->select_primary_menu('tbl_menu','', $user_id)->result();
            foreach($result['data'] as $key=>$value) {
                $value->sub_menu_cnt = intval($this->menu_management_model->sub_menu_count($value->menu_id)->row()->cnt);
            }
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
    
    function sub_menu_list_api() {
        $this->form_validation->set_rules('menu_id', 'Menu Id', 'trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $result['status'] = 1;
            $menu = $this->menu_management_model->select_primary_menu('tbl_menu',$menu_id, $user_id)->result();
            foreach ($menu as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    $result[$key1] = $value1;
                }
            }
            $result['data'] = $this->menu_management_model->select_sub_menu('tbl_menu',$menu_id, $user_id)->result();       
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

}

?>