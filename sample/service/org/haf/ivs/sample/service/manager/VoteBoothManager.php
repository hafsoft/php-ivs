<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 10:21 AM
 */

namespace org\haf\ivs\sample\service\manager;


use org\haf\ivs\AbstractManager;
use org\haf\ivs\voteBooth\IVoteBooth;
use org\haf\ivs\voteBooth\IVoteBoothManager;
use org\haf\ivs\voteBooth\VoteBooth;

class VoteBoothManager extends AbstractManager implements IVoteBoothManager {

    /**
     * @param string $id
     * @return IVoteBooth
     */
    public function getById($id)
    {
        $voteBooth = new VoteBooth();
        $voteBooth->setId($id);

        if ($this->ivs->isRemoteCall()) {
            $privateKey = $this->ivs->getKeyManager()->getSignerPrivateKey($id);
            if ($privateKey) {
                $voteBooth->setPrivateKey($privateKey);
                return $voteBooth;
            }
        }
        return $voteBooth;
    }

    public function getAllowedMethods() {
        return array('getById');
    }
}