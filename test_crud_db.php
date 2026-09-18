<?php
/**
 * Basic DB CRUD smoke test — run: php test_crud_db.php
 */
$mysqli = new mysqli('localhost', 'root', 'password', 'softloom_new');
if ($mysqli->connect_error) {
    echo "[FAIL] db_connect - " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}

$table = 'tbl_status';
$testName = 'php84_test_' . time();

$mysqli->query("INSERT INTO $table (status) VALUES ('$testName')");
$read = $mysqli->query("SELECT status FROM $table WHERE status='$testName' LIMIT 1");
$row = $read ? $read->fetch_assoc() : null;
$mysqli->query("UPDATE $table SET status='{$testName}_updated' WHERE status='$testName'");
$read2 = $mysqli->query("SELECT status FROM $table WHERE status='{$testName}_updated' LIMIT 1");
$row2 = $read2 ? $read2->fetch_assoc() : null;
$mysqli->query("DELETE FROM $table WHERE status='{$testName}_updated'");

$ok = $row && $row['status'] === $testName && $row2 && $row2['status'] === $testName . '_updated';
echo ($ok ? '[PASS]' : '[FAIL]') . ' db_crud_cycle' . PHP_EOL;
$mysqli->close();
exit($ok ? 0 : 1);
