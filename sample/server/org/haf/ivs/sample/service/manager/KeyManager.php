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
    private $keyDir = '/media/data/ivs/key';

    private function getKeyFileName($keyType, $objectType, $objectId) {
        return "{$this->keyDir}/{$objectType}/{$objectId}-{$keyType}.pem";
    }


    /**
     * @param string $signerId
     * @return IPrivateKey
     */
    public function getSignerPrivateKey($signerId)
    {
        if (file_exists($file = $this->getKeyFileName('privkey', 'signer', $signerId)))
            return new RsaPrivateKey($file);
        else
            return null;
    }

    /**
     * @param string $signerId
     * @return IPublicKey
     */
    public function getSignerPublicKey($signerId)
    {
        if (file_exists($file = $this->getKeyFileName('pubkey', 'signer', $signerId)))
            return new RsaPublicKey($file);
        else
            return null;
    }

    /**
     * @param $electionId
     * @return IPrivateKey
     */
    public function getElectionPrivateKey($electionId)
    {
        if (file_exists($file = $this->getKeyFileName('privkey', 'election', $electionId)))
            return new RsaPrivateKey($file);
        else
            return null;
    }

    /**
     * @param $electionId
     * @return IPublicKey
     */
    public function getElectionPublicKey($electionId)
    {
        if (file_exists($file = $this->getKeyFileName('pubkey', 'election', $electionId)))
            return new RsaPublicKey($file);
        else
            return null;
    }
}