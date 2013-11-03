<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:51 PM
 */

namespace org\haf\ivs;


interface IObject
{

    /**
     * @return mixed
     */
    public function toArray();

    /**
     * @param mixed $array
     */
    public static function fromArray($array);

}