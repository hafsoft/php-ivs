<?php
/**
 * HafSoft Integrated Voting System
 * Copyright (c) 2013 Abi Hafshin Alfarouq
 * < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for HafSoft Integrated Voting System.
 * more info: http://github.com/hafsoft/php-ivs
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */


if (!defined('DEBUG')) {
    define('DEBUG', FALSE);
}

if (!defined('ENABLE_LOG')) {
    define('ENABLE_LOG', TRUE);
}

if (! defined('CLASS_LOADER_INITIALIZED')) {
    /**
     * Class ClassLoader
     */
    class ClassLoader
    {
        public static $includeDirs = array();

        /**
         * @param $className
         */
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
    define('CLASS_LOADER_INITIALIZED', 1);
}

ClassLoader::$includeDirs[] = dirname(__FILE__);