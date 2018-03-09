<?php

namespace App\Service\File;

use App\Service\Crawler\BuddySchoolProfileFetcher;

class BuddySchoolProfileFileGenerator
{
    /** @var FileExporterInterface */
    protected $fileExporter;

    /** @var BuddySchoolProfileFetcher */
    protected $profileFetcher;

    /** @var string */
    protected $webPath;

    /**
     * BuddySchoolProfileFileGenerator constructor.
     * @param FileExporterInterface     $fileExporter
     * @param BuddySchoolProfileFetcher $profileFetcher
     */
    public function __construct(FileExporterInterface $fileExporter, BuddySchoolProfileFetcher $profileFetcher)
    {
        $this->fileExporter = $fileExporter;
        $this->profileFetcher = $profileFetcher;
    }

    /**
     * @param string $webPath
     */
    public function setWebPath(string $webPath): void
    {
        $this->webPath = $webPath;
    }

    /**
     * @param string $keyword
     * @param int    $position
     * @return string
     */
    public function generateProfileFile(string $keyword, int $position = 0): string
    {
        $content = $this->profileFetcher->getProfileContent($keyword, $position);
        $name = $this->generateName();
        $path = $this->generatePath($name);

        $this->fileExporter->exportToFile($path, $content);

        return $name;
    }

    /**
     * @param string $filename
     * @return string
     */
    protected function generatePath(string $filename): string
    {
        return $this->webPath . '/files/' . $filename;
    }

    /**
     * @return string
     */
    protected function generateName(): string
    {
        return uniqid() . '.txt';
    }
}