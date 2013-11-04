<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 8:17 PM
 */

namespace org\haf\ivs\ballot;


use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;

interface IBallotSigner
{

    /**
     * @return string
     */
    public function getId();

    /**
     * @return IPrivateKey
     */
    public function getPrivateKey();

    /**
     * @return IPublicKey
     */
    public function getPublicKey();
}