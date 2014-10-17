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

namespace org\haf\ivs\tool;
use org\haf\ivs\IvsException;

/**
 * Class CurlHttpRequest
 *
 * @package org\haf\ivs\tool
 */
class CurlHttpRequest
{
    /** @var null|resource */
    private $handler = null;

    /** @var string[] */
    private $headers = array();

    /**
     * initialize curl
     */
    public function __construct()
    {
        $this->handler = curl_init();
    }

    /**
     * @param string $method GET or POST
     * @param string $url
     * @return bool
     */
    public function open($method, $url)
    {
        $options = array(
            CURLOPT_HEADER         => 0,
            CURLOPT_URL            => $url,
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_TIMEOUT        => 60,
        );

        switch (strtolower($method)) {
            case 'post':
                $options[CURLOPT_POST] = true;
                break;

        }
        return $this->setOptions($options);
    }

    /**
     * @param int $option CURLOPT_*
     * @param mixed $value
     * @return bool
     */
    public function setOption($option, $value) {
        return curl_setopt($this->handler, $option, $value);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function setOptions($options) {
        return curl_setopt_array($this->handler, $options);
    }

    /**
     * @param string $caPath
     * @return bool
     */
    public function setCAPath($caPath) {
        return $this->setOptions(array(
            CURLOPT_CAPATH => $caPath,
            CURLOPT_SSL_VERIFYPEER => TRUE,
        ));
    }

    /**
     * @param string $caInfo
     * @return bool
     */
    public function setCAInfo($caInfo) {
        return $this->setOptions(array(
            CURLOPT_CAINFO => $caInfo,
            CURLOPT_SSL_VERIFYPEER => TRUE,
        ));
    }

    /**
     * @param $name
     * @param $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[] = "$name: $value";
    }

    /**
     * @param string $data
     * @throws \Exception
     * @return string
     */
    public function send($data = null)
    {
        if (count($this->headers) > 0) {
            curl_setopt($this->handler, CURLOPT_HTTPHEADER, $this->headers);
        }
        if ($data) {
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $data);
        }
        if ($result = curl_exec($this->handler)) {
            return $result;
        } else {
            $error = curl_error($this->handler);
            $errNo = curl_errno($this->handler);
            throw new IvsException(IvsException::CONNECTION_FAIL, '%s: %s', $error, $errNo);
        }
    }


    /**
     * close connection
     */
    public function close()
    {
        curl_close($this->handler);
    }

    /**
     * @param $name
     * @param $value
     */
    public function replaceHeader($name, $value)
    {
        // TODO: Implement replaceHeader() method.
    }
}