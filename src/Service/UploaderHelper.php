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
    const FILE_REFERENCE = 'file_reference';

    /**
     * @var RequestStackContext
     * @var FilesystemInterface
     * @var LoggerInterface
     * @var string
     * @var FilesystemInterface
     */
    private $requestStackContext;
    private $filesystem;
    private $logger;
    private $uploadedAssetsBaseUrl;
    private $privateFileSystem;

    public function __construct(FilesystemInterface $publicUploadsFilesystem, FilesystemInterface $privateUploadsFilesystem, RequestStackContext $requestStackContext, LoggerInterface $logger, string $uploadedAssetsBaseUrl)
    {
        $this->requestStackContext = $requestStackContext;
        $this->filesystem = $publicUploadsFilesystem;
        $this->logger = $logger;
        $this->uploadedAssetsBaseUrl = $uploadedAssetsBaseUrl;
        $this->privateFileSystem = $privateUploadsFilesystem;
    }

    public function uploadClientFile(File $file, ?string $existingFileName): string
    {

        try {
            $newFileName = $this->uploadFile($file, self::CLIENT_ID_IMAGE, true);
        } catch (\Exception $e) {
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
        try {
            return $this->uploadFile($file, self::FILE_REFERENCE, false);
        } catch (\Exception $e) {
        }
    }


    /**
     * @param string $path
     * @param bool $isPublic
     * @return resource
     */
    public function readStream(string $path, bool $isPublic)
    {

        $filesystem = $isPublic ? $this->filesystem : $this->privateFileSystem;
        $resource = $filesystem->readStream($path);
        if ($resource === false){
            throw new \Exception(sprintf('Error opening stream for "%s"', $path));
        }
        return $resource;
    }

    public function getPublicPath(string $path): string
    {
        return $this->requestStackContext->getBasePath().$this->uploadedAssetsBaseUrl.'/'.$path;
    }

    private function uploadFile(File $file, string $directory, bool $isPublic): string
    {
        if ($file instanceof UploadedFile){
            $originalFileName = $file->getClientOriginalName();
        } else {
            $originalFileName = $file->getFilename();
        }
        $newFileName = Urlizer::urlize(pathinfo($originalFileName, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();

        $filesystem = $isPublic ? $this->filesystem : $this->privateFileSystem;

        $stream = fopen($file->getPathname(), 'r');
        $result = $filesystem->writeStream(
            $directory.'/'.$newFileName,
            $stream
        );
        if ($result === false) {
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFileName));
        }
        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFileName;

    }

}
