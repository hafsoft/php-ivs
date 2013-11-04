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
use org\haf\ivs\voteBooth\VoteBoothException;

class VoteBoothManager extends AbstractManager implements IVoteBoothManager {

    /**
     * @param string $id
     * @throws VoteBoothException
     * @return IVoteBooth
     */
    public function getById($id)
    {
        $voteBooth = new VoteBooth();
        $voteBooth->setId($id);

        if ($this->isRemoteCall()) {
            $privateKey = $this->ivs->getKeyManager()->getSignerPrivateKey($id);
            if ($privateKey) {
                $voteBooth->setPrivateKey($privateKey);
                return $voteBooth;
            } else {
                throw new VoteBoothException(VoteBoothException::NOT_FOUND, 'Vote Booth "%s" not found', $id);
            }
        }
        return $voteBooth;
    }

    public function getAllowedMethods() {
        return array('getById');
    }
}