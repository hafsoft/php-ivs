<?php

namespace org\haf\ivs;
use org\haf\ivs\tool\Json;


/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 12:01 PM
 */
class IvsServiceRequest implements IObject
{

    /** @var number */
    private $id;

    /** @var string */
    private $managerName;

    /** @var string */
    private $methodName;

    /** @var mixed */
    private $arguments;

    /**
     * @param string $managerName
     * @param string $methodName
     * @param mixed $arguments
     */
    function __construct($managerName = null, $methodName = null, $arguments = null)
    {
        $this->methodName  = $methodName;
        $this->managerName = $managerName;
        $this->arguments   = $arguments;
        $this->id          = rand(0, 99999);
    }

    public function isValid()
    {
        return $this->methodName !== null && $this->managerName !== null && $this->methodName !== null;
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
     * @return mixed
     */
    public function toArray()
    {
        return array(
            'ivs-rpc' => 1,
            'id'      => $this->id,
            'manager' => $this->managerName,
            'method'  => $this->methodName,
            'args'    => $this->arguments
        );
    }

    /**
     * @param mixed $array
     * @return \org\haf\ivs\IvsServiceRequest
     */
    public static function fromArray($array)
    {
        return new IvsServiceRequest(
            isset($array['manager']) ? $array['manager'] : null,
            isset($array['method']) ? $array['method'] : null,
            isset($array['args']) ? $array['args'] : null
        );
    }
}