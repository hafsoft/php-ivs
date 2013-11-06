<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/4/13 10:19 AM
 */

namespace org\haf\ivs\sample\service;

use org\haf\ivs\ballot\IBallot;
use org\haf\ivs\Ivs;
use org\haf\ivs\IvsTally;

class SampleTally extends IvsTally
{
    private $result = array();
    private $notValidNum;

    public function countElection($election) {
        $result = array();
        foreach($election->getCandidates() as $c) {
            $result[$c->getId()] = array();
        }
        $this->result = $result;
        $this->notValidNum = 0;
        return parent::countElection($election);
    }

    /**
     * @param IBallot $ballot
     */
    protected function processBallot($ballot)
    {
        if ($ballot->isVerified()) {
            $cid = $ballot->getCandidate()->getId();
            $sid = $ballot->getSigner()->getId();
            if (! isset($this->result[$cid][$sid])) {
                $this->result[$cid][$sid] = 1;
            } else {
                $this->result[$cid][$sid] += 1;
            }
            echo sprintf("\"%s\" signed by %s\n", $ballot->getCandidate()->getName(), $ballot->getSigner()->getId());
        }
        else {
            $this->notValidNum++;
        }
    }

    public function getResult() {
        return
    }
}