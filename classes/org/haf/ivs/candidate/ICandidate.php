<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:15 AM
 */

namespace org\haf\ivs\candidate;

use org\haf\ivs\election\IElection;
use org\haf\ivs\IObject;

interface ICandidate extends IObject
{

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getPhoto();

    /**
     * @return mixed
     */
    public function getInfo();

    /**
     * @return IElection
     */
    public function getElection();

    /**
     * todo: remove it. how?
     *
     * @param IElection $election
     */
    public function setElection(&$election);
}