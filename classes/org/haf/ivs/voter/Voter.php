<?php
namespace org\haf\ivs\voter;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\Object;

/**
 * Description of DefaultVoter
 *
 * @author abie
 */
class Voter extends Object implements IVoter
{
    /** @var string */
    protected $sessionId;

    /** @var string */
    protected $name;

    /** @var array */
    protected $info;

    /** @var IElection[] */
    protected $elections = null;

    /** @var string[] */
    protected $electionIds = array();

    /**
     * @param \org\haf\ivs\election\IElection[] $elections
     */
    public function setElections($elections)
    {
        $this->elections = $elections;
    }

    /**
     * @return \org\haf\ivs\election\IElection[]
     */
    public function getElections()
    {
        if ($this->elections === null) {
            $result   = array();
            $idsToGet = array();

            $i = 0;
            foreach ($this->electionIds as $id) {
                $election = Ivs::$instance->getCache()->get('election:' . $id);
                if ($election === null) {
                    $idsToGet[$id] = $i;
                    $result[]      = $id;
                } else {
                    $result[] = $election;
                }

                $i++;
            }

            if ($idsToGet) {
                $gottenElections = Ivs::$instance->getElectionManager()->getFromIds(array_keys($idsToGet));
                foreach ($gottenElections as $election) {
                    $result[$idsToGet[$election->getId()]] = $election;
                }
            }

            $this->elections = $result;
        }
        return $this->elections;
    }

    /**
     * @param array $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param \string[] $election_ids
     */
    public function setElectionIds($election_ids)
    {
        $this->electionIds = $election_ids;
    }

    /**
     * @return \string[]
     */
    public function getElectionIds()
    {
        return $this->electionIds;
    }

    public function getProperties()
    {
        $properties = parent::getProperties();
        if (Ivs::$instance->isRemoteCall())
            unset($properties['elections']);
        return $properties;
    }

}
