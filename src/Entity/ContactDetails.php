<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactDetailsRepository")
 */
class ContactDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $houseNameNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your full Street Address")
     */
    private $streetAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $streetAddress2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $streetAddress3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your Town/City")
     */
    private $townCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $county;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your Postcode")
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your Email Address")
     */
    private $emailAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     * @Assert\NotBlank(message="Please enter your Mobile or Telephone Number")
     */
    private $mobileTelephoneNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $completed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="contactDetails", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Encrypted()
     */
    private $addressBlock;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $useClientAddressBlock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHouseNameNumber(): ?string
    {
        return $this->houseNameNumber;
    }

    public function setHouseNameNumber(?string $houseNameNumber): self
    {
        $this->houseNameNumber = $houseNameNumber;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getStreetAddress2(): ?string
    {
        return $this->streetAddress2;
    }

    public function setStreetAddress2(?string $streetAddress2): self
    {
        $this->streetAddress2 = $streetAddress2;

        return $this;
    }

    public function getStreetAddress3(): ?string
    {
        return $this->streetAddress3;
    }

    public function setStreetAddress3(?string $streetAddress3): self
    {
        $this->streetAddress3 = $streetAddress3;

        return $this;
    }

    public function getTownCity(): ?string
    {
        return $this->townCity;
    }

    public function setTownCity(?string $townCity): self
    {
        $this->townCity = $townCity;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getMobileTelephoneNumber(): ?string
    {
        return $this->mobileTelephoneNumber;
    }

    public function setMobileTelephoneNumber(?string $mobileTelephoneNumber): self
    {
        $this->mobileTelephoneNumber = $mobileTelephoneNumber;

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

    public function getAddressBlock(): ?string
    {
        return $this->addressBlock;
    }

    public function setAddressBlock(?string $addressBlock): self
    {
        $this->addressBlock = $addressBlock;

        return $this;
    }

    public function getUseClientAddressBlock(): ?bool
    {
        return $this->useClientAddressBlock;
    }

    public function setUseClientAddressBlock(?bool $useClientAddressBlock): self
    {
        $this->useClientAddressBlock = $useClientAddressBlock;

        return $this;
    }

}
