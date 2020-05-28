<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserLoggedRepository")
 */
class UserLogged
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $Browser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $OperatingSystem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $Device;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OpLanguage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $TimeLogged;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $version;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_robot;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $IpAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserID(): ?int
    {
        return $this->userID;
    }

    public function setUserID(?int $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->Browser;
    }

    public function setBrowser(?string $Browser): self
    {
        $this->Browser = $Browser;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->OperatingSystem;
    }

    public function setOperatingSystem(?string $OperatingSystem): self
    {
        $this->OperatingSystem = $OperatingSystem;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->Device;
    }

    public function setDevice(?string $Device): self
    {
        $this->Device = $Device;

        return $this;
    }

    public function getOpLanguage(): ?string
    {
        return $this->OpLanguage;
    }

    public function setOpLanguage(?string $OpLanguage): self
    {
        $this->OpLanguage = $OpLanguage;

        return $this;
    }

    public function getTimeLogged(): ?\DateTimeInterface
    {
        return $this->TimeLogged;
    }

    public function setTimeLogged(?\DateTimeInterface $TimeLogged): self
    {
        $this->TimeLogged = $TimeLogged;

        return $this;
    }

    public function __toString()
    {
        return $this->Browser;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getIsRobot(): ?bool
    {
        return $this->is_robot;
    }

    public function setIsRobot(?bool $is_robot): self
    {
        $this->is_robot = $is_robot;

        return $this;
    }

    public function getIsMobile(): ?bool
    {
        return $this->is_mobile;
    }

    public function setIsMobile(?bool $is_mobile): self
    {
        $this->is_mobile = $is_mobile;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->IpAddress;
    }

    public function setIpAddress(?string $IpAddress): self
    {
        $this->IpAddress = $IpAddress;

        return $this;
    }
}
