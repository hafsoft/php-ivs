<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 12:50 PM
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

    protected function createManager($name)
    {
        return new ManagerClient($this, array('name' => $name));
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


    public function __call($name, $args)
    {
        return $this->sendCommand($name, $args);
    }

    /**
     * @param string $action
     * @param mixed $arguments
     * @throws IvsException
     * @return mixed
     */
    private function sendCommand($action, $arguments = null)
    {
        $http = new CurlHttpRequest();

        $xdebug_session = (isset($_GET['XDEBUG_SESSION_START']) || isset($_COOKIE['XDEBUG_SSESSION'])) ? null : 123;
        //$xdebug_session = 123;
        $xdebug_str     = $xdebug_session ? '&XDEBUG_SESSION_START=' . $xdebug_session : '';

        $http->open('POST', $this->parent->getServerAddress() . '?r=' . time() . rand(0, 99999) . $xdebug_str);
        $http->addHeader('Connection', 'close');

        DEBUG &&
            Ivs::log('calling %s->%s()', $this->name, $action);
        $currentVoter  = $this->parent->getCurrentVoter();
        $sessionId = $currentVoter ? $currentVoter->getSessionId() : NULL;
        $request       = new IvsServiceRequest($this->name, $action, $arguments, $sessionId);
        $respondString = $http->send(Json::serializeToJson($request->toArray()));
        DEBUG && Ivs::log('receive %s', $respondString);

        $respond = IvsServiceRespond::fromArray(Json::unSerializeFromJson($respondString));
        if (! $respond->isValid()) {
            throw new IvsException(IvsException::INVALID_RESPOND, "invalid respond\n$respondString");
        }
        if ($respond->getError()){
            throw $respond->getError();
        }
        return $respond->getResult();
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function isMethodAllowed($methodName)
    {
        // nothing to do here
    }
}