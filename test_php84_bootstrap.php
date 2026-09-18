<?php
/**
 * CLI smoke tests for PHP 8.4 compatibility (run: php test_php84_bootstrap.php)
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

$results = array();

function record($name, $ok, $detail = '')
{
    global $results;
    $results[] = array('name' => $name, 'ok' => $ok, 'detail' => $detail);
    echo ($ok ? '[PASS] ' : '[FAIL] ') . $name . ($detail ? ' - ' . $detail : '') . PHP_EOL;
}

// PDF library test
try {
    require __DIR__ . '/vendor/autoload.php';
    $dompdf = new Dompdf\Dompdf(new Dompdf\Options());
    $dompdf->loadHtml('<html><body><h1>Softloom PDF Test</h1></body></html>');
    $dompdf->render();
    $pdf = $dompdf->output();
    record('dompdf_generate', strncmp($pdf, '%PDF', 4) === 0, strlen($pdf) . ' bytes');
} catch (Throwable $e) {
    record('dompdf_generate', false, $e->getMessage());
}

// CI bootstrap login page
try {
    $_SERVER['REQUEST_URI'] = '/login';
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['HTTP_HOST'] = 'softloom.test';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    ob_start();
    include __DIR__ . '/index.php';
    $html = ob_get_clean();
    $ok = strlen($html) > 1000 && stripos($html, 'Fatal error') === false && stripos($html, 'Uncaught Error') === false;
    record('ci_login_page', $ok, 'len=' . strlen($html));
} catch (Throwable $e) {
    record('ci_login_page', false, $e->getMessage());
}

// Pdfgenerator via CI
try {
    $_SERVER['REQUEST_URI'] = '/login';
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['HTTP_HOST'] = 'softloom.test';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    ob_start();
    include __DIR__ . '/index.php';
    ob_end_clean();

    $CI =& get_instance();
    $CI->load->library('pdfgenerator');
    $pdf = $CI->pdfgenerator->generate('<h1>CI Pdfgenerator</h1>', 'test', false);
    record('ci_pdfgenerator', strncmp($pdf, '%PDF', 4) === 0, strlen($pdf) . ' bytes');
} catch (Throwable $e) {
    record('ci_pdfgenerator', false, $e->getMessage());
}

// DB connectivity
try {
    $mysqli = new mysqli('localhost', 'root', 'password', 'softloom_new');
    record('db_connect', !$mysqli->connect_error, $mysqli->connect_error ?: 'softloom_new');
    $mysqli->close();
} catch (Throwable $e) {
    record('db_connect', false, $e->getMessage());
}

$failed = array_filter($results, function ($r) { return !$r['ok']; });
exit(count($failed) > 0 ? 1 : 0);
