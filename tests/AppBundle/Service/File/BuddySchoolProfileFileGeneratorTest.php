<?php

namespace Tests\AppBundle\Service\File;

use AppBundle\Service\Crawler\BuddySchoolProfileFetcher;
use AppBundle\Service\File\BuddySchoolProfileFileGenerator;
use AppBundle\Service\File\FileExporterInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class BuddySchoolProfileFileGeneratorTest extends TestCase
{
    /** @var BuddySchoolProfileFileGenerator|Mock */
    protected $generatorMock;

    /** @var FileExporterInterface|Mock */
    protected $fileExporterMock;

    /** @var BuddySchoolProfileFetcher|Mock */
    protected $profileFetcher;

    public function setUp()
    {
        $this->fileExporterMock = $this->getMockBuilder(FileExporterInterface::class)->getMock();
        $this->profileFetcher = $this->getMockBuilder(BuddySchoolProfileFetcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->generatorMock = $this->getMockBuilder(BuddySchoolProfileFileGenerator::class)
            ->setConstructorArgs([
                $this->fileExporterMock,
                $this->profileFetcher
            ])
            ->setMethods(['generateName'])
            ->getMock();
    }

    /**
     * @test
     */
    public function should_generate_profile_file()
    {
        $keyword = 'bar';
        $position = 1;

        $this->generatorMock->setWebPath('/var');

        $this->generatorMock
            ->expects(self::once())
            ->method('generateName')
            ->willReturn('foo.txt');

        $this->profileFetcher
            ->expects(self::once())
            ->method('getProfileContent')
            ->with($keyword, $position)
            ->willReturn('<body>baz</body>');

        $this->fileExporterMock
            ->expects(self::once())
            ->method('exportToFile')
            ->with('/var/files/foo.txt', '<body>baz</body>');

        $this->generatorMock->generateProfileFile($keyword, $position);
    }
}
