<?php

require __DIR__ . '../includes.php';

if (empty($_GET['file'])
    || !preg_match('/^[A-Za-z0-9_-.+]+\.xpi$/', $_GET['file'])
    || !is_file($file = $extensionDistDir . '/' . $_GET['file']))
    exit;

header('Content-Description: File Transfer');
header('Content-Type: application/x-xpinstall');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);