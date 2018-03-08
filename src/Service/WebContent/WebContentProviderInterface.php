<?php

namespace App\Service\WebContent;

interface WebContentProviderInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function getContent(string $url): string;
}