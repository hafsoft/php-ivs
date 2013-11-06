<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:52 PM
 */

namespace org\haf\ivs;


use org\haf\ivs\tool\Json;

abstract class Object implements IObject
{

    /**
     * @param string $name
     * @throws IvsException
     * @return mixed
     */
    public function __get($name)
    {
        $method = array(&$this, 'get' . ucfirst($name));
        if (is_callable($method)) {
            return call_user_func($method);
        } else
            //return parent::__get($name);
        throw new IvsException(IvsException::PROPERTY_NOT_FOUND);
    }

    /**
     * @param string $name
     * @param mixed $val
     * @throws IvsException
     */
    public function __set($name, $val)
    {
        $method = array(&$this, 'set' . ucfirst($name));
        if (is_callable($method)) {
            call_user_func($method, $val);
        } else
            //parent::__set($name, $val);
        throw new IvsException(IvsException::PROPERTY_NOT_FOUND);
    }

    /**
     * @return string[]|bool
     */
    protected function getPropertiesName()
    {
        return true;
    }

    /**
     * @return string[]|bool
     */
    protected function getConstructParamNames()
    {
        return false;
    }

    /**
     * @return array|null
     */
    protected function getProperties()
    {
        $propertiesName = $this->getPropertiesName();
        if ($propertiesName === true) {
            return get_object_vars($this);
        } elseif (is_array($propertiesName)) {
            $result = array();
            foreach ($this->getPropertiesName() as $prop) {
                $result[$prop] = $this->$prop;
            }
            return $result;
        } else {
            return null;
        }
    }

    public function setProperties($properties)
    {
        foreach ($properties as $key => &$val) {
            $this->$key =& $val;
        }
    }

    /**
     * @return array|null
     */
    protected function getConstructParams()
    {
        $names = $this->getConstructParamNames();
        if ($names) {
            $result = array();
            foreach ($names as $name) {
                $result[] =& $this->$name;
            }
            return $result;
        } else
            return null;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return array(
            '__obj__' => str_replace('\\', '.', get_class($this)),
            '__construct' => $this->getConstructParams(),
            '__prop' => $this->getProperties(),
        );
    }

    /**
     * @param mixed $array
     * @return Object
     */
    public static function fromArray($array)
    {
        /** @var Object $object */
        $object = self::newInstance(str_replace('.', '\\', $array['__obj__']), $array['__construct']);
        if ($array['__prop'])
            $object->setProperties($array['__prop']);
        return $object;
    }

    /**
     * @param string $name
     * @param mixed[] $args
     * @return Object
     */
    private static function newInstance($name, $args)
    {
        if ($args == null) {
            return new $name();
        } else {
            $reflection = new \ReflectionClass($name);
            return $reflection->newInstanceArgs($args);
        }
    }
}