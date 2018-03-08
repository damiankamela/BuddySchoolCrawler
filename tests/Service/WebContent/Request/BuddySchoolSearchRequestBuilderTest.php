<?php

namespace Tests\App\Service\WebContent\Request;

use App\Service\WebContent\Request\BuddySchoolSearchRequestBuilder;
use PHPUnit\Framework\TestCase;

class BuddySchoolSearchRequestBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function should_build_get_search_keyword_request()
    {
        $request = new BuddySchoolSearchRequestBuilder('GET', 'http://www.acme.com');

        $keyword = 'foo';
        $this->assertEquals('http://www.acme.com?keyword=foo', $request->searchUrl($keyword));
    }
}
