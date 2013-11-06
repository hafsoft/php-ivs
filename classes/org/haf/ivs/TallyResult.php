<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/5/13 11:40 AM
 */

namespace org\haf\ivs;


use org\haf\ivs\ballot\BallotException;
use org\haf\ivs\ballot\IBallot;
use org\haf\ivs\ballot\IBallotFactory;
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IPackedBallot;

class TallyResult {

    /** @var number[] */
    private $countByCandidate = array();

    /** @var number[] */
    private $countBySigner = array();

    /** @var number[][] */
    private $matrix = array();

    private $invalidNum = 0;

    private $errors = array();

    /**
     * @param IBallotFactory $ballotFactory
     * @param IBallotIterator|IPackedBallot[] $ballotIterator
     */
    public function __construct($ballotFactory, $ballotIterator) {
        foreach($ballotIterator as $packedBallot) {
            $error = null;
            try {
                $ballot = $ballotFactory->unpackBallot($packedBallot);
                if (! $ballot->isVerified()) {
                    throw new BallotException(BallotException::NOT_VERIFIED);
                }
            } catch (BallotException $e) {
                $error = $e;
                $ballot = null;
            }

            if ($ballot && $ballot->isVerified()) {
                $this->processBallot($ballot);
            } else {
                $this->invalidNum++;
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

    /**
     * @param $candidateId
     * @param $signerId
     * @return number
     */
    public function getNum($candidateId, $signerId) {
        return $this->matrix[$candidateId][$signerId];
    }

    public function getInvalidBallotNum() {
        return $this->invalidNum;
    }
}