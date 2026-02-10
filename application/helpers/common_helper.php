<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('encrypt')) {
    function encrypt($data_id)
    {
        $CI =& get_instance();
        $CI->load->library('encryption');

        // Encrypt the data
        $encrypted_data = $CI->encryption->encrypt($data_id);

        // Replace special characters for URL safety
        $encrypted_data = str_replace("/", "~", $encrypted_data);
        $encrypted_data = str_replace("=", "-", $encrypted_data);
        $encrypted_data = str_replace("+", ".", $encrypted_data);

        return $encrypted_data;
    }
}

if (!function_exists('decrypt')) {
    function decrypt($encrypted_data)
    {
        $CI =& get_instance();
        $CI->load->library('encryption');

        // Restore original characters
        $encrypted_data = str_replace("~", "/", $encrypted_data);
        $encrypted_data = str_replace("-", "=", $encrypted_data);
        $encrypted_data = str_replace(".", "+", $encrypted_data);

        // Decrypt the data
        return $CI->encryption->decrypt($encrypted_data);
    }
}
