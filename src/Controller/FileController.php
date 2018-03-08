<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

class FileController extends AbstractController
{
    /**
     * @Route("download/{filename}", name="file_download")
     */
    public function downloadAction(string $filename)
    {
        $path = $this->get('kernel')->getRootDir() . '/../public/files/' . $filename;
        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {
            return $this->file($path);
        }

        return $this->createJsonResponse(Response::HTTP_NOT_FOUND);
    }
}