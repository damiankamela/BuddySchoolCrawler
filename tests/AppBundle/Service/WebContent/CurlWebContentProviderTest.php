<?php

namespace Tests\AppBundle\Service\WebContent;

use AppBundle\Service\WebContent\CurlWebContentProvider;
use AppBundle\Service\WebContent\Exception\ClientException;
use AppBundle\Service\WebContent\Request\CurlRequest;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;
use Psr\Log\LoggerInterface;

class CurlWebContentProviderTest extends TestCase
{
    /** @var CurlWebContentProvider|Mock */
    protected $providerMock;

    /** @var CurlRequest|Mock */
    protected $curlMock;

    /** @var LoggerInterface|Mock` */
    protected $loggerMock;

    public function setUp()
    {
        $this->providerMock = $this->getMockBuilder(CurlWebContentProvider::class)
            ->setMethods(['getClient'])
            ->getMock();

        $this->curlMock = $this->createMock(CurlRequest::class);

        $this->providerMock
            ->expects(self::any())
            ->method('getClient')
            ->willReturn($this->curlMock);

        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->providerMock->setLogger($this->loggerMock);
    }

    /**
     * @test
     */
    public function should_return_valid_content()
    {
        $this->curlMock
            ->expects(self::once())
            ->method('execute')
            ->willReturn('<body>foo</body>');

        $this->assertEquals('<body>foo</body>', $this->providerMock->getContent('www.acme.com'));
    }

    /**
     * @test
     */
    public function should_throw_exception_and_log_error_on_false_response()
    {
        $this->curlMock
            ->expects(self::once())
            ->method('execute')
            ->willReturn(false);

        $this->expectException(ClientException::class);

        $this->loggerMock
            ->expects(self::once())
            ->method('critical');

        $this->providerMock->getContent('www.acme.com');
    }
}
