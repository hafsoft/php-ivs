<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:22 AM
 */

namespace org\haf\ivs\candidate;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Object;


class Candidate extends Object implements ICandidate
{

    /** @var  IElection */
    protected $election;

    /** @var  $id */
    protected $id;

    /** @var  string */
    protected $name;

    /** @var  mixed */
    protected $info;

    /** @var  string */
    protected $photo;

    /**
     * @param \org\haf\ivs\election\IElection $election
     */
    public function setElection($election)
    {
        $this->election = $election;
    }

    /**
     * @return \org\haf\ivs\election\IElection
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return mixed
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
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}