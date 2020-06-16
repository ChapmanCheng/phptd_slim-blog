<?php

spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    if (strpos($className, '\\') !== false) {
        $namespaceArray = explode('\\', $className);
        $className = end($namespaceArray);
    };

    $dirs = glob(__DIR__ . "/*/", GLOB_ONLYDIR);
    foreach ($dirs as $dir) {
        $targetFile = $dir . $className . ".php";
        if (file_exists($targetFile)) {
            include $targetFile;
        }
    }
}
