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

use org\haf\ivs\ballot\BallotException;
use org\haf\ivs\ballot\IBallot;
use org\haf\ivs\ballot\IBallotFactory;
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IPackedBallot;


/**
 * Class TallyResult
 *
 * @package org\haf\ivs
 */
class TallyResult
{
    /** @var  IBallotFactory */
    private $ballotFactory;

    /** @var  IBallotIterator */
    private $ballotIterator;

    /** @var int[] */
    protected  $countByCandidate = array();

    /** @var int[] */
    protected $countBySigner = array();

    /** @var int[][] */
    protected $matrix = array();

    /** @var int  */
    protected $invalidNum = 0;

    /** @var IvsException[] */
    protected $errors = array();

    /**
     * @param IBallotFactory $ballotFactory
     * @param IBallotIterator|IPackedBallot[] $ballotIterator
     */
    public function __construct($ballotFactory, $ballotIterator) {
        $this->ballotFactory = $ballotFactory;
        $this->ballotIterator = $ballotIterator;
    }

    public function start() {
        foreach($this->ballotIterator as $packedBallot) {
            $error = null;
            try {
                $ballot = $this->ballotFactory->unpackBallot($packedBallot);
                if (! $ballot->isVerified()) {
                    throw new BallotException(BallotException::NOT_VERIFIED);
                }
            } catch (IvsException $e) {
                $error = $e;
                $ballot = null;
            }

            if ($ballot) {
                $this->processBallot($ballot);
            } else {
                $this->processError($error);
            }
        }
    }

    /**
     * @param IBallot $ballot
     */
    protected function processBallot($ballot) {
        $cid = $ballot->getCandidate()->getId();
        $sid = $ballot->getSigner()->getId();

        if (!isset($this->countByCandidate[$cid])) {
            $this->countByCandidate[$cid] = 0;
            $this->matrix[$cid] = array($sid => 0);
        }

        if (!isset($this->countBySigner[$sid])) {
            $this->countBySigner[$sid] = 0;
        }

        if (!isset($this->matrix[$cid][$sid])) {
            $this->matrix[$cid][$sid] = 0;
        }

        $this->countByCandidate[$cid]++;
        $this->countBySigner[$sid]++;
        $this->matrix[$cid][$sid]++;
    }

    /**
     * @param IvsException $error
     */
    protected function  processError($error) {
        $this->invalidNum++;
        $this->errors[] = $error;
    }

    /**
     * @param null $candidateId
     * @param null $signerId
     * @return int|int[][]
     */
    public function getNum($candidateId = null, $signerId = null) {
        if ($candidateId == null && $signerId == null) {
            return $this->matrix;
        }
        elseif ($signerId == null ) {
            return $this->countByCandidate[$candidateId];
        }
        else {
            return $this->countBySigner[$signerId];
        }

    }

    /**
     * @param $candidateId
     * @return number
     */
    public function getNumByCandidateId($candidateId) {
        return $this->countByCandidate[$candidateId];
    }

    /**
     * @param $signerId
     * @return number
     */
    public function getNumBySignerId($signerId) {
        return $this->countBySigner[$signerId];
    }


    public function getInvalidBallotNum() {
        return $this->invalidNum;
    }

    public function getErrors() {
        return $this->errors;
    }
}