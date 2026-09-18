<?php
/**
 * Export smoke tests — run: php test_exports.php
 */
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '1');

$_SERVER['REQUEST_URI'] = '/login';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['HTTP_HOST'] = 'softloom.test';
$_SERVER['REQUEST_METHOD'] = 'GET';

ob_start();
include __DIR__ . '/index.php';
ob_end_clean();

$CI =& get_instance();
$CI->load->library('pdfgenerator');

$pass = 0;
$fail = 0;

function render_view_file($path, $vars = array())
{
    extract($vars, EXTR_SKIP);
    ob_start();
    include $path;
    return ob_get_clean();
}

function test_pdf_html($name, $html)
{
    global $CI, $pass, $fail;
    try {
        $pdf = $CI->pdfgenerator->generate($html, 'test_' . $name, false);
        if (strncmp($pdf, '%PDF', 4) === 0) {
            echo "[PASS] pdf:$name (" . strlen($pdf) . " bytes)\n";
            $pass++;
        } else {
            echo "[FAIL] pdf:$name invalid header\n";
            $fail++;
        }
    } catch (Throwable $e) {
        echo "[FAIL] pdf:$name - " . $e->getMessage() . "\n";
        $fail++;
    }
}

function test_render($name, $path, $vars = array())
{
    global $pass, $fail;
    try {
        if (!file_exists($path)) {
            echo "[FAIL] render:$name missing file\n";
            $fail++;
            return '';
        }
        $html = render_view_file($path, $vars);
        if (strlen($html) > 20 && stripos($html, 'Fatal error') === false && stripos($html, 'Uncaught Error') === false) {
            echo "[PASS] render:$name (" . strlen($html) . " bytes)\n";
            $pass++;
            return $html;
        }
        echo "[FAIL] render:$name empty or error\n";
        $fail++;
        return '';
    } catch (Throwable $e) {
        echo "[FAIL] render:$name - " . $e->getMessage() . "\n";
        $fail++;
        return '';
    }
}

$company = $CI->db->query("SELECT * FROM tbl_company LIMIT 1")->row_array();
$data_pass = $CI->db->query("SELECT ACC_ID, ACC_NAME, OPENING_BALANCE FROM tbl_account WHERE DEL_FLAG=1 LIMIT 5");
$base = APPPATH . 'modules/';

$exports = array(
    array('trialbalance_pdf', 'trialbalance/views/trialbalance_pdf.php', array('company' => $company, 'data_pass' => $data_pass)),
    array('trialbalance_excel', 'trialbalance/views/trialbalance_excel.php', array('company' => $company, 'data_pass' => $data_pass)),
    array('daybook_pdf', 'day_book/views/daybook_pdf.php', array('company' => $company)),
    array('daybook_excel', 'day_book/views/daybook_excel.php', array('company' => $company)),
    array('income_excel', 'income_and_expenditure/views/income_and_expenditure_excel.php', array('company' => $company)),
    array('income_pdf', 'income_and_expenditure/views/income_and_expenditure_pdf.php', array('company' => $company)),
    array('studentlist_excel', 'student/views/studentlist_excel.php', array('company' => $company, 'type' => 'list', 's' => $CI->db->query("SELECT * FROM tbl_student WHERE DEL_FLAG=1 LIMIT 3"))),
    array('studentlist_pdf', 'student/views/studentlist_pdf.php', array('company' => $company, 'type' => 'list', 's' => $CI->db->query("SELECT * FROM tbl_student WHERE DEL_FLAG=1 LIMIT 3"))),
    array('gst_invoice_excel', 'invoice/views/gst_invoice_excel.php', array('company' => $company, 'serch' => $CI->db->query("SELECT * FROM tbl_invoice LIMIT 1"))),
    array('gst_invoice_pdf', 'invoice/views/gst_invoice_pdf.php', array('company' => $company, 'serch' => $CI->db->query("SELECT * FROM tbl_invoice LIMIT 1"))),
    array('payment_report_excel', 'invoice/views/payment_report_excel.php', array('company' => $company)),
    array('payment_report_pdf', 'invoice/views/payment_report_pdf.php', array('company' => $company)),
    array('ledger_excel', 'ledger/views/ledger_excel.php', array('company' => $company)),
);

foreach ($exports as $item) {
    list($name, $rel, $vars) = $item;
    $html = test_render($name, $base . $rel, $vars);
    if ($html && strpos($name, '_pdf') !== false) {
        test_pdf_html($name, $html);
    }
}

echo "---\nPassed: $pass  Failed: $fail\n";
exit($fail > 0 ? 1 : 0);
