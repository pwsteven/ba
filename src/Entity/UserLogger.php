<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserLoggerRepository")
 */
class UserLogger
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
    private $Browser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OperatingSystem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userLoggers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
