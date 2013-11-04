<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 8:16 PM
 */

namespace org\haf\ivs;


class Logger {
    private $fh;
    private $ivsClass;

    public function __construct($ivs, $filename = '/var/log/ivs.log') {
        $this->fh = fopen($filename, 'a');
        $arr = explode('\\', get_class($ivs));
        $this->ivsClass = $arr[count($arr) - 1];
    }

    public function __destruct() {
        fclose($this->fh);
    }


    public function log($str, $_ = null) {
        if ($_) {
            $this->logArgs($str, array_splice(func_get_args(), 1));
        } else {
            $this->writeLog($str);
        }

    }

    public function logArgs($str, $args) {
        $this->writeLog(vsprintf($str, $args));
    }

    private function writeLog($str) {
        fwrite($this->fh, date('Y-m-d H:i:s.u ') . $this->ivsClass . ': ');
        fwrite($this->fh, $str . "\n");
    }
}