<?php

namespace Tests\AppBundle\Service\Crawler;

use AppBundle\Service\Crawler\BuddySchoolProfileFetcher;
use AppBundle\Service\Crawler\Exception\NoResultsException;
use AppBundle\Service\Crawler\Exception\ProfileNotFoundException;
use AppBundle\Service\WebContent\Request\BuddySchoolSearchRequestBuilder;
use AppBundle\Service\WebContent\WebContentProviderInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class BuddySchoolProfileFetcherTest extends TestCase
{
    /** @var BuddySchoolProfileFetcher */
    protected $profileFetcher;

    /** @var WebContentProviderInterface|Mock */
    protected $contentProviderMock;

    /** @var BuddySchoolSearchRequestBuilder|Mock */
    protected $requestBuilderMock;

    /** @var string */
    protected $profileLinkHtml =
        '<div class="profileMainTitle"><a href="http://www.acme.com/profile/baz">Link</a></div>';

    /** @var string */
    protected $profileSectionHtml = '<div id="profile">bar</div>';

    public function setUp()
    {
        $this->contentProviderMock = $this->getMockBuilder(WebContentProviderInterface::class)->getMock();
        $this->requestBuilderMock = $this->getMockBuilder(BuddySchoolSearchRequestBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->profileFetcher = new BuddySchoolProfileFetcher($this->contentProviderMock, $this->requestBuilderMock);

        $this->profileFetcher->setBaseUrl('http://www.acme.com/profile');
    }

    /**
     * @test
     */
    public function should_fetch_valid_profile_section_content()
    {
        $keyword = 'foo';
        $position = 1;

        $this->requestBuilderMock
            ->expects(self::once())
            ->method('searchUrl')
            ->with($keyword)
            ->willReturn('http://www.acme.com/search?keyword=foo');

        $this->contentProviderMock
            ->expects(self::exactly(2))
            ->method('getContent')
            ->willReturnCallback(function ($url) {
                switch ($url) {
                    case 'http://www.acme.com/search?keyword=foo':
                        return $this->profileLinkHtml . $this->profileLinkHtml;
                    case 'http://www.acme.com/profile/baz':
                        return $this->profileSectionHtml;
                    default: return '';
                }
            });

        $this->assertEquals('bar', $this->profileFetcher->getProfileContent($keyword, $position));
    }

    /**
     * @test
     */
    public function should_throw_exception_found_one_profile_try_fetch_second()
    {
        $keyword = 'foo';
        $position = 1;

        $this->requestBuilderMock
            ->expects(self::once())
            ->method('searchUrl')
            ->with($keyword)
            ->willReturn('http://www.acme.com/search?keyword=foo');

        $this->contentProviderMock
            ->expects(self::once())
            ->method('getContent')
            ->with('http://www.acme.com/search?keyword=foo')
            ->willReturn($this->profileLinkHtml);

        $this->expectException(ProfileNotFoundException::class);

        $this->assertEquals('bar', $this->profileFetcher->getProfileContent($keyword, $position));
    }

    /**
     * @test
     */
    public function should_throw_exception_because_no_results()
    {
        $keyword = 'foo';
        $position = 1;

        $this->requestBuilderMock
            ->expects(self::once())
            ->method('searchUrl')
            ->with($keyword)
            ->willReturn('http://www.acme.com/search?keyword=foo');

        $this->contentProviderMock
            ->expects(self::once())
            ->method('getContent')
            ->with('http://www.acme.com/search?keyword=foo')
            ->willReturn('');

        $this->expectException(NoResultsException::class);

        $this->assertEquals('bar', $this->profileFetcher->getProfileContent($keyword, $position));
    }
}
