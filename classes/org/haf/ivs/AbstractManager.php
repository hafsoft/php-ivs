<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 3:09 PM
 */

namespace org\haf\ivs;


abstract class AbstractManager implements IManager
{
    /** @var Ivs */
    protected $ivs;

    /** @var mixed|null */
    protected $config;

    /**
     * @param Ivs $parent
     * @param null|mixed $config
     */
    public function __construct($parent, $config = null)
    {
        $this->ivs    = $parent;
        $this->config = $config;
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods()
    {
        return array();
    }

    public function isMethodAllowed($methodName)
    {
        $allowedMethod = $this->getAllowedMethods();
        if (isset($allowedMethod[$methodName])) {
            $role = $allowedMethod[$methodName];
            if (is_string($role)) {
                if ($role === '*') return true;
                // TODO: lanjutin
            }
        } elseif (in_array($methodName, $allowedMethod)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    protected function isClient()
    {
        return is_a($this->ivs, 'ivs\IvsClient');
    }
}