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

namespace org\haf\ivs\logger;


use org\haf\ivs\logger\ILoggerManager;

/**
 * Class FileLogger
 *
 * @package org\haf\ivs\logger
 */
class FileLogger implements ILoggerManager {
    private $fh;
    private $ivsClass;

    public function __construct($ivs, $config = null) {
        $filename = $config['file'];

        if (! $filename) {
            $filename = '/var/log/ivs.log';
        }
        $this->fh = fopen($filename, 'a');
        $arr = explode('\\', get_class($ivs));
        $this->ivsClass = $arr[count($arr) - 1];
    }

    public function __destruct() {
        fclose($this->fh);
    }


    public function log($str) {
        $this->writeLog($str);

    }

    public function logArgs($str, $args) {
        $this->writeLog(vsprintf($str, $args));
    }

    private function writeLog($str) {
        fwrite($this->fh, date('Y-m-d H:i:s') . substr((string)microtime(), 1, 6) . ' ' . $this->ivsClass . ': ');
        fwrite($this->fh, $str . "\n");
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function isRemoteAllowed($methodName)
    {
        return false;
    }
}