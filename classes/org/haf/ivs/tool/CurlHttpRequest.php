<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 12:56 PM
 */

namespace org\haf\ivs\tool;


class CurlHttpRequest implements IHttpRequest
{
    /** @var null|resource */
    private $handler = null;

    private $headers = array();

    public function __construct()
    {
        $this->handler = curl_init();
    }

    /**
     * @param string $method
     * @param string $url
     * @return bool
     */
    public function open($method, $url)
    {
        $options = array(
            CURLOPT_HEADER         => 0,
            CURLOPT_URL            => $url,
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_TIMEOUT        => 120,
        );

        switch (strtolower($method)) {
            case 'post':
                $options[CURLOPT_POST] = true;
                break;

        }
        return curl_setopt_array($this->handler, $options);
    }

    /**
     * @param $name
     * @param $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[] = "$name: $value";
    }

    /**
     * @param string $data
     * @throws \Exception
     * @return string
     */
    public function send($data = null)
    {
        if (count($this->headers) > 0) {
            curl_setopt($this->handler, CURLOPT_HTTPHEADER, $this->headers);
        }
        if ($data) {
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $data);
        }
        if ($result = curl_exec($this->handler)) {
            return $result;
        } else {
            $error = curl_error($this->handler);
            $errNo = curl_errno($this->handler);
            throw new \Exception($error, $errNo);
        }
    }


    /**
     * close connection
     */
    public function close()
    {
        curl_close($this->handler);
    }

    /**
     * @param $name
     * @param $value
     */
    public function replaceHeader($name, $value)
    {
        // TODO: Implement replaceHeader() method.
    }
}