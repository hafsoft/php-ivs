<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 1:16 PM
 */

namespace org\haf\ivs;

class IvsException extends \Exception implements IObject
{
    const ERROR_UNKNOWN        = 'ivs:unknown';
    const INVALID_REQUEST      = 'ivs:invalidRequest';
    const METHOD_NOT_SUPPORTED = 'ivs:methodNotSupported';
    const ACCESS_DENIED        = 'ivs:accessDenied';
    const MANAGER_NOT_DEFINED  = 'ivs:managerNotDefined';
    const PROPERTY_NOT_FOUND   = 'ivs:propertyNotFound';
    const UNKNOWN_CLASS        = 'ivs:unknownClass';


    private $errorCode;
    private $errorDetails;

    /**
     * @param string $errorCode
     * @param null|string $errorDetails
     */
    public function __construct($errorCode = self::ERROR_UNKNOWN, $errorDetails = null)
    {
        $this->errorCode    = $errorCode;
        $this->errorDetails = $errorDetails;
        $this->message      = "ERROR: {$errorCode} {$errorDetails}";
        $this->code         = 99;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return mixed
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }


    /**
     * @return mixed
     */
    public function toArray()
    {
        if (defined('DEBUG')) {
            return array(
                '__exception__' => str_replace('\\', '.', get_class($this)),
                '__code'        => $this->errorCode,
                '__detail'      => $this->errorDetails,
                '__debug'       => array(
                    'file'  => $this->getFile(),
                    'line'  => $this->getLine(),
                    'trace' => $this->getTrace(),
                ),
            );
        }
        return array(
            '__exception__' => str_replace('\\', '.', get_class($this)),
            '__code'        => $this->errorCode,
            '__detail'      => $this->errorDetails
        );
    }

    private function setAdditionalInfo($info)
    {
        $this->file = $info['file'];
        $this->line = $info['line'];
        //$this->
    }

    /**
     * @param mixed $array
     * @throws \Exception
     * @return IvsException
     */
    public static function fromArray($array)
    {
        $className = str_replace('.', '\\', $array['__exception__']);
        if ($className === 'org\haf\ivs\IvsException' || is_subclass_of($className, 'org\haf\ivs\IvsException')) {
            /** @var IvsException $err */
            $err = new $className($array['__code'], $array['__detail']);
            if (isset($array['__debug'])) {
                $err->setAdditionalInfo($array['__debug']);
            }

            return $err;
        }
        throw new \Exception("Unable to read Exception: $className");
    }
}