<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends Controller
{
    /**
     * @param int $statusCode
     * @param     $data
     * @return Response
     */
    protected function createJsonResponse(int $statusCode, $data = null): Response
    {
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);

        return $response;
    }
}