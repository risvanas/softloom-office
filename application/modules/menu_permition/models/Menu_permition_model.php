<?php

class Menu_permition_model extends CI_Model {

    function select_all($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('DEL_FLAG', 1);
        if ($table == 'tbl_menu') {
            $this->db->where('P_MENU_ID', '');
        }
        $query = $this->db->get();
        return $query;
    }

    function insert($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_user() {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('DEL_FLAG', 1);
        $this->db->where('ACC_MODE', "STAFF");
        $this->db->where('STATUS', "ACTIVE");
        $query = $this->db->get();
        return $query;
    }

}

?>