<?php

namespace AppBundle\Service\WebContent\Request;

class BuddySchoolSearchRequest extends Request
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