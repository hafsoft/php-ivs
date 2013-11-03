<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 7:18 PM
 */

namespace org\haf\ivs\tool;
use org\haf\ivs\IObject;
use org\haf\ivs\Object;

class Json
{
    /**
     * @param $object
     * @return array|string
     */
    public static function serializeToJson($object)
    {
        return json_encode(self::convertObjectToArray($object));
    }

    public static function convertObjectToArray($object)
    {
        if (is_a($object, 'org\haf\ivs\IObject')) {
            /** @var IObject $object */
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
     * @return array|Object|number|string
     */
    public static function convertArrayToObject(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $key => &$value) {
                $array[$key] = self::convertArrayToObject($value);
            }

            if (isset($array['__class__'])) {
                $array['__class__'] = str_replace('.', '\\', $array['__class__']);
                return call_user_func(array($array['__class__'], 'fromArray'), $array);
            }
            elseif (isset($array['__exception__'])) {
                $array['__exception__'] = str_replace('.', '\\', $array['__exception__']);
                return call_user_func(array($array['__exception__'], 'fromArray'), $array);
            }
            else {
                return $array;
            }
        } else {
            return $array;
        }
    }
}