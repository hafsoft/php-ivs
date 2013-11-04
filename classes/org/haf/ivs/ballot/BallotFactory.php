<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:01 AM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\key\IPublicKey;
use org\haf\ivs\tool\Security;
use org\haf\ivs\voteBooth\IVoteBooth;

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

        return new PackedBallot($this->election->getId(), $signer->getId(), $encryptedData, $signature);
    }

    /**
     * @param IPackedBallot $packedBallot
     * @throws BallotException
     * @return IBallot
     */
    public function unpackBallot($packedBallot)
    {
        $jsonData = $this->election->getPrivateKey()->decryptData($packedBallot->getEncryptedData());
        $data     = json_decode($jsonData, true);
        if ($this->election->getId() !== $packedBallot->getElectionId()) {
            // todo: benerin
            throw new BallotException(BallotException::ERROR_UNKNOWN);
        }
        $candidate = $this->election->getCandidateById($data['cid']);
        $signer    = $this->getCachedSigner($packedBallot->getSignerId());
        $verified  = $signer->getPublicKey()->verify($packedBallot->getEncryptedData(), $packedBallot->getSignature());

        $ballot = new Ballot($this->election, $candidate, $signer);
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