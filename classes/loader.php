<?php


if (!defined('DEBUG')) {
    define('DEBUG', FALSE);
}

if (!defined('ENABLE_LOG')) {
    define('ENABLE_LOG', TRUE);
}

if (! class_exists('ClassLoader')) {
    class ClassLoader
    {
        public static $includeDirs = array();

        public static function autoLoad($className) {
            foreach(self::$includeDirs as $dir) {
                $classFile = sprintf('%s/%s.php', $dir, str_replace('\\', '/', $className));
                //var_dump($classFile);
                if (file_exists($classFile)) {
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