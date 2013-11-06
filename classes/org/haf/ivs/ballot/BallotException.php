<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 1:19 PM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\IvsException;

class BallotException extends IvsException
{
    const CANDIDATE_NOT_FOUND = 'ballot:candidateNotFound';
    const ELECTION_NOT_FOUND  = 'ballot:electionNotFound';
    const INVALID_STRING      = 'ballot:invalidString';
    const NOT_VERIFIED = 'ballot:notVerified';
}