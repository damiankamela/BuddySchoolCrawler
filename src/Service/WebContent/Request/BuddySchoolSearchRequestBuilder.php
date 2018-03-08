<?php

namespace App\Service\WebContent\Request;

class BuddySchoolSearchRequestBuilder extends RequestBuilder
{
    /**
     * @param string $keyword
     * @return string
     */
    public function searchUrl(string $keyword): string
    {
        $this->setParameter('keyword', $keyword);
        $this->build();

        return $this->getUri();
    }
}