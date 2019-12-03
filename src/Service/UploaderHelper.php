<?php


namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploaderHelper
 * @package App\Service
 */
class UploaderHelper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadClientFile(UploadedFile $uploadedFile, int $i): string
    {

        if ($i === 1) {
            $destination = $this->uploadsPath . '/photo_id';
        } elseif ($i === 2) {
            $destination = $this->uploadsPath . '/email_notification';
        } elseif ($i === 3) {
            $destination = $this->uploadsPath . '/booking_notification';
        } elseif ($i === 4) {
            $destination = $this->uploadsPath . '/correspondence';
        } elseif ($i === 5) {
            $destination = $this->uploadsPath . '/financial_documents';
        } elseif ($i === 6) {
            $destination = $this->uploadsPath . '/credit_monitor';
        } else {
            $destination = $this->uploadsPath . '/emotional_distress';
        }

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = Urlizer::urlize($originalFileName).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFileName
        );

        return $newFileName;

    }
}