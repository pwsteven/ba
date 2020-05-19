<?php

namespace App\Controller;

use App\Entity\FileReference;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class FileReferenceController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FileReferenceController extends BaseController
{
    /**
     * @Route("/file/{id}/reference", name="upload_file_reference", methods={"POST"})
     * @param Request $request
     * @param UploaderHelper $uploaderHelper
     * @param EntityManagerInterface $entityManager
     */
    public function uploadFileReference(Request $request, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager)
    {

        $userID = $this->getUser()->getId();
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('reference');
        $filename = $uploaderHelper->uploadFileReference($uploadedFile);
        $fileReference = new FileReference($userID);
        $fileReference->setFilename($filename);
        $fileReference->setOriginalFileName($uploadedFile->getClientOriginalName() ?? $filename);
        $fileReference->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
        $entityManager->persist($fileReference);
        $entityManager->flush();

        $this->redirectToRoute('app_ba_correspondence');
    }
}
