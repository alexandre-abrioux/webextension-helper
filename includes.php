<?php

require __DIR__ . '/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$extensionSrcDir = __DIR__ . '/' . $_ENV['WEB_EXT_SOURCE_DIR'];
$extensionDistDir = __DIR__ . '/' . $_ENV['WEB_EXT_ARTIFACTS_DIR'];