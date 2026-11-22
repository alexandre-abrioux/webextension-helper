<?php

require __DIR__ . '/../includes.php';

// Use the configured public hostname, not the client-controlled Host header
$hostname = getenv('HOSTNAME');
if ($hostname === false || !preg_match('#^[A-Za-z0-9.\-]+(:[0-9]+)?\z#', $hostname))
    exit;

$json = new stdClass();
$json->addons = new stdClass();
$extensionManifestFile = $extensionSrcDir . '/manifest.json';
$extensionIdFile = $extensionSrcDir . '/.web-extension-id';
$extensionId = null;
$extensionVersion = null;
if (is_file($extensionIdFile))
    $extensionId = file_get_contents($extensionIdFile);
if (is_file($extensionManifestFile)) {
    $extensionManifest = file_get_contents($extensionManifestFile);
    if ($extensionManifest = json_decode($extensionManifest, true)) {
        if (!empty($extensionManifest['version']))
            $extensionVersion = $extensionManifest['version'];
        if (!empty($extensionManifest['applications']['gecko']['id']))
            $extensionId = $extensionManifest['applications']['gecko']['id'];
    }
}
if (!empty($extensionId)) {
    $json->addons->{$extensionId} = new stdClass();
    $json->addons->{$extensionId}->updates = [];
    if (is_string($extensionVersion) && preg_match('#^[0-9A-Za-z.+\-]+\z#', $extensionVersion)) {
        $extensionFile = glob($extensionDistDir . '/*-' . $extensionVersion . '.xpi');
        if (!empty($extensionFile)) {
            $extensionFile = $extensionFile[0];
            $extensionFileName = basename($extensionFile);
            $version = new stdClass();
            $version->version = $extensionVersion;
            $version->update_hash = 'sha256:' . hash_file('sha256', $extensionFile);
            $version->update_link = 'https://' . $hostname . rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/download.php?file=' . urlencode($extensionFileName);
            $json->addons->{$extensionId}->updates[] = $version;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($json);
