<?php

namespace AppBundle\Service\File;

class TextFileExporter implements FileExporterInterface
{
    /**
     * @param string $path
     * @param string $text
     * @return void
     */
    public function exportToFile(string $path, string $text)
    {
        file_put_contents($path, $text);
    }
}