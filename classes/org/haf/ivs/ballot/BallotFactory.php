<?php
/**
 * HafSoft Integrated Voting System
 * Copyright (c) 2013 Abi Hafshin Alfarouq
 * < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for HafSoft Integrated Voting System.
 * more info: http://github.com/hafsoft/php-ivs
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\key\IPublicKey;
use org\haf\ivs\tool\Security;
use org\haf\ivs\voteBooth\IVoteBooth;

/**
 * Class BallotFactory
 *
 * @package org\haf\ivs\ballot
 */
class BallotFactory implements IBallotFactory
{
    /** @var  IElection */
    private $election;

    /** @var IBallotSigner[] */
    private $signers = array();

    /**
     * @param IElection $election
     */
    public function __construct($election) {
        $this->election =& $election;
    }

    /**
     * @param ICandidate $candidate
     * @param IBallotSigner $signer
     * @return IBallot
     */
    public function createBallot($candidate, $signer)
    {
        return new Ballot($this->election, $candidate, $signer);
    }

    /**
     * @param IBallot $ballot
     * @return IPackedBallot
     */
    public function packBallot($ballot)
    {
        $candidate = $ballot->getCandidate();
        $signer = $ballot->getSigner();

        $json_data     = json_encode(array(
            'cid'  => $candidate->getId(),
            'eid'  => $this->election->getId(),
            'salt' => Security::generateSalt(32),
        ));
        $encryptedData = $this->election->getPublicKey()->encryptData($json_data);
        $signature     = $signer->getPrivateKey()->sign($encryptedData);

        return new PackedBallot(
            $this->election->getId(), $signer->getId(), $encryptedData, $signature, $ballot->getExtendedInfo()
        );
    }


    /**
     * @param IBallot[] $ballots
     * @return IPackedBallot[]
     */
    public function packBallots($ballots) {
        $packedBallots = array();
        foreach($ballots as $ballot) {
            $packedBallots[] = $this->packBallot($ballot);
        }
        return $packedBallots;
    }

    /**
     * @param IPackedBallot $packedBallot
     * @throws BallotException
     * @return IBallot
     */
    public function unpackBallot($packedBallot)
    {
        $key = $this->election->getPrivateKey();
        $jsonData = $key->decryptData($packedBallot->getEncryptedData());
        $data     = json_decode($jsonData, true);
        if ($this->election->getId() != $packedBallot->getElectionId()) {
            // todo: benerin
            throw new BallotException(BallotException::ERROR_UNKNOWN);
        }
        $candidate = $this->election->getCandidateById($data['cid']);
        $signer    = $this->getCachedSigner($packedBallot->getSignerId());
        $verified  = $signer->getPublicKey()->verify($packedBallot->getEncryptedData(), $packedBallot->getSignature());

        $ballot = new Ballot($this->election, $candidate, $signer, $packedBallot->getExtendedInfo());
        $ballot->setVerified($verified);
        return $ballot;
    }

    /**
     * @param $signerId
     * @return IBallotSigner
     */
    private function  &getCachedSigner($signerId) {
        if (! isset($this->signers[$signerId])) {
            $this->signers[$signerId] = Ivs::app()->getVoteBothManager()->getById($signerId);
        }
        return $this->signers[$signerId];
    }
}