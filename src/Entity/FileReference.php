<?php

namespace App\Entity;

use App\Service\UploaderHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileReferenceRepository")
 */
class FileReference
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("main")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fileReferences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("main")
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("main")
     */
    private $mimeType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"main", "input"})
     */
    private $originalFileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("main")
     */
    private $FileStage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("main")
     */
    private $FormUploadName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getOriginalFileName(): ?string
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName(?string $originalFileName): self
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    public function getFileStage(): ?string
    {
        return $this->FileStage;
    }

    public function setFileStage(?string $FileStage): self
    {
        $this->FileStage = $FileStage;

        return $this;
    }
    public function getFilePath()
    {
        return UploaderHelper::FILE_REFERENCE.'/'.$this->getFilename();
    }

    public function getFormUploadName(): ?string
    {
        return $this->FormUploadName;
    }

    public function setFormUploadName(?string $FormUploadName): self
    {
        $this->FormUploadName = $FormUploadName;

        return $this;
    }
}
