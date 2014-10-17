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
use org\haf\ivs\IObject;
use org\haf\ivs\IvsException;
use org\haf\ivs\Object;

/**
 * Class Json
 *
 * @package org\haf\ivs\tool
 */
class Json
{
    const IOBJECT_CLASS = 'org\haf\ivs\IObject';

    /**
     * @param $object
     * @return array|string
     */
    public static function serializeToJson($object)
    {
        return json_encode(self::convertObjectToArray($object));
    }

    /**
     * @param IObject|array|string|number $object
     * @return array
     */
    public static function convertObjectToArray($object)
    {
        if (is_a($object, self::IOBJECT_CLASS)) {
            return self::convertObjectToArray($object->toArray());
        } elseif (is_array($object)) {
            $result = array();
            foreach ($object as $key => &$value) {
                $result[$key] = self::convertObjectToArray($value);
            }
            return $result;
        } else {
            return $object;
        }
    }

    /**
     * @param string $json
     * @return array|number|Object|string
     */
    public static function unSerializeFromJson($json)
    {
        return self::convertArrayToObject(json_decode($json, true));
    }


    /**
     * @param array|number|string $array
     * @throws \org\haf\ivs\IvsException
     * @return array|Object|number|string
     */
    public static function convertArrayToObject(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $key => &$value) {
                $array[$key] = self::convertArrayToObject($value);
            }

            if (isset($array['__obj__'])) {
                $className = $array['__obj__'] = str_replace('.', '\\', $array['__obj__']);
                if (is_subclass_of($className, self::IOBJECT_CLASS))
                    return call_user_func(array($className, 'fromArray'), $array);
                else
                    throw new IvsException(IvsException::NOT_FOUND, 'Class %s not found', $className);
            }
            else {
                return $array;
            }
        } else {
            return $array;
        }
    }
}