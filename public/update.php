<?php

require __DIR__ . '/../includes.php';

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
    if (!empty($extensionVersion)) {
        $extensionFile = glob($extensionDistDir . '/*-' . $extensionVersion . '-*.xpi');
        if (!empty($extensionFile)) {
            $extensionFile = $extensionFile[0];
            $extensionFileName = basename($extensionFile);
            $version = new stdClass();
            $version->version = $extensionVersion;
            $version->update_hash = 'sha256:' . hash_file('sha256', $extensionFile);
            $version->update_link = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/download.php?file=' . urlencode($extensionFileName);
            $json->addons->{$extensionId}->updates[] = $version;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($json);
