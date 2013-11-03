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

class IvsClient extends Ivs
{

    /** @var  string */
    private $serverAddress;

    /**
     * @param string $serverAddress
     */
    function __construct($serverAddress)
    {
        parent::__construct(array());
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


}


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
     * @return IObject
     */
    private function sendCommand($action, $arguments = null)
    {
        $http = new CurlHttpRequest();

        //$xdebug_session = isset($_GET['XDEBUG_SESSION_START']) ? $_GET['XDEBUG_SESSION_START'] : null;
        $xdebug_session = 123;
        $xdebug_str     = $xdebug_session ? '&XDEBUG_SESSION_START=' . $xdebug_session : '';

        $http->open('POST', $this->parent->getServerAddress() . '?r=' . time() . rand(0, 99999) . $xdebug_str);
        $http->addHeader('Connection', 'close');

        $request       = new IvsServiceRequest($this->name, $action, $arguments);
        $respondString = $http->send(Json::serializeToJson($request->toArray()));

        $respond = IvsServiceRespond::fromArray(Json::unSerializeFromJson($respondString));
        if ($respond->getError())
            throw $respond->getError();
        return $respond->getResult();
    }

    public function isMethodAllowed($methodName) {}
}