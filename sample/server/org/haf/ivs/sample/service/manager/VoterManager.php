<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 11:31 PM
 */

namespace org\haf\ivs\sample\service\manager;


use org\haf\ivs\AbstractManager;
use org\haf\ivs\Ivs;
use org\haf\ivs\tool\Security;
use org\haf\ivs\voter\IVoter;
use org\haf\ivs\voter\IVoterManager;
use org\haf\ivs\voter\Voter;
use org\haf\ivs\voter\VoterException;

class VoterManager extends AbstractManager implements IVoterManager {

    private static $voters = array(
        101 => array (
            'username' => 'user.1',
            'pass' => 'user.1',
            'name' => 'Uno',
            'info' => array('npm' => '1106014711'),
            'elections_id' => array(1, 2),
        ),

        102 => array (
            'username' => 'user.2',
            'pass' => 'user.2',
            'name' => 'Roro',
            'info' => array('npm' => '1106014722'),
            'elections_id' => array(1, 3),
        ),


        103 => array (
            'username' => 'abi.hafshin',
            'pass' => 'pass',
            'name' => 'Abi Hafshin',
            'info' => array('npm' => '1106014766'),
            'elections_id' => array(1, 4, 5),
        ),
    );


    /**
     * @return string[]
     */
    public function getAllowedMethods()
    {
        return array ('authenticate');
    }

    /**
     * @param string $method method for authenticate
     * @param array $authParam Description
     *
     * @return IVoter Description
     * @throws VoterException
     */
    public function authenticate($method, $authParam)
    {
        switch ($method) {
            case 'token':
                $id = $this->authenticateToken($authParam['username'], $authParam['password'], $authParam['token']);
                break;

            case 'smartCard':
                $id = $this->authenticateSmartCard($authParam['npm'], $authParam['secret']);
                break;

            default:
                throw new VoterException(VoterException::METHOD_NOT_SUPPORTED);
        }
        $params = self::$voters[$id];
        $voter = $this->getById($id);
        $voter->setSessionId($this->createSessionForId($id));
        return $voter;
    }

    /**
     * @param string $id
     * @return \org\haf\ivs\IObject|Voter
     */
    private function &getById($id) {
        $cache = $this->ivs->getCache();
        if (null === ($voter = $cache->fetchObject('voter', $id))) {
            $voter = $this->getByIdImpl($id);
            $cache->putObject('voter', $id, $voter);
        }
        return $voter;
    }

    /**
     * @param string $id
     * @return Voter
     */
    private function getByIdImpl($id) {
        $params = self::$voters[$id];
        $voter = new Voter();
        $voter->setName($params['name']);
        $voter->setElectionIds($params['elections_id']);
        $voter->setInfo($params['info']);
        return $voter;
    }

    /**
     * @param string $id
     * @return string
     */
    private function createSessionForId($id) {
        $salt = Security::generateSalt(5);
        $token = Security::generateSalt(5);
        $sid = "$id:$salt:$token";
        $cacheName = "ivs:session:$id:$salt";
        $hash = md5($sid);
        $this->ivs->getCache()->set($cacheName, $hash);
        return $sid;
    }

    /**
     * @param $userName
     * @param $password
     * @param $token
     * @throws \org\haf\ivs\voter\VoterException
     * @return int|string ada
     */
    private function authenticateToken($userName, $password, $token) {
        foreach (self::$voters as $id => $voter) {
            if ($voter['username'] === $userName && $voter['pass'] === $password) {
                if ($token == '12345') {
                    return $id;
                } else {
                    throw new VoterException('voter:invalidToken', 'Invalid Token');
                }
            }
        }
        throw new VoterException(VoterException::WRONG_USER_NAME_PASSWORD, 'Wrong User Name or Password');
    }

    /**
     * @param $npm
     * @param $secret
     * @return int|string
     * @throws VoterException
     */
    private function authenticateSmartCard($npm, $secret) {
        foreach (self::$voters as $id => $voter) {
            if ($voter['info']['npm'] === $npm) {
                return $id;
            }
        }
        throw new VoterException('voter:invalidSmartCard', 'Invalid Smart Card');
    }

    /**
     * @param string $sessionId Description
     *
     * @return IVoter Description
     * @throws VoterException
     */
    public function &getFromSessionId($sessionId)
    {
        list($id, $salt, $token) = explode(':', $sessionId);
        $cacheName = "ivs:session:$id:$salt";
        $hash = $this->ivs->getCache()->get($cacheName);
        if ($hash === md5($sessionId)) {
            $voter = $this->getById($id);
            $voter->setSessionId($sessionId);
            return $voter;
        }
        throw new VoterException(VoterException::ACCESS_DENIED);
    }

    /**
     * @param string $sessionId Description
     *
     * @return boolean
     * @throws VoterException
     */
    public function logout($sessionId)
    {
        list($id, $salt, $token) = explode(':', $sessionId);
        $cacheName = "ivs:session:$id:$salt";
        $this->ivs->getCache()->remove($cacheName);
    }
}