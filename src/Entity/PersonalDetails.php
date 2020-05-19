<?php

namespace App\Entity;

use App\Service\UploaderHelper;
use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonalDetailsRepository")
 */
class PersonalDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your First Name")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $middleName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your Surname")
     */
    private $surname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank(message="Please enter your Date of Birth")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $completed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="personalDetails", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): self
    {
        $this->completed = $completed;

        return $this;
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

    public function getImageFileName(): ?string
    {
        return UploaderHelper::CLIENT_ID_IMAGE.'/'.$this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): self
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
