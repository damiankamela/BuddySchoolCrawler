<?php

namespace AppBundle\Service\WebContent\Request;

class CurlRequest
{
    private $handle = null;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->handle = curl_init($url);
    }

    /**
     * @param string $name
     * @param        $value
     */
    public function setOption(string $name, string $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->handle);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getInfo(string $name)
    {
        return curl_getinfo($this->handle, $name);
    }

    /**
     *
     */
    public function close()
    {
        curl_close($this->handle);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return curl_error($this->handle);
    }

    /**
     * @return int
     */
    public function getErrorNo()
    {
        return curl_errno($this->handle);
    }
}