<?php
/** @noinspection PhpUndefinedClassInspection */

if (! class_exists('ClassLoader')) {
    class ClassLoader
    {
        public static $includeDirs = array();

        public static function autoLoad($className) {
            foreach(self::$includeDirs as $dir) {
                $classFile = "$dir/$className.php";
                if (file_exists($className)) {
                    /** @noinspection PhpIncludeInspection */
                    include $classFile;
                    return;
                }
            }
        }
    }

    spl_autoload_register(array('ClassLoader', 'autoLoad'));
}

ClassLoader::$includeDirs[] = dirname(__FILE__);