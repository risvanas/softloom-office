<?php

class Permition_checker extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('user_agent');
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['user_id'] == '') {
            redirect(base_url());
        }
    }

    function permition_viewprocess($menu_id) {
        $sess_array = $this->session->userdata('logged_in');
        $user_id = $sess_array['user_id'];
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->VIEW != 1) {
                    redirect('permition_checker/permition_display');
                }
            }
        } else {
            $this->load->helper('url');
            redirect('permition_checker/permition_display');
        }
    }

    function permition_addprocess($menu_id) {
        $sess_array = $this->session->userdata('logged_in');
        $user_id = $sess_array['user_id'];
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->ADD != 1) {
                    redirect('permition_checker/permition_display');
                }
            }
        } else {
            redirect('permition_checker/permition_display');
        }
    }

    function permition_editprocess($menu_id) {
        $sess_array = $this->session->userdata('logged_in');
        $user_id = $sess_array['user_id'];
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->EDIT != 1) {
                    redirect('permition_checker/permition_display');
                }
            }
        } else {
            redirect('permition_checker/permition_display');
        }
    }

    function permition_deleteprocess($menu_id) {
        $sess_array = $this->session->userdata('logged_in');
        $user_id = $sess_array['user_id'];
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->DELETE != 1) {
                    redirect('permition_checker/permition_display');
                }
            }
        } else {
            redirect('permition_checker/permition_display');
        }
    }

    function permition_display() {
        $layout = array('page' => 'form_permition_denied', 'title' => 'Permition denied');
        render_template($layout);
    }

}

?>