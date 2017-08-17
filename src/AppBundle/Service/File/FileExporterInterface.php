<?php

namespace AppBundle\Service\File;

interface FileExporterInterface
{
    /**
     * @param string $path
     * @param string $text
     * @return mixed
     */
    public function exportToFile(string $path, string $text);
}