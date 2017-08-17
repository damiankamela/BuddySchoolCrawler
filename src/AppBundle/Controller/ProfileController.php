<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileToTextType;
use AppBundle\Service\Crawler\Exception\NoResultsException;
use AppBundle\Service\File\BuddySchoolProfileFileGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends AbstractController
{
    /**
     * @Route("api/profile-to-file", name="profile_to_file")
     */
    public function profileToFileAction(Request $request)
    {
        $form = $this->createForm(ProfileToTextType::class);
        $form->submit($request->query->all());

        if ($form->isValid()) {
            $keyword = $form->getData()['keyword'];
            $position = $form->getData()['position'] ?? 0;

            try {
                $filename = $this->getProfileGenerator()->generateProfileFile($keyword, $position);

                return $this->createJsonResponse(Response::HTTP_OK, json_encode(['file' => $filename], true));
            } catch (NoResultsException $exception) {
                return $this->createJsonResponse(Response::HTTP_NOT_FOUND);
            }
        }

        return $this->createJsonResponse(Response::HTTP_BAD_REQUEST, $form->getErrors());
    }

    /**
     * @return BuddySchoolProfileFileGenerator|object
     */
    protected function getProfileGenerator(): BuddySchoolProfileFileGenerator
    {
        return $this->get(BuddySchoolProfileFileGenerator::class);
    }
}