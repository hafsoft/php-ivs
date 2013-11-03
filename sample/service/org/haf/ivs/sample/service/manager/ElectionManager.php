<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 1:59 PM
 */

namespace org\haf\ivs\sample\service\manager;


use org\haf\ivs\AbstractManager;
use org\haf\ivs\election\IElection;
use org\haf\ivs\election\IElectionManager;

class ElectionManager extends AbstractManager implements IElectionManager {
    private static $elections = array(
        1 => array(
            'name' => 'Election 1',
            'candidates' => array(
                array(
                    'seq' => 1,
                    'name' => 'Candidate 1',
                    'photo_file' => 'dummy1.jpg',
                ),
                array(
                    'seq' => 2,
                    'name' => 'Candidate 2',
                    'photo_file' => 'dummy2.jpg',
                ),
                array(
                    'seq' => 3,
                    'name' => 'Candidate 3',
                    'photo_file' => 'dummy3.jpg',
                ),
            ),
        )
    );

    /**
     * @param string $id
     * @return IElection
     * @throw ElectionException
     */
    public function getFromId($id)
    {
        // TODO: Implement getFromId() method.
    }

    /**
     * @param string[] $ids
     * @return IElection[]
     */
    public function getFromIds($ids)
    {
        // TODO: Implement getFromIds() method.
    }
}