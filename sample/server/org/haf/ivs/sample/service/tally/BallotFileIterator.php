<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/4/13 10:07 AM
 */

namespace org\haf\ivs\sample\service\tally;


use org\haf\ivs\ballot\BallotException;
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IPackedBallot;
use org\haf\ivs\ballot\PackedBallot;

class BallotFileIterator implements IBallotIterator {
    private $directory;
    private $hDir;
    private $curFileName;
    private $curPackedBallot;

    /**
     * @param string $directory
     */
    public function __construct($directory) {
        $this->directory = $directory;
        $this->hDir = opendir($directory);
        $this->next();
    }

    /**
     * close dir
     */
    public function __destruct() {
        closedir($this->hDir);
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->curFileName;
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->curFileName != FALSE;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @throws \org\haf\ivs\ballot\BallotException
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {

    }

    /**
     * @return IPackedBallot
     */
    public function current()
    {
        return $this->curPackedBallot;
    }

    /** @return IPackedBallot */
    public function &next()
    {
        do {
            $this->curFileName = readdir($this->hDir);
        } while (in_array($this->curFileName, array('.', '..')));
        $this->readBallot();
        return $this->curPackedBallot;
    }

    private function readBallot() {
        if ($this->valid()) {
            $data = json_decode(file_get_contents("{$this->directory}/{$this->curFileName}"), TRUE);
            $this->curPackedBallot = new PackedBallot(
                $data['e'], $data['s'], $data['d'], $data['v']
            );
        } else {
            $this->curPackedBallot = null;
        }
    }
}