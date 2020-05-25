<?php

namespace App\Controller;

use App\Entity\FileReference;
use App\Entity\User;
use App\Repository\FileReferenceRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
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
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function uploadFileReference(User $user, Request $request, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('reference');
        $fileStage = $request->get('file_stage');
        $formUploadName = $request->get('form_upload_name');

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
            return $this->json($violations, 400);
        }

        $filename = $uploaderHelper->uploadFileReference($uploadedFile);
        $fileReference = new FileReference();
        $fileReference->setFilename($filename);
        $fileReference->setOriginalFileName($uploadedFile->getClientOriginalName() ?? $filename);
        $fileReference->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
        $fileReference->setFileStage($fileStage);
        $fileReference->setFormUploadName($formUploadName);
        $fileReference->setUser($user);
        $entityManager->persist($fileReference);
        $entityManager->flush();

        return $this->json($fileReference,
        201,
        [],
        [
            'groups' => 'main',
        ]);
    }

    /**
     * @param FileReference $fileReference
     * @param UploaderHelper $uploaderHelper
     * @return StreamedResponse
     * @Route("file/{id}/download", name="download_file_reference", methods={"GET"})
     */
    public function downloadFileReference(FileReference $fileReference, UploaderHelper $uploaderHelper)
    {

        $response = new StreamedResponse(function() use ($fileReference, $uploaderHelper) {
            $outputStream = fopen('php://output', 'wb');
            $fileStream = $uploaderHelper->readStream($fileReference->getFilePath(), false);
            stream_copy_to_stream($fileStream, $outputStream);
        });
        $response->headers->set('Content-Type', $fileReference->getMimeType());
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $fileReference->getOriginalFileName()
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

    /**
     * @Route("/dashboard/file/references/{str}", name="get_file_references", methods={"GET"})
     * @param string $str
     * @param FileReferenceRepository $fileReferenceRepository
     * @return JsonResponse
     */
    public function getFileReferences(string $str, FileReferenceRepository $fileReferenceRepository)
    {
        $userID = $this->getUser()->getId();
        return $this->json($fileReferenceRepository->findByExampleFields($userID, $str),
        200,
        [],
        [
            'groups' => 'main',
        ]);
    }

    /**
     * @Route("/dashboard/file/filtered/references/{str}", name="get_filtered_file_references", methods={"GET"})
     * @param string $str
     * @param FileReferenceRepository $fileReferenceRepository
     * @return JsonResponse
     */
    public function getFilteredFileReferences(string $str, FileReferenceRepository $fileReferenceRepository)
    {
        $userID = $this->getUser()->getId();
        return $this->json($fileReferenceRepository->findByFilteredExampleFields($userID, $str),
            200,
            [],
            [
                'groups' => 'main',
            ]);
    }

    /**
     * @param FileReference $fileReference
     * @param UploaderHelper $uploaderHelper
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws Exception
     * @Route("/dashboard/file/{id}/delete", name="delete_file_refernces", methods={"DELETE"})
     */
    public function deleteFileReference(FileReference $fileReference, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager)
    {

        $entityManager->getConnection()->beginTransaction();
        try {
            $entityManager->remove($fileReference);
            $entityManager->flush();
            $uploaderHelper->deleteFile($fileReference->getFilePath(), false);
            $entityManager->getConnection()->commit();
            return new Response(null, 204);
        } catch (Exception $exception) {
            $entityManager->getConnection()->rollBack();
            throw $exception;
        }

    }

    /**
     * @param FileReference $fileReference
     * @param UploaderHelper $uploaderHelper
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * @Route("/dashboard/file/{id}/edit", name="edit_file_refernces", methods={"PUT"})
     */
    public function editFileNameReference(FileReference $fileReference, UploaderHelper $uploaderHelper, EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request)
    {
        $serializer->deserialize(
            $request->getContent(),
            FileReference::class,
            'json',
            [
                'object_to_populate' => $fileReference,
                'groups' => ['input']
            ]
        );
        $entityManager->persist($fileReference);
        $entityManager->flush();
        return $this->json($fileReference,
            200,
            [],
            [
                'groups' => 'main',
            ]);
    }
}
