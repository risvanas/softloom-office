<?php

class Login_model extends CI_model {

    function login($username, $password) {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('USER_NAME = ' . "'" . $username . "'");
        $this->db->where('PASSWORD = ' . "'" . $password . "'");
        $this->db->where('DEL_FLAG = ' . "1");
        $this->db->where('STATUS', "ACTIVE");
        $this->db->limit(1);

        $query1 = $this->db->get();

        if ($query1->num_rows() == 1) {
            return $query1->result();
        } else {
            return FALSE;
        }
    }
    
    function login_firebase($username, $password) {
        $this->db->select('*');
        $this->db->from('tbl_account');
        $this->db->where('ACC_EMAIL = ' . "'" . $username . "'");
        $this->db->where('PASSWORD = ' . "'" . $password . "'");
        $this->db->where('DEL_FLAG = ' . "1");
        $this->db->where('STATUS', "ACTIVE");
        $this->db->limit(1);

        $query1 = $this->db->get();

        if ($query1->num_rows() == 1) {
            return $query1->result();
        } else {
            return FALSE;
        }
    }

    function insert($table, $data) {
        $this->db->insert($table, $data);
    }

}

?>