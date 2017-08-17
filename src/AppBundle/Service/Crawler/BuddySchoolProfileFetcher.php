<?php

namespace AppBundle\Service\Crawler;

use AppBundle\Service\Crawler\Exception\NoResultsException;
use AppBundle\Service\Crawler\Exception\ProfileNotFoundException;
use AppBundle\Service\WebContent\Request\BuddySchoolSearchRequestBuilder;
use AppBundle\Service\WebContent\WebContentProviderInterface;
use Symfony\Component\DomCrawler\Crawler;

class BuddySchoolProfileFetcher
{
    /** @var WebContentProviderInterface */
    protected $contentProvider;

    /** @var BuddySchoolSearchRequestBuilder */
    protected $requestBuilder;

    /** @var string */
    protected $baseUrl;

    /**
     * @param WebContentProviderInterface     $contentProvider
     * @param BuddySchoolSearchRequestBuilder $requestBuilder
     */
    public function __construct(
        WebContentProviderInterface $contentProvider,
        BuddySchoolSearchRequestBuilder $requestBuilder
    ) {
        $this->contentProvider = $contentProvider;
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $keyword
     * @param int    $position
     * @return string
     */
    public function getProfileContent(string $keyword, int $position = 0): string
    {
        $url = $this->fetchProfileUrl($keyword, $position);

        $content = $this->contentProvider->getContent($url);

        $crawler = new Crawler($content);

        return $crawler->filter('#profile')->text();
    }

    /**
     * @param string $keyword
     * @param int    $position
     * @return string
     * @throws NoResultsException
     * @throws ProfileNotFoundException
     */
    protected function fetchProfileUrl(string $keyword, int $position): string
    {
        $url = $this->requestBuilder->searchUrl($keyword);
        $content = $this->contentProvider->getContent($url);

        $crawler = new Crawler($content, $this->baseUrl);

        $links = $crawler->filter('.profileMainTitle > a')->links();

        if (empty($links)) {
            throw new NoResultsException();
        }

        if (!isset($links[$position])) {
            throw new ProfileNotFoundException(
                sprintf('Profile not found at %s position. Result has only %s positions', $position, count($links))
            );
        }

        return $links[$position]->getUri();
    }
}