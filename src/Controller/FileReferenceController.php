<?php

namespace App\Controller;

use App\Entity\FileReference;
use App\Entity\User;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class FileReferenceController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class FileReferenceController extends BaseController
{
    /**
     * @Route("/file/{id}/reference", name="upload_file_reference", methods={"POST"})
     * @param User $user
     * @param Request $request
     * @param UploaderHelper $uploaderHelper
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function uploadFileReference(User $user, Request $request, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('reference');
        $fileStage = $request->get('file_stage');

        $violations = $validator->validate(
            $uploadedFile,
            [
                new NotBlank([
                    'message' => 'Please select a file to upload!',
                ]),
                new File([
                    'maxSize' => '5M',
                    'maxSizeMessage' => 'The file is too big. Maximum file size is 5 Megabytes',
                    'mimeTypes' => [
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'text/plain'
                    ],
                    'mimeTypesMessage' => 'Invalid file type. Allowed formats: ".jpg .png .bmp .pdf .doc .docx .xsl .txt"',
                ])
            ]
        );

        if ($violations->count() > 0){
            /** @var ConstraintViolation $violation */
            $violation = $violations[0];
            $this->addFlash('error', $violation->getMessage());

            return $this->redirectToRoute('app_ba_correspondence');
        }

        $filename = $uploaderHelper->uploadFileReference($uploadedFile);
        $fileReference = new FileReference();
        $fileReference->setFilename($filename);
        $fileReference->setOriginalFileName($uploadedFile->getClientOriginalName() ?? $filename);
        $fileReference->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
        $fileReference->setFileStage($fileStage);
        $fileReference->setUser($user);
        $entityManager->persist($fileReference);
        $entityManager->flush();

        return $this->redirectToRoute('app_ba_correspondence');
    }
}
