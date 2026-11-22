<?php

/**
 * Resolve a directory from an env var, relative to the parent of this app.
 * Fails if the env var is unset/empty or the directory does not exist.
 */
function resolveDirFromEnv(string $envVar): string
{
    $value = getenv($envVar);
    if ($value === false || $value === ''
        || ($dir = realpath(__DIR__ . '/../' . $value)) === false
        || !is_dir($dir))
        exit;
    return $dir;
}

$extensionSrcDir = resolveDirFromEnv('WEB_EXT_SOURCE_DIR');
$extensionDistDir = resolveDirFromEnv('WEB_EXT_ARTIFACTS_DIR');
