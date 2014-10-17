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


use org\haf\ivs\tool\CurlHttpRequest;
use org\haf\ivs\tool\Json;
use org\haf\ivs\voter\IVoter;

/**
 * Class IvsClient
 *
 * @package org\haf\ivs
 */
class IvsClient extends Ivs
{

    /** @var  string */
    private $serverAddress;

    private $currentVoter;

    /**
     * @param string $serverAddress
     * @param array $config
     */
    function __construct($serverAddress, $config = array())
    {
        parent::__construct($config);
        $this->serverAddress = $serverAddress;
    }

    /**
     * @return string
     */
    public function getServerAddress()
    {

        return $this->serverAddress;
    }

    /**
     * @param string $serverAddress
     */
    public function setServerAddress($serverAddress)
    {
        $this->serverAddress = $serverAddress;
    }

    /**
     * @param string $name
     * @return IManager|ManagerClient
     */
    protected function createManager($name)
    {
        $manager = parent::createManager($name);
        if ($manager === NULL) {
            $manager = new ManagerClient($this, array('name' => $name));
        }
        return $manager;
    }


    /**
     * @return CurlHttpRequest
     */
    protected function getConnectionToServer() {
        $http = new CurlHttpRequest();

        $xdebug_str     = (isset($_GET['XDEBUG_SESSION_START']) || isset($_COOKIE['XDEBUG_SESSION'])) ? '' : '&XDEBUG_SESSION_START=123';
        $http->open('POST', $this->getServerAddress() . '?r=' . time() . $xdebug_str);
        $http->addHeader('Connection', 'close');
        return $http;
    }

    /**
     * @param string $managerName
     * @param string $methodName
     * @param mixed[] $arguments
     * @param bool $throwError
     * @return mixed
     * @throws IvsException
     */
    public function callRemoteMethod($managerName, $methodName, $arguments, $throwError = true) {
        $request = new IvsServiceRequest();
        $request->setManagerName($managerName);
        $request->setMethodName($methodName);
        $request->setArguments($arguments);
        $request->setSessionId($this->getSessionId());
        $request->setVersion($this->getVersion());

        ENABLE_LOG && self::log('calling %s->%s()', $managerName, $methodName);
        $http    = $this->getConnectionToServer();
        $respondString = $http->send(Json::serializeToJson($request->toArray()));

        ENABLE_LOG && self::log('receive %s', $respondString);
        $respond = IvsServiceRespond::fromArray(Json::unSerializeFromJson($respondString));
        if (! $respond->isValid()) {
            throw new IvsException(IvsException::INVALID_RESPOND, "invalid respond\n$respondString");
        }
        if ($throwError && $respond->getError()){
            throw $respond->getError();
        }

        return $respond->getResult();
    }

    /**
     * get current session id
     *
     * @return null|string
     */
    protected function  getSessionId() {
        if ($voter = $this->getCurrentVoter()) {
            return $voter->getSessionId();
        }
        else {
            return null;
        }
    }

    /**
     * @return IVoter
     */
    public function getCurrentVoter() {
        return $this->currentVoter;
    }

    /**
     * @param IVoter $voter
     */
    public function setCurrentVoter($voter) {
        $this->currentVoter = $voter;
    }
}

/**
 * Class ManagerClient
 *
 * @package org\haf\ivs
 */
class ManagerClient implements IManager
{

    /** @var  IvsClient */
    private $parent;

    /** @var  string */
    private $name;

    /**
     * @param IvsClient $parent
     * @param null $config
     */
    public function __construct($parent, $config = null)
    {
        $this->parent = $parent;
        $this->name   = $config['name'];
    }


    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        return $this->parent->callRemoteMethod($this->name, $name, $args);
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