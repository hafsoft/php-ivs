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

namespace org\haf\ivs;

/**
 * Class IvsException
 *
 * @package org\haf\ivs
 */
class IvsException extends \Exception implements IObject
{
    const NOT_FOUND            = 'ivs:notFound';
    const INVALID_REQUEST      = 'ivs:invalidRequest';
    const INVALID_RESPOND      = 'ivs:invalidRespond';
    const METHOD_NOT_SUPPORTED = 'ivs:methodNotSupported';
    const ACCESS_DENIED        = 'ivs:accessDenied';
    const MANAGER_NOT_DEFINED  = 'ivs:managerNotDefined';
    const PROPERTY_NOT_FOUND   = 'ivs:propertyNotFound';
    const UNKNOWN_CLASS        = 'ivs:unknownClass';

    const ERROR_UNKNOWN        = 'ivs:unknown';
    const NOT_INITIALIZED      = 'ivs:notInitialized';
    const CONNECTION_FAIL      = 'ivs:connFail';

    /** @var string  */
    private $errorCode;

    /** @var null|string  */
    private $errorDetails;

    /** @var  string */
    private $errorTrace;

    /**
     * @param string $errorCode
     * @param null|string $errorDetails
     * @param mixed $args
     */
    public function __construct($errorCode = self::ERROR_UNKNOWN, $errorDetails = null, $args = null)
    {
        $this->errorCode    = $errorCode;
        if ($args !== null) {
            $funcArg = array_splice(func_get_args(), 2);
            $errorDetails = vsprintf($errorDetails, $funcArg);
        }
        $this->errorDetails = $errorDetails;
        $this->code         = 99;
        $this->message =  "#{$this->errorCode} {$this->errorDetails}";

        ENABLE_LOG && Ivs::log('%s: %s', get_class($this), $this->message);
        DEBUG && Ivs::log("start trace >>\n%s\n<<<", $this->getTraceAsString());

        if (Ivs::app()->isRemoteCall()) {
            $duration = $this->getSleepDuration($errorCode);
            $duration > 0 && sleep($duration);  // fuck that!!
        }
    }

    /**
     * @param string $code error code
     * @return int sleep duration in seconds
     */
    protected function getSleepDuration($code) {
        switch ($code) {
            case self::ACCESS_DENIED:
                return 10;

            case self::NOT_FOUND:
                return 2;

            case self::ERROR_UNKNOWN:
            case self::CONNECTION_FAIL:
                // internal server error, don't let client wait
                return 0;

            default:
                return 5;
        }
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return mixed
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }


    /**
     * @return mixed
     */
    public function toArray()
    {
        $debug = null;
        if (DEBUG) {
            $debug = array(
                'file'  => $this->getFile(),
                'line'  => $this->getLine(),
                'trace' => $this->getTraceAsString(),
            );
        }
        return array(
            '__obj__' => str_replace('\\', '.', get_class($this)),
            '__code'        => $this->errorCode,
            '__detail'      => $this->errorDetails,
            '__debug'       => $debug,
        );
    }

    public function __toString() {
        return $this->message;
    }

    /**
     * @param mixed $array
     * @throws \Exception
     * @return IvsException
     */
    public static function fromArray($array)
    {
        /** @var IvsException $err */
        $className = $array['__obj__'];
        $err = new $className($array['__code'], $array['__detail']);
        if (DEBUG && $info = $array['__debug']) {
            $err->file = $info['file'];
            $err->line = $info['line'];
            $err->errorTrace = $info['trace'];
            Ivs::log("error trace from server >>\n%s\n<<", $info['trace']);
        }

        return $err;
    }
}