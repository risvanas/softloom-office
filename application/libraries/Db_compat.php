<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applies MySQL session settings for legacy queries on MySQL 8+.
 */
class Db_compat {

    public function __construct()
    {
        $CI =& get_instance();

        if (isset($CI->db) && method_exists($CI->db, 'query')) {
            $CI->db->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        }
    }
}
