<?php

require __DIR__ . '../includes.php';

$json = ['addons'];
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
    $json['addons'][$extensionId]['updates'] = [];
    if (!empty($extensionVersion)) {
        $extensionFile = glob($extensionDistDir . '/*-' . $extensionVersion . '-*.xpi');
        if (!empty($extensionFile)) {
            $extensionFile = $extensionFile[0];
            $extensionFileName = basename($extensionFile);
            $json['addons'][$extensionId]['updates'][] = [
                'version' => $extensionVersion,
                'update_link' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/download.php?file=' . urlencode($extensionFileName),
                'update_hash' => hash_file('sha256', $extensionFile)
            ];
        }
    }
}
echo json_encode($json);