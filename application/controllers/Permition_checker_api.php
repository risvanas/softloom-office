<?php

class Permition_checker_api extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('user_agent');
    }

    function permition_viewprocess($menu_id, $user_id) {
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->VIEW != 1) {
                    return "access_denied";
                }
            }
        } else {
            $this->load->helper('url');
            return "access_denied";
        }
    }

    function permition_addprocess($menu_id, $user_id) {
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->ADD != 1) {
                    return "access_denied";
                }
            }
        } else {
            return "access_denied";
        }
    }

    function permition_editprocess($menu_id, $user_id) {
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->EDIT != 1) {
                    return "access_denied";
                }
            }
        } else {
            return "access_denied";
        }
    }

    function permition_deleteprocess($menu_id, $user_id) {
        $sql = "select * from tbl_permition where USER_ID=$user_id and MENU_ID=$menu_id and DEL_FLAG=1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num >= 1) {
            foreach ($query->result() as $row) {
                if ($row->DELETE != 1) {
                    return "access_denied";
                }
            }
        } else {
            return "access_denied";
        }
    }

    // function permition_display() {
    //     $layout = array('page' => 'form_permition_denied', 'title' => 'Permition denied');
    //     render_template($layout);
    // }

}

?>