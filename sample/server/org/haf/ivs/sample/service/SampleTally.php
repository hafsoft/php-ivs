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

class SampleTally extends IvsTally {

    /**
     * @param IBallot $ballot
     */
    protected function processBallot($ballot)
    {
        echo sprintf("\"%s\" signed by %s\n", $ballot->getCandidate()->getName(), $ballot->getSigner()->getId());
    }
}