<?php

class Balancesheet_model extends CI_Model {

    function select_company() {
        $this->db->select('*');
        $this->db->from('tbl_company');
        $res = $this->db->get();
        return $res;
    }

}

?>