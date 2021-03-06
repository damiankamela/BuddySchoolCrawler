<?php

namespace Tests\App\Service\WebContent\Request;

use App\Service\WebContent\Request\RequestBuilder;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function should_build_post_request_with_valid_parameters()
    {
        $method = 'POST';
        $uri = 'mysite.com';
        $parameters = [
            'foo' => 'bar'
        ];

        $request = new RequestBuilder($method, $uri, $parameters);

        $request->setParameters(['bar' => 'baz']);
        $request->setParameter('abc', 123);

        $this->assertEquals([
            'bar' => 'baz',
            'abc' => 123
        ], $request->getParameters());

        $this->assertEquals('mysite.com', $request->getUri());
    }

    /**
     * @test
     */
    public function should_build_get_request_with_valid_uri()
    {
        $method = 'GET';
        $uri = 'mysite.com';
        $parameters = [
            'foo' => 'bar'
        ];

        $request = new RequestBuilder($method, $uri, $parameters);

        $request->setParameters(['bar' => 'baz']);
        $request->setParameter('abc', 123);
        $request->setParameter('xyz', '');

        $this->assertEquals([], $request->getParameters());
        $this->assertEquals('mysite.com?bar=baz&abc=123&xyz=', $request->getUri());
    }
}

