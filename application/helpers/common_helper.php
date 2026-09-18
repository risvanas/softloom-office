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

if (!function_exists('format_book_number')) {
    function format_book_number($number, $length = 3)
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        return number_format(round((float) $amount, 2), 2, '.', ',');
    }
}

if (!function_exists('is_latest_payment_book_number')) {
    function is_latest_payment_book_number($payment_id)
    {
        $CI =& get_instance();
        $sess = $CI->session->userdata('logged_in');
        $year_code = $sess['accounting_year'];
        $company_code = $sess['comp_code'];

        $row = $CI->db->select('BOOK_NUMBER, INVOICE_TYPE')
            ->from('tbl_transaction')
            ->where([
                'PAYMENT_ID' => $payment_id,
                'BOOK_NAME'    => 'PAY',
                'DEL_FLAG'     => 1,
                'COMPANY'      => $company_code,
            ])
            ->get()
            ->row_array();

        if (!$row) {
            return false;
        }

        $max = $CI->db->select_max('BOOK_NUMBER')
            ->where([
                'ACC_YEAR_CODE' => $year_code,
                'DEL_FLAG'      => 1,
                'INVOICE_TYPE'  => $row['INVOICE_TYPE'],
                'COMPANY'       => $company_code,
                'BOOK_NAME'     => 'PAY',
            ])
            ->get('tbl_transaction')
            ->row('BOOK_NUMBER');

        return $max !== null && (int) $row['BOOK_NUMBER'] === (int) $max;
    }
}
