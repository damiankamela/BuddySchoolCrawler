<?php

namespace AppBundle\Service\WebContent;

use AppBundle\Service\WebContent\Exception\ClientException;
use AppBundle\Service\WebContent\Request\CurlRequest;
use Psr\Log\LoggerAwareTrait;

class CurlWebContentProvider implements WebContentProviderInterface
{
    use LoggerAwareTrait;

    /** @var CurlRequest */
    protected $curl;

    /**
     * @param string $url
     * @return string
     * @throws ClientException
     */
    public function getContent(string $url): string
    {
        $this->curl = $this->getClient($url);

        try {
            return $this->fetchContent();
        } catch (ClientException $exception) {
            $this->logger->critical(
                sprintf('Curl failed with error #%d: %s', $exception->getCode(), $exception->getMessage())
            );

            throw $exception;
        }
    }

    /**
     * @param string $url
     * @return CurlRequest
     */
    protected function getClient(string $url)
    {
       $curl = new CurlRequest($url);
       $curl->setOption(CURLOPT_RETURNTRANSFER, 1);

       return $curl;
    }

    /**
     * @return string
     * @throws ClientException
     */
    protected function fetchContent(): string
    {
        $content = $this->curl->execute();

        if (false === $content) {
            throw new ClientException($this->curl->getError(), $this->curl->getErrorNo());
        }

        return $content;
    }
}