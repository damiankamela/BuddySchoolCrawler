<?php

namespace AppBundle\Service\WebContent;

class Request
{
    /** @var string */
    protected $method;

    /** @var string */
    protected $uri;

    /** @var array */
    protected $parameters;

    /** @var string */
    protected $baseUri;

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     */
    public function __construct(string $method, string $uri, array $parameters = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->baseUri = $uri;
        $this->parameters = $parameters;
        $this->build();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        $this->build();
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;
        $this->build();
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->uri = $this->baseUri;
        $this->parameters = $parameters;
        $this->build();
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setParameter(string $name, string $value)
    {
        $this->parameters[$name] = $value;
        $this->build();
    }

    protected function build()
    {
        if ('GET' === strtoupper($this->method)) {
            $this->uri = $this->normalizeUrl($this->uri, $this->parameters);
            $this->parameters = [];
        }
    }

    /**
     * @param string $url
     * @param array  $parameters
     * @return string
     */
    protected function normalizeUrl(string $url, array $parameters)
    {
        $normalizedUrl = $url;

        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($parameters, '', '&');
        }

        return $normalizedUrl;
    }
}