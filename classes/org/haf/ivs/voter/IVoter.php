<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace org\haf\ivs\voter;
use org\haf\ivs\election\IElection;
use org\haf\ivs\IObject;

/**
 *
 * @author abie
 */
interface IVoter extends IObject
{

    /**
     * @return string the session id
     */
    public function getSessionId();

    /**
     * return the name of the voter
     *
     * @return string name of te voter
     */
    public function getName();

    /**
     * return array of information of the voter
     *
     * @return array information
     */
    public function getInfo();

    /**
     * @return IElection[]
     */
    public function getElections();
}
