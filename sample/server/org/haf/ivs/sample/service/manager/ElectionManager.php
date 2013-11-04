<?php

namespace org\haf\ivs\sample\service\manager;
use org\haf\ivs\AbstractManager;
use org\haf\ivs\candidate\Candidate;
use org\haf\ivs\election\Election;
use org\haf\ivs\election\ElectionException;
use org\haf\ivs\election\IElection;
use org\haf\ivs\election\IElectionManager;
use org\haf\ivs\Ivs;
use org\haf\ivs\IvsException;
use org\haf\ivs\sample\service\tool\Base64Encoder;

/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 1:59 PM
 * @package org.haf.ivs.sample.service.manager
 */
class ElectionManager extends AbstractManager implements IElectionManager {
    private static $elections = array(
        1 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        ),

        2 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        ),

        3 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        ),

        4 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        ),

        5 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        )
    );

    private $cache = array();

    /**
     * @param string $id
     * @return IElection
     * @throws \org\haf\ivs\election\ElectionException
     */
    public function &getById($id)
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }
        if (null === ($election = $this->ivs->getCacheManager()->fetchObject('Election', $id))) {
            if (isset(self::$elections[$id])) {
                $prop = self::$elections[$id];
                $election = new Election();
                $election->setId($id);
                $election->setName($prop['name']);

                $candidates = array();
                foreach($prop['candidates'] as $c) {
                    $candidate = new Candidate();
                    $candidate->setName($c['name']);
                    $candidate->setId($c['seq'] + $id * 50);
                    $candidate->setPhoto(Base64Encoder::encodeFile('photo/' . rand(1, 7) . '.jpg'));

                    $candidates[] = $candidate;
                }
                $election->setCandidates($candidates);

                if ($this->isRemoteCall()) {
                    $election->getPublicKey(); // triger to load key
                }
                $this->cache[$id] =& $election;
                // $this->ivs->getCache()->putObject('Election', $id, $election);
            }
            else {
               throw new ElectionException(ElectionException::NOT_FOUND, 'Election %s not found', $id);
            }
        }
        return $election;
    }

    /**
     * @param string[] $ids
     * @return IElection[]
     */
    public function getByIds($ids)
    {
        $result = array();
        foreach ($ids as $id) {
            $result[] = $this->getById($id);
        }
        return $result;
    }

    public function getAllowedMethods() {
        return array('getById', 'getByIds');
    }
}