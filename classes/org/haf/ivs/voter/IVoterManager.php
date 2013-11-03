<?php

namespace org\haf\ivs\voter;
use org\haf\ivs\IManager;

/**
 *
 * @author abie
 */
interface IVoterManager extends IManager
{

    /**
     * @param string $method method for authenticate
     * @param array $authParam Description
     *
     * @return IVoter Description
     * @throws VoterException
     */
    public function authenticate($method, $authParam);

    /**
     * @param string $sessionId Description
     *
     * @return IVoter Description
     * @throws VoterException
     */
    public function getFromSessionId($sessionId);

    /**
     * @param string $sessionId Description
     *
     * @return boolean
     * @throws VoterException
     */
    public function logout($sessionId);

}
