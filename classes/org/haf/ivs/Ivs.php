<?php
/**
 * Integrated Voting System
 * Copyright (C) 2013 Abi Hafshin Alfarouq < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for Hafsoft Integrated Voting System ...
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

use org\haf\ivs\ballot\IBallotManager;
use org\haf\ivs\cache\FileCache;
use org\haf\ivs\cache\ICache;
use org\haf\ivs\election\IElectionManager;
use org\haf\ivs\key\IKeyManager;
use org\haf\ivs\voteBooth\IVoteBoothManager;
use org\haf\ivs\voter\IVoter;
use org\haf\ivs\voter\IVoterManager;

/**
 * IVS main class
 * todo: create documentation
 *
 * @author abie
 * @date 11/1/13 1:02 PM
 */
abstract class Ivs
{
    /** @var Ivs|null */
    public static $instance = null;

    /** @var  mixed */
    protected $config;

    /** @var  IManager[] */
    protected $manager = array();

    /** @var  ICache */
    private $cacheManager;

    /** @var bool */
    protected $remoteCall = false;

    private $logger;

    /**
     * todo: create documentation
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        if (self::$instance !== null) {
            throw new \Exception('IVS has been initialized. Use Ivs::$instance');
        }
        self::$instance = & $this;

        if (!isset($config['manager']))
            $config['manager'] = array();

        $this->config = $config;
        $this->logger = new Logger();

        self::log("Initialized.");

    }

    /**
     * @return IVoter
     */
    abstract public function getCurrentVoter();

    /**
     * @param string $name
     * @return IManager
     * @throws IvsException
     */
    protected function createManager($name)
    {
        if (isset($this->config['manager'][$name])) {
            $args = $this->config['manager'][$name];
            if (is_array($args)) {
                $className = $args['class'];
            } else {
                $className = $args;
                $args      = null;
            }
            $manager = new $className($this, $args);
            return $manager;
        }
        throw new IvsException(IvsException::MANAGER_NOT_DEFINED, "Manager $name not defined");
    }

    /**
     * todo: create documentation
     *
     * @return ICache
     */
    public function &getCache()
    {
        if ($this->cacheManager === null) {
            $this->cacheManager = new FileCache();
            $this->cacheManager->setCacheDir('/tmp/ivs');
        }
        return $this->cacheManager;
    }

    protected function createCacheObject() {
        $cache = new FileCache();
        $cache->setCacheDir('/tmp/ivs');
    }

    /**
     * todo: create documentation
     *
     * @param $name
     * @return IManager
     */
    function &getManager($name)
    {
        if (!isset($this->manager[$name])) {
            $this->manager[$name] = $this->createManager($name);
        }
        return $this->manager[$name];
    }

    /**
     * todo: create documentation
     *
     * @return IElectionManager
     */
    public function getElectionManager()
    {
        return $this->getManager('IElectionManager');
    }

    /**
     * todo: create documentation
     *
     * @return IVoterManager
     */
    public function getVoterManager()
    {
        return $this->getManager('IVoterManager');
    }

    /**
     * todo: create documentation
     *
     * @return IBallotManager
     */
    public function getBallotManager()
    {
        return $this->getManager('IBallotManager');
    }

    /**
     * todo: create documentation
     *
     * @return IVoteBoothManager
     */
    public function getVoteBothManager()
    {
        return $this->getManager('IVoteBoothManager');
    }

    /**
     * todo: create documentation
     *
     * @return IKeyManager
     */
    public function getKeyManager()
    {
        return $this->getManager('IKeyManager');
    }

    /**
     * @return bool
     */
    public function isRemoteCall() {
        return $this->remoteCall;
    }

    public static function log($str, $args = null) {
        if ($args) {
            self::$instance->logger->logArgs($str, array_splice(func_get_args(), 1));
        } else {
            self::$instance->logger->log($str);
        }
    }
}