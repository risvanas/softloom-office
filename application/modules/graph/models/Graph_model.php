<?php

class Graph_model extends CI_Model {

    function get_sales_summary($date1, $date2) {
        $sql = "CALL get_sales_summary(?, ?)";
        $query = $this->db->query($sql, array('date1' => $date1, 'date2' => $date2));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function get_sales_return($date1, $date2) {
        $sql = "CALL get_sales_return(?, ?)";
        $query = $this->db->query($sql, array('date1' => $date1, 'date2' => $date2));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function get_dev_return($date1, $date2) {
        $sql = "CALL get_dev_return(?, ?)";
        $query = $this->db->query($sql, array('date1' => $date1, 'date2' => $date2));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

}

?>