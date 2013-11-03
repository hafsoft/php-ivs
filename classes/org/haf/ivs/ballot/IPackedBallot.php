<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 9:39 AM
 */

namespace org\haf\ivs\ballot;


use org\haf\ivs\IObject;

interface IPackedBallot extends IObject
{
    /**
     * @return IBallot
     */
    public function unpack();

    /**
     * @return string
     */
    public function getSignature();

    /**
     * @return string
     */
    public function getSignerId();

    /**
     * @return string
     */
    public function getElectionId();

    /**
     * @return string
     */
    public function getEncryptedData();
}