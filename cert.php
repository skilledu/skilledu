<?php
$log = $_SERVER['HTTP_REFERER'] ?? 'Unknown';
file_put_contents("cert_log.txt", date('Y-m-d H:i:s') . " - From: " . $log . "\n", FILE_APPEND);
?>
