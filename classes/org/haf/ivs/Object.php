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
 * Class Object
 *
 * @package org\haf\ivs
 */
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
        throw new IvsException(IvsException::PROPERTY_NOT_FOUND, 'property %s not found in this class', $name);
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
        throw new IvsException(IvsException::PROPERTY_NOT_FOUND, 'property %s not found in this class', $name);
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

    public  function getClassName() {
        return str_replace('\\', '.', get_class($this));
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return array(
            '__obj__' => $this->getClassName(),
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