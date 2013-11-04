<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:09 AM
 */

namespace org\haf\ivs\voteBooth;

use org\haf\ivs\ballot\IBallot;
use org\haf\ivs\ballot\IBallotSigner;
use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\IObject;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;

interface IVoteBooth extends IObject, IBallotSigner
{
    /**
     * @return string
     */
    public function getId();
}