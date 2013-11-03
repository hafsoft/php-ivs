<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace org\haf\ivs\election;
use org\haf\ivs\candidate\CandidateException;
use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\IObject;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;


/**
 *
 * @author abie
 */
interface IElection extends IObject
{

    /**
     * @return string
     */
    public function getId();

    /**
     * return the name of the service
     *
     * @return string Description
     */
    public function getName();

    /**
     * @return ICandidate[]
     * @throws CandidateException
     */
    public function getCandidates();

    /**
     * @param string $id
     * @return ICandidate
     * @throws CandidateException
     */
    public function getCandidateById($id);

    /**
     * the private key for counting bullet
     *
     * @return IPrivateKey
     */
    public function getPrivateKey();

    /**
     * @return IPublicKey key for encrypting bullet
     */
    public function getPublicKey();

}
