<?php

$srcDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src') . DIRECTORY_SEPARATOR;
$classesDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'classes') . DIRECTORY_SEPARATOR;
$composerDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor') . DIRECTORY_SEPARATOR;

//Composer autoload
$composerFile = $composerDirectory . 'autoload.php';
if (file_exists($composerFile)) {
    include_once($composerFile);
}

/**
 * Package autoload
 */
\Zver\Common::registerAutoloadClassesFrom($srcDirectory);
\Zver\Common::registerAutoloadClassesFrom($classesDirectory);

//Functions file autoload
$functionsFile = $srcDirectory . 'Functions.php';
if (file_exists($functionsFile)) {
    include_once($functionsFile);
}
