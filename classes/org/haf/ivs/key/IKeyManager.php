<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:34 AM
 */

namespace org\haf\ivs\key;

use org\haf\ivs\IManager;

interface IKeyManager extends IManager
{
    /**
     * @param string $signerId
     * @return IPrivateKey|null
     */
    public function getSignerPrivateKey($signerId);

    /**
     * @param string $signerId
     * @return IPublicKey|null
     */
    public function getSignerPublicKey($signerId);

    /**
     * @param $electionId
     * @return IPrivateKey|null
     */
    public function getElectionPrivateKey($electionId);

    /**
     * @param $electionId
     * @return IPublicKey|null
     */
    public function getElectionPublicKey($electionId);

}