<?php

namespace Tests\App\Service\File;

use App\Service\Crawler\BuddySchoolProfileFetcher;
use App\Service\File\BuddySchoolProfileFileGenerator;
use App\Service\File\FileExporterInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class BuddySchoolProfileFileGeneratorTest extends TestCase
{
    /** @var BuddySchoolProfileFileGenerator|Mock */
    protected $generatorMock;

    /** @var FileExporterInterface|Mock */
    protected $fileExporterMock;

    /** @var BuddySchoolProfileFetcher|Mock */
    protected $profileFetcherMock;

    public function setUp()
    {
        $this->fileExporterMock = $this->createMock(FileExporterInterface::class);
        $this->profileFetcherMock = $this->createMock(BuddySchoolProfileFetcher::class);

        $this->generatorMock = $this->getMockBuilder(BuddySchoolProfileFileGenerator::class)
            ->setConstructorArgs([
                $this->fileExporterMock,
                $this->profileFetcherMock
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

        $this->profileFetcherMock
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
