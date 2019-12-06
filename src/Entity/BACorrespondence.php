<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     */
    private $breachOneEmailAddressUsed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
}
