<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 1:22 PM
 */

namespace org\haf\ivs\voteBooth;

use org\haf\ivs\IManager;

interface IVoteBoothManager extends IManager
{

    /**
     * @param string $id
     * @return IVoteBooth
     */
    public function getById($id);
}