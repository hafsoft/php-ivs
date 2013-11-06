<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 8:16 PM
 */

namespace org\haf\ivs\logger;


use org\haf\ivs\logger\ILoggerManager;

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
    public function isMethodAllowed($methodName)
    {
        return false;
    }
}