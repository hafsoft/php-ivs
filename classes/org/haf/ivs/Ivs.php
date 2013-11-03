<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 1:02 PM
 */

namespace org\haf\ivs;

use org\haf\ivs\ballot\IBallotManager;
use org\haf\ivs\cache\FileCache;
use org\haf\ivs\election\IElectionManager;
use org\haf\ivs\key\IKeyManager;
use org\haf\ivs\voteBooth\IVoteBoothManager;
use org\haf\ivs\voter\IVoterManager;

abstract class Ivs
{
    /** @var Ivs|null */
    public static $instance = null;

    /** @var  mixed */
    protected $config;

    /** @var  IManager[] */
    protected $manager = array();

    private $cacheManager;

    protected $remoteCall = false;

    public function __construct($config)
    {
        if (self::$instance !== null) {
            throw new \Exception('IVS has been initialized. Use Ivs::$instance');
        }
        self::$instance = & $this;

        if (!isset($config['manager']))
            $config['manager'] = array();

        $this->config = $config;

    }

    abstract protected function createManager($name);

    public function getCache()
    {
        if ($this->cacheManager === null) {
            $this->cacheManager = new FileCache();
            $this->cacheManager->setCacheDir('/tmp/ivs');
        }
        return $this->cacheManager;
    }

    /**
     * @param $name
     * @return \org\haf\ivs\IManager
     */
    function getManager($name)
    {
        if (!isset($this->manager[$name])) {
            return $this->manager[$name] = $this->createManager($name);
        }
        return $this->manager[$name];
    }

    /**
     * @return IElectionManager
     */
    public function getElectionManager()
    {
        return $this->getManager('IElectionManager');
    }

    /**
     * @return IVoterManager
     */
    public function getVoterManager()
    {
        return $this->getManager('IVoterManager');
    }

    /**
     * @return IBallotManager
     */
    public function getBallotManager()
    {
        return $this->getManager('IBallotManager');
    }

    /**
     * @return IVoteBoothManager
     */
    public function getVoteBothManager()
    {
        return $this->getManager('IVoteBothManager');
    }

    /**
     * @return IKeyManager
     */
    public function getKeyManager()
    {
        return $this->getManager('IKeyManager');
    }

    public function isRemoteCall()
    {
        return $this->remoteCall;
    }
}