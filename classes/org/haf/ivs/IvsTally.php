<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/4/13 1:35 PM
 */

namespace org\haf\ivs;


use org\haf\ivs\ballot\BallotFactory;
use org\haf\ivs\ballot\IBallot;
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IPackedBallot;
use org\haf\ivs\election\IElection;
use org\haf\ivs\voter\IVoter;

abstract class IvsTally extends Ivs {

    /**
     * @return IVoter
     */
    public function getCurrentVoter()
    {
        return null;
    }

    public function startCounting(IElection $election) {
        $factory = new BallotFactory($election);
        $iterator = $this->getBallotManager()->getIteratorByElection($election);

        foreach($iterator as $packedBallot) {
            /** @var IPackedBallot $packedBallot */
            $ballot = $factory->unpackBallot($packedBallot);
            $this->processBallot($ballot);
        }
    }

    /**
     * @param IBallot $ballot
     */
    abstract protected function processBallot($ballot);
}