<?php


namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploaderHelper
 * @package App\Service
 */
class UploaderHelper
{

    const CLIENT_ID_IMAGE = 'photo_id';

    /**
     * @var RequestStackContext
     * @var FilesystemInterface
     * @var LoggerInterface
     * @var string
     */
    private $requestStackContext;
    private $filesystem;
    private $logger;
    private $uploadedAssetsBaseUrl;

    public function __construct(FilesystemInterface $publicUploadsFilesystem, RequestStackContext $requestStackContext, LoggerInterface $logger, string $uploadedAssetsBaseUrl)
    {
        $this->requestStackContext = $requestStackContext;
        $this->filesystem = $publicUploadsFilesystem;
        $this->logger = $logger;
        $this->uploadedAssetsBaseUrl = $uploadedAssetsBaseUrl;
    }

    public function uploadClientFile(File $file, ?string $existingFileName): string
    {

        if ($file instanceof UploadedFile){
            $originalFileName = $file->getClientOriginalName();
        } else {
            $originalFileName = $file->getFilename();
        }
        $newFileName = Urlizer::urlize(pathinfo($originalFileName, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();

        $stream = fopen($file->getPathname(), 'r');

        try {
            $this->filesystem->writeStream(
                self::CLIENT_ID_IMAGE . '/' . $newFileName,
                $stream
            );
        } catch (FileExistsException $e) {
            $this->logger->alert(sprintf('Unable to upload new file "%s"', $newFileName));
        }

        if (is_resource($stream)){
            fclose($stream);
        }

        if ($existingFileName){
            try {
                $this->filesystem->delete(self::CLIENT_ID_IMAGE . '/' . $existingFileName);
            } catch (FileNotFoundException $e) {
                $this->logger->alert(sprintf('Old uploaded file "%s" was missing when trying to delete', $existingFileName));
            }
        }

        return $newFileName;

    }

    public function uploadFileReference(File $file): string
    {
        dd($file);
    }

    public function getPublicPath(string $path): string
    {
        return $this->requestStackContext->getBasePath().$this->uploadedAssetsBaseUrl.'/'.$path;
    }

}
