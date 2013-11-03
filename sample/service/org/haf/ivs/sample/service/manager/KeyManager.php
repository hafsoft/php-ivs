<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 10:40 AM
 */

namespace org\haf\ivs\sample\service\manager;


use org\haf\ivs\AbstractManager;
use org\haf\ivs\key\IKeyManager;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;
use org\haf\ivs\key\RsaPrivateKey;
use org\haf\ivs\key\RsaPublicKey;

class KeyManager extends AbstractManager implements IKeyManager {
    private $keyDir;

    private function getKeyFileName($keyType, $objectType, $objectId) {
        return "{$this->keyDir}/{$objectType}/{$objectId}-{$keyType}.key";
    }


    /**
     * @param string $signerId
     * @return IPrivateKey
     */
    public function getSignerPrivateKey($signerId)
    {
        return new RsaPrivateKey($this->getKeyFileName('private', 'signer', $signerId));
    }

    /**
     * @param string $signerId
     * @return IPublicKey
     */
    public function getSignerPublicKey($signerId)
    {
        return new RsaPublicKey($this->getKeyFileName('public', 'signer', $signerId));
    }

    /**
     * @param $electionId
     * @return IPrivateKey
     */
    public function getElectionPrivateKey($electionId)
    {
        return new RsaPrivateKey($this->getKeyFileName('private', 'election', $electionId));
    }

    /**
     * @param $electionId
     * @return IPublicKey
     */
    public function getElectionPublicKey($electionId)
    {
        return new RsaPublicKey($this->getKeyFileName('public', 'election', $electionId));
    }
}