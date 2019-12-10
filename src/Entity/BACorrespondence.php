<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BACorrespondenceRepository")
 */
class BACorrespondence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Please select either Yes or No")
     */
    private $receivedConfirmationEmail;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="bACorrespondence", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOneDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Please select either Yes or No")
     */
    private $breachOneNotification;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $breachOneDateReceived;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOneNotificationFilePath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOneNotificationNotAffected;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $breachOneDateOfBooking;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $breachOneEmailAddressUsed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $breachOneBookingReference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOneBookingPlatform;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOnePaymentMethod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachOneBookingConfirmationFilePath;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $complete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Please select either Yes or No")
     */
    private $breachTwoNotification;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $breachTwoDateReceived;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachTwoNotificationFilePath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachTwoNotificationNotAffected;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $breachTwoDateOfBooking;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $breachTwoEmailAddressUsed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $breachTwoBookingReference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachTwoBookingPlatform;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachTwoPaymentMethod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breachTwoBookingConfirmationFilePath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceivedConfirmationEmail(): ?string
    {
        return $this->receivedConfirmationEmail;
    }

    public function setReceivedConfirmationEmail(?string $receivedConfirmationEmail): self
    {
        $this->receivedConfirmationEmail = $receivedConfirmationEmail;

        return $this;
    }

    public function getUserID(): ?User
    {
        return $this->userID;
    }

    public function setUserID(User $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getBreachOneDate(): ?string
    {
        return $this->breachOneDate;
    }

    public function setBreachOneDate(?string $breachOneDate): self
    {
        $this->breachOneDate = $breachOneDate;

        return $this;
    }

    public function getBreachOneNotification(): ?string
    {
        return $this->breachOneNotification;
    }

    public function setBreachOneNotification(?string $breachOneNotification): self
    {
        $this->breachOneNotification = $breachOneNotification;

        return $this;
    }

    public function getBreachOneDateReceived(): ?\DateTimeInterface
    {
        return $this->breachOneDateReceived;
    }

    public function setBreachOneDateReceived(?\DateTimeInterface $breachOneDateReceived): self
    {
        $this->breachOneDateReceived = $breachOneDateReceived;

        return $this;
    }

    public function getBreachOneNotificationFilePath(): ?string
    {
        return $this->breachOneNotificationFilePath;
    }

    public function setBreachOneNotificationFilePath(?string $breachOneNotificationFilePath): self
    {
        $this->breachOneNotificationFilePath = $breachOneNotificationFilePath;

        return $this;
    }

    public function getBreachOneNotificationNotAffected(): ?string
    {
        return $this->breachOneNotificationNotAffected;
    }

    public function setBreachOneNotificationNotAffected(?string $breachOneNotificationNotAffected): self
    {
        $this->breachOneNotificationNotAffected = $breachOneNotificationNotAffected;

        return $this;
    }

    public function getBreachOneDateOfBooking(): ?\DateTimeInterface
    {
        return $this->breachOneDateOfBooking;
    }

    public function setBreachOneDateOfBooking(?\DateTimeInterface $breachOneDateOfBooking): self
    {
        $this->breachOneDateOfBooking = $breachOneDateOfBooking;

        return $this;
    }

    public function getBreachOneEmailAddressUsed(): ?string
    {
        return $this->breachOneEmailAddressUsed;
    }

    public function setBreachOneEmailAddressUsed(?string $breachOneEmailAddressUsed): self
    {
        $this->breachOneEmailAddressUsed = $breachOneEmailAddressUsed;

        return $this;
    }

    public function getBreachOneBookingReference(): ?string
    {
        return $this->breachOneBookingReference;
    }

    public function setBreachOneBookingReference(?string $breachOneBookingReference): self
    {
        $this->breachOneBookingReference = $breachOneBookingReference;

        return $this;
    }

    public function getBreachOneBookingPlatform(): ?string
    {
        return $this->breachOneBookingPlatform;
    }

    public function setBreachOneBookingPlatform(?string $breachOneBookingPlatform): self
    {
        $this->breachOneBookingPlatform = $breachOneBookingPlatform;

        return $this;
    }

    public function getBreachOnePaymentMethod(): ?string
    {
        return $this->breachOnePaymentMethod;
    }

    public function setBreachOnePaymentMethod(?string $breachOnePaymentMethod): self
    {
        $this->breachOnePaymentMethod = $breachOnePaymentMethod;

        return $this;
    }

    public function getBreachOneBookingConfirmationFilePath(): ?string
    {
        return $this->breachOneBookingConfirmationFilePath;
    }

    public function setBreachOneBookingConfirmationFilePath(?string $breachOneBookingConfirmationFilePath): self
    {
        $this->breachOneBookingConfirmationFilePath = $breachOneBookingConfirmationFilePath;

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

    public function getBreachTwoNotification(): ?string
    {
        return $this->breachTwoNotification;
    }

    public function setBreachTwoNotification(?string $breachTwoNotification): self
    {
        $this->breachTwoNotification = $breachTwoNotification;

        return $this;
    }

    public function getBreachTwoDateReceived(): ?\DateTimeInterface
    {
        return $this->breachTwoDateReceived;
    }

    public function setBreachTwoDateReceived(?\DateTimeInterface $breachTwoDateReceived): self
    {
        $this->breachTwoDateReceived = $breachTwoDateReceived;

        return $this;
    }

    public function getBreachTwoNotificationFilePath(): ?string
    {
        return $this->breachTwoNotificationFilePath;
    }

    public function setBreachTwoNotificationFilePath(?string $breachTwoNotificationFilePath): self
    {
        $this->breachTwoNotificationFilePath = $breachTwoNotificationFilePath;

        return $this;
    }

    public function getBreachTwoNotificationNotAffected(): ?string
    {
        return $this->breachTwoNotificationNotAffected;
    }

    public function setBreachTwoNotificationNotAffected(?string $breachTwoNotificationNotAffected): self
    {
        $this->breachTwoNotificationNotAffected = $breachTwoNotificationNotAffected;

        return $this;
    }

    public function getBreachTwoDateOfBooking(): ?\DateTimeInterface
    {
        return $this->breachTwoDateOfBooking;
    }

    public function setBreachTwoDateOfBooking(?\DateTimeInterface $breachTwoDateOfBooking): self
    {
        $this->breachTwoDateOfBooking = $breachTwoDateOfBooking;

        return $this;
    }

    public function getBreachTwoEmailAddressUsed(): ?string
    {
        return $this->breachTwoEmailAddressUsed;
    }

    public function setBreachTwoEmailAddressUsed(?string $breachTwoEmailAddressUsed): self
    {
        $this->breachTwoEmailAddressUsed = $breachTwoEmailAddressUsed;

        return $this;
    }

    public function getBreachTwoBookingReference(): ?string
    {
        return $this->breachTwoBookingReference;
    }

    public function setBreachTwoBookingReference(?string $breachTwoBookingReference): self
    {
        $this->breachTwoBookingReference = $breachTwoBookingReference;

        return $this;
    }

    public function getBreachTwoBookingPlatform(): ?string
    {
        return $this->breachTwoBookingPlatform;
    }

    public function setBreachTwoBookingPlatform(?string $breachTwoBookingPlatform): self
    {
        $this->breachTwoBookingPlatform = $breachTwoBookingPlatform;

        return $this;
    }

    public function getBreachTwoPaymentMethod(): ?string
    {
        return $this->breachTwoPaymentMethod;
    }

    public function setBreachTwoPaymentMethod(?string $breachTwoPaymentMethod): self
    {
        $this->breachTwoPaymentMethod = $breachTwoPaymentMethod;

        return $this;
    }

    public function getBreachTwoBookingConfirmationFilePath(): ?string
    {
        return $this->breachTwoBookingConfirmationFilePath;
    }

    public function setBreachTwoBookingConfirmationFilePath(?string $breachTwoBookingConfirmationFilePath): self
    {
        $this->breachTwoBookingConfirmationFilePath = $breachTwoBookingConfirmationFilePath;

        return $this;
    }
}
