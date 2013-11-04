<?php

namespace org\haf\ivs;
use org\haf\ivs\tool\Json;


/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 12:01 PM
 * @property number $id
 */
class IvsServiceRespond implements IObject
{

    private $id;

    private $result;

    private $error;

    /**
     * @param number $id
     * @param mixed $result
     * @param IvsException $error
     */
    public function __construct($id = null, $result = null, $error = null)
    {
        $this->id     = $id;
        $this->result = $result;
        $this->error  = $error;
    }

    /**
     * @param \org\haf\ivs\IvsException|null $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return \org\haf\ivs\IvsException|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed|null $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }


    public function toArray()
    {
        return array(
            'ivs-rpc' => 1,
            'id'      => $this->id,
            'result'  => $this->result,
            'error'   => $this->error,
        );
    }

    public static function fromArray($array)
    {
        $a = $array;
        return new IvsServiceRespond(
            isset($array['id']) ? $array['id'] : null,
            isset($array['result']) ? $array['result'] : null,
            isset($array['error']) ? $array['error'] : null
        );
    }
}