<?php

/*
 * Auto Loader class
 */

class Autoloader
{
    public static function loader($className)
    {
        $filename = __DIR__ ."/" . str_replace("\\", '/', $className) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return true;
            }
        }
        return false;
    }
}
spl_autoload_register('Autoloader::loader');
