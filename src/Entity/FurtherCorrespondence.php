<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FurtherCorrespondenceRepository")
 */
class FurtherCorrespondence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="furtherCorrespondence", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personalInformationBreachedFilePath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Please select either yes or no")
     */
    private $receivedAnyOtherBACorrespondence;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $allCorrespondenceSentReceivedFilePath = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $complete;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $allCorrespondenceFilePath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPersonalInformationBreachedFilePath(): ?string
    {
        return $this->personalInformationBreachedFilePath;
    }

    public function setPersonalInformationBreachedFilePath(?string $personalInformationBreachedFilePath): self
    {
        $this->personalInformationBreachedFilePath = $personalInformationBreachedFilePath;

        return $this;
    }

    public function getReceivedAnyOtherBACorrespondence(): ?string
    {
        return $this->receivedAnyOtherBACorrespondence;
    }

    public function setReceivedAnyOtherBACorrespondence(?string $receivedAnyOtherBACorrespondence): self
    {
        $this->receivedAnyOtherBACorrespondence = $receivedAnyOtherBACorrespondence;

        return $this;
    }

    public function getAllCorrespondenceSentReceivedFilePath(): ?array
    {
        return $this->allCorrespondenceSentReceivedFilePath;
    }

    public function setAllCorrespondenceSentReceivedFilePath(?array $allCorrespondenceSentReceivedFilePath): self
    {
        $this->allCorrespondenceSentReceivedFilePath = $allCorrespondenceSentReceivedFilePath;

        return $this;
    }

    public function getComplete(): ?bool
    {
        return $this->complete;
    }

    public function setComplete(?bool $complete): self
    {
        $this->complete = $complete;

        return $this;
    }

    public function getAllCorrespondenceFilePath(): ?string
    {
        return $this->allCorrespondenceFilePath;
    }

    public function setAllCorrespondenceFilePath(?string $allCorrespondenceFilePath): self
    {
        $this->allCorrespondenceFilePath = $allCorrespondenceFilePath;

        return $this;
    }
}
