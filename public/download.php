<?php

require __DIR__ . '/../includes.php';

if (!isset($_GET['file']) || !is_string($_GET['file'])
    || !preg_match('#^[A-Za-z0-9_\-.+]+\.xpi\z#', $_GET['file']))
    exit;

// Resolve symlinks and ensure the file really lives in the artifacts dir
$file = realpath($extensionDistDir . '/' . $_GET['file']);
if ($file === false
    || strpos($file, $extensionDistDir . DIRECTORY_SEPARATOR) !== 0
    || !is_file($file))
    exit;

header('Content-Description: File Transfer');
header('Content-Type: application/x-xpinstall');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($file));
readfile($file);
