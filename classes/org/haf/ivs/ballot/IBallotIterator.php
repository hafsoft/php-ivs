<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:18 AM
 */

namespace org\haf\ivs\ballot;

interface IBallotIterator extends \Iterator
{

    /**
     * @return IPackedBallot
     */
    public function current();

    /** @return IPackedBallot */
    public function next();

}