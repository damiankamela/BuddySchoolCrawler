<?php

namespace Tests\App\Service\File;

use App\Service\Crawler\BuddySchoolProfileFetcher;
use App\Service\File\BuddySchoolProfileFileGenerator;
use App\Service\File\FileExporterInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class BuddySchoolProfileFileGeneratorTest extends TestCase
{
    /** @var BuddySchoolProfileFileGenerator */
    protected $generator;

    /** @var FileExporterInterface|Mock */
    protected $fileExporterMock;

    /** @var BuddySchoolProfileFetcher|Mock */
    protected $profileFetcherMock;

    public function setUp()
    {
        $this->fileExporterMock = $this->createMock(FileExporterInterface::class);
        $this->profileFetcherMock = $this->createMock(BuddySchoolProfileFetcher::class);

        $this->generator = new BuddySchoolProfileFileGenerator(
            $this->fileExporterMock,
            $this->profileFetcherMock
        );
    }

    /**
     * @test
     */
    public function should_generate_profile_file()
    {
        $keyword = 'bar';
        $position = 1;

        $this->generator->setWebPath('/var');

        $this->profileFetcherMock
            ->expects(self::once())
            ->method('getProfileContent')
            ->with($keyword, $position)
            ->willReturn('<body>baz</body>');

        $this->fileExporterMock
            ->expects(self::once())
            ->method('exportToFile')
            ->with($this->stringContains('/var/files/'), '<body>baz</body>');

        $result = $this->generator->generateProfileFile($keyword, $position);

        $this->assertContains('.txt', $result);
    }
}
