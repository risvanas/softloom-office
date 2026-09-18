<?php

class Menu_management_model extends CI_Model {

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function select_all() {
        $this->db->select('tbl_menu.P_MENU_ID as P_MENU_ID,tbl_menu.SUB_MENU as SUB_MENU,tbl_menu.URL as URL,tbl_menu.ICON as ICON,tbl_menu.SOURCE as SOURCE,tbl_menu.ICON as ICON,tbl_menu.MENU_ID as MENU_ID,menu.SUB_MENU as pmenu,tbl_menu.MENU_ORDER as order');
        $this->db->from('tbl_menu');
        $this->db->join('tbl_menu as menu', 'tbl_menu.P_MENU_ID = menu.MENU_ID', 'left');
        $this->db->where('tbl_menu.DEL_FLAG', 1);
        $query = $this->db->get();
        return $query;
    }

    function select_individual($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('MENU_ID', $id);
        $this->db->where('DEL_FLAG', 1);
        $query = $this->db->get();
        return $query;
    }

    function update($table, $id, $data) {
        $this->db->where('MENU_ID', $id);
        $this->db->where('DEL_FLAG', 1);
        $this->db->update($table, $data);
    }

    function select_pmenu($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('P_MENU_ID', '');
        $this->db->where('DEL_FLAG', 1);
        $query = $this->db->get();
        return $query;
    }
    
    function select_primary_menu($table, $menu_id= '', $userid) {
        $base_url = site_url();
        // $this->db->select("menu_id, sub_menu, IF(menu_reference IS NULL or menu_reference = '', '', menu_reference) AS menu_reference, source, menu_order, menu_show_on_mobile, IF(menu_icon_image IS NULL or menu_icon_image = '', '', menu_icon_image) AS menu_icon_image, IF(URL IS NULL or URL = '', '', CONCAT('$base_url' , '/',URL)) AS menu_url, IF(menu_type IS NULL or menu_type = '', '', menu_type) AS menu_type", false);
        // $this->db->from($table);
        // $this->db->where('P_MENU_ID', '');
        // $this->db->where('SOURCE', 'active');
        // $this->db->where('MENU_SHOW_ON_MOBILE', 1);
        // $this->db->where('DEL_FLAG', 1);
        // if($menu_id != '') {
        //     $this->db->where('MENU_ID', $menu_id);
        // }
        // $query = $this->db->get();
        // return $query;
        $sql = "CALL get_primary_menu_list(?,?,?)";
        $query = $this->db->query($sql, array('userid' => $userid, 'menuid'=>$menu_id, 'base_url'=>$base_url));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }
    function select_sub_menu($table, $menu_id, $userid) {
        $base_url = site_url();
        // $this->db->select("menu_id, sub_menu, IF(menu_reference IS NULL or menu_reference = '', '', menu_reference) AS menu_reference, source, menu_order, menu_show_on_mobile, IF(menu_icon_image IS NULL or menu_icon_image = '', '', menu_icon_image) AS menu_icon_image, IF(URL IS NULL or URL = '', '', CONCAT('$base_url' , '/',URL)) AS menu_url, IF(menu_type IS NULL or menu_type = '', '', menu_type) AS menu_type", false);
        // $this->db->from($table);
        // $this->db->where('P_MENU_ID', $menu_id);
        // $this->db->where('SOURCE', 'active');
        // $this->db->where('MENU_SHOW_ON_MOBILE', 1);
        // $this->db->where('DEL_FLAG', 1);
        // $query = $this->db->get();
        // return $query;
        $sql = "CALL get_secondary_menu_list(?,?,?)";
        $query = $this->db->query($sql, array('userid' => $userid, 'menuid'=>$menu_id, 'base_url'=>$base_url));
        $res = $query->result();
        $query->next_result();
        $query->free_result();
        return $query;
    }

    function sub_menu_count($menu_id) {
        $this->db->select("CAST(count(menu_id)  as UNSIGNED) as cnt");
        $this->db->from('tbl_menu');
        $this->db->where('P_MENU_ID', $menu_id);
        $this->db->where('SOURCE', 'active');
        $this->db->where('MENU_SHOW_ON_MOBILE', 1);
        $this->db->where('DEL_FLAG', 1);
        $query = $this->db->get();
        return $query;
    }
    

}

?>