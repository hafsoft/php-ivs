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

use Exception;
use org\haf\ivs\ballot\IBallotManager;
use org\haf\ivs\cache\ICacheManager;
use org\haf\ivs\election\IElectionManager;
use org\haf\ivs\key\IKeyManager;
use org\haf\ivs\logger\ILoggerManager;
use org\haf\ivs\voteBooth\IVoteBoothManager;
use org\haf\ivs\voter\IVoter;
use org\haf\ivs\voter\IVoterManager;

/**
 * IVS main class
 * todo: create documentation
 *
 * @author abie
 * @date 11/1/13 1:02 PM
 * @package org\haf\ivs
 */
abstract class Ivs
{
    const VERSION = '1.0';

    /** @var Ivs|null */
    private static $instance = null;

    /** @var  mixed */
    private $config;

    /** @var  IManager[] */
    private $manager = array();

    /** @var bool */
    protected $remoteCall = false;

    /**
     * @var array
     */
    private static $defaultConfig = array(
        'manager' => array(
            'cache' => 'org\haf\ivs\cache\DummyCacheManager',
            'logger' => 'org\haf\ivs\logger\DummyLogger',
        ),
    );

    /**
     * @throws Exception
     * @return Ivs
     */
    public static function &app() {
        if (self::$instance !== null) {
            return self::$instance;
        }
        throw new \Exception('IVS has not been initialized');
    }

    /**
     * todo: create documentation
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        if (self::$instance !== null) {
            throw new \Exception('IVS has been initialized. Use Ivs::app()');
        }
        self::$instance =& $this;

        $this->config = array_merge_recursive(self::$defaultConfig, $config);
        // $this->logger = new FileLogger($this, $this->config['logger']['file']);

        ENABLE_LOG && self::log("Initialized");
    }

    /**
     *
     */
    function __destruct() {
        ENABLE_LOG && self::log("Closed\n\n");
    }

    /**
     * get current version
     *
     * @return string
     */
    public function getVersion() {
        return self::VERSION;
    }

    /**
     * @return IVoter
     */
    abstract public function getCurrentVoter();

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function getConfig($name, $default = null) {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
        else {
            return $default;
        }
    }

    /**
     * todo: create documentation
     *
     * @param $name
     * @throws IvsException
     * @return IManager
     */
    function &getManager($name)
    {
        if (!isset($this->manager[$name])) {
            if (NULL === ($this->manager[$name] = $this->createManager($name))) {
                throw new IvsException(IvsException::MANAGER_NOT_DEFINED, "Manager $name not defined");
            }
        }
        return $this->manager[$name];
    }

    /**
     * @param string $name
     * @return IManager
     */
    protected function createManager($name)
    {
        if (isset($this->config['manager'][$name])) {
            $args = $this->config['manager'][$name];
            if (is_array($args)) {
                if (!isset($args['class'])) {
                    return FALSE;
                }
                $className = $args['class'];
            } else {
                $className = $args;
                $args      = null;
            }

            if (is_subclass_of($className, 'org\haf\ivs\IManager')) {
                return new $className($this, $args);
            }
        }
        return NULL;
    }


    /**
     * todo: create documentation
     *
     * @return ICacheManager
     */
    public function &getCacheManager()
    {
        return $this->getManager('cache');
    }


    /**
     * todo: create documentation
     *
     * @return IElectionManager
     */
    public function &getElectionManager()
    {
        return $this->getManager('election');
    }

    /**
     * todo: create documentation
     *
     * @return IVoterManager
     */
    public function &getVoterManager()
    {
        return $this->getManager('voter');
    }

    /**
     * todo: create documentation
     *
     * @return IBallotManager
     */
    public function getBallotManager()
    {
        return $this->getManager('ballot');
    }

    /**
     * todo: create documentation
     *
     * @return IVoteBoothManager
     */
    public function getVoteBothManager()
    {
        return $this->getManager('voteBooth');
    }

    /**
     * todo: create documentation
     *
     * @return IKeyManager
     */
    public function getKeyManager()
    {
        return $this->getManager('key');
    }

    /**
     * @return ILoggerManager
     */
    protected function getLoggerManager() {
        return $this->getManager('logger');
    }

    /**
     * @return bool
     */
    public function isRemoteCall() {
        return $this->remoteCall;
    }

    /**
     * @param string $str
     * @param mixed $args [optional]
     */
    public static function log($str, $args = null) {
        if ($args) {
            self::app()->getLoggerManager()->logArgs($str, array_splice(func_get_args(), 1));
        } else {
            self::app()->getLoggerManager()->log($str);
        }
    }
}
