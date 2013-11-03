<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace org\haf\ivs\election;
use org\haf\ivs\IManager;

/**
 *
 * @author abie
 */
interface IElectionManager extends IManager
{
    /**
     * @param string $id
     * @return IElection
     * @throw ElectionException
     */
    public function getFromId($id);

    /**
     * @param string[] $ids
     * @return IElection[]
     */
    public function getFromIds($ids);
}
