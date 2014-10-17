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

namespace org\haf\ivs\voter;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\Object;


/**
 * Class Voter
 *
 * @package org\haf\ivs\voter
 */
class Voter extends Object implements IVoter
{
    /** @var  string */
    protected $id;

    /** @var string */
    protected $sessionId;

    /** @var string */
    protected $name;

    /** @var array */
    protected $info;

    /** @var IElection[] */
    protected $elections = null;

    /** @var string[] */
    protected $electionIds = array();

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \org\haf\ivs\election\IElection[] $elections
     */
    public function setElections($elections)
    {
        $this->elections =& $elections;
    }

    /**
     * @return \org\haf\ivs\election\IElection[]
     */
    public function &getElections()
    {
        if ($this->elections === null) {
            $result   = array();
            $idsToGet = array();
            $cache = Ivs::app()->getCacheManager();

            $i = 0;
            foreach ($this->electionIds as $id) {
                $election =& $cache->fetchObject('election', $id);
                if ($election === null) {
                    $idsToGet[$id] = $i;
                    $result[]      = $id;
                } else {
                    $result[] = $election;
                }

                $i++;
            }
// var_dump($idsToGet);
            if ($idsToGet) {
                $gottenElections = Ivs::app()->getElectionManager()->getByIds(array_keys($idsToGet));
                if ($gottenElections) {
                    foreach ($gottenElections as $election) {
                        //var_dump($election->getId());
                        $cache->putObject('election', $election->getId(), $election);
                        $result[$idsToGet[$election->getId()]] = $election;
                    }
                }
            }

            $this->elections =& $result;
        }
        return $this->elections;
    }

    /**
     * @param array $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param \string[] $election_ids
     */
    public function setElectionIds($election_ids)
    {
        $this->electionIds = $election_ids;
    }

    /**
     * @return \string[]
     */
    public function getElectionIds()
    {
        return $this->electionIds;
    }

    /**
     * @return array|null
     */
    public function getProperties()
    {
        $properties = parent::getProperties();
        if (Ivs::app()->isRemoteCall())
            unset($properties['elections']);
        return $properties;
    }

}
