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
 * Class IvsServiceRespond
 *
 * @package org\haf\ivs
 */
class IvsServiceRespond implements IObject
{
    /** @var  string */
    private $version;

    private $id;

    private $result;

    private $error;


    /**
     * @return bool
     */
    function isValid() {
        return $this->id !== null;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
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
     * @param int $id
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
            'ivs-rpc' => $this->version,
            'id'      => $this->id,
            'result'  => $this->result,
            'error'   => $this->error,
        );
    }

    /**
     * @param mixed $array
     * @return \org\haf\ivs\IvsServiceRespond
     */
    public static function fromArray($array)
    {
        if (!is_array($array) || !isset($array['ivs-rpc'])) $array = array(); // hack
        $respond = new IvsServiceRespond();
        isset($array['ivs-rpc']) and $respond->version = $array['ivs-rpc'];
        isset($array['id']) and $respond->id = $array['id'];
        isset($array['result']) and $respond->result = $array['result'];
        isset($array['error']) and $respond->error = $array['error'];
        return $respond;
    }
}