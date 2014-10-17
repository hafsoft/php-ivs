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
use org\haf\ivs\tool\Json;


/**
 * Class IvsServiceRequest
 *
 * @package org\haf\ivs
 */
class IvsServiceRequest implements IObject
{
    /** @var  string */
    private $version;

    /** @var number */
    private $id;

    /** @var string */
    private $managerName;

    /** @var string */
    private $methodName;

    /** @var mixed */
    private $arguments;

    private $sessionId;

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }


    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->methodName != null && $this->managerName != null;
    }

    /**
     * @param mixed $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $manager
     */
    public function setManagerName($manager)
    {
        $this->managerName = $manager;
    }

    /**
     * @return string
     */
    public function getManagerName()
    {
        return $this->managerName;
    }

    /**
     * @param string $method
     */
    public function setMethodName($method)
    {
        $this->methodName = $method;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return null|string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }



    /**
     * @return mixed
     */
    public function toArray()
    {
        return array(
            'ivs-rpc' => $this->version,
            'id'      => $this->id ? $this->id : rand(1, 10000),
            'manager' => $this->managerName,
            'method'  => $this->methodName,
            'args'    => $this->arguments,
            'sid'     => $this->sessionId,
        );
    }

    /**
     * @param mixed $array
     * @return \org\haf\ivs\IvsServiceRequest
     */
    public static function fromArray($array)
    {
        if (!is_array($array) || !isset($array['ivs-rpc'])) $array = array(); // hack
        $request = new IvsServiceRequest();

        isset($array['ivs-rpc']) and $request->version = $array['ivs-rpc'];
        isset($array['id']) and $request->id = $array['id'];
        isset($array['manager']) and $request->managerName = $array['manager'];
        isset($array['method']) and $request->methodName = $array['method'];
        isset($array['args']) and $request->arguments = $array['args'];
        isset($array['sid']) and $request->sessionId = $array['sid'];


        return $request;
    }
}