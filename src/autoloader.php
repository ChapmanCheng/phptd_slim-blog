<?php

spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
    if (strpos($className, '\\') !== false) {
        $namespaceArray = explode('\\', $className);
        $className = end($namespaceArray);
    };

    $dir = __DIR__ . "/class/";
    $targetFile = $dir . $className . ".php";
    if (file_exists($targetFile)) {
        include $targetFile;
    }
}
