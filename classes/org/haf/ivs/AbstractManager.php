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


/**
 * Class AbstractManager
 *
 * @package org\haf\ivs
 */
abstract class AbstractManager implements IManager
{
    /** @var Ivs */
    protected $ivs;

    /** @var mixed|null */
    protected $config;

    /**
     * @param Ivs $parent
     * @param null|mixed $config
     */
    public function __construct($parent, $config = null)
    {
        $this->ivs    = $parent;
        $this->config = $config;
    }

    protected function getConfig($name, $default = null) {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        } else {
            return $default;
        }
    }

    /**
     * @return string[]
     */
    protected  function getAllowedMethods()
    {
        return array();
    }

    public function isRemoteAllowed($methodName)
    {
        $allowedMethod = $this->getAllowedMethods();
        if (isset($allowedMethod[$methodName])) {
            $role = $allowedMethod[$methodName];
            if (is_string($role)) {
                if ($role === '*') return true;
                // TODO: lanjutin
            }
        } elseif (in_array($methodName, $allowedMethod)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function isClient()
    {
        return is_a($this->ivs, 'org\haf\ivs\IvsClient');
    }

    /**
     * @return bool
     */
    protected function isRemoteCall() {
        return $this->ivs->isRemoteCall();
    }


}