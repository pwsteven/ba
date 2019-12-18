<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditMonitorRepository")
 */
class CreditMonitor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="creditMonitor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $monitorCredit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $monitorCreditFilePath;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $complete;

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

    public function getMonitorCredit(): ?string
    {
        return $this->monitorCredit;
    }

    public function setMonitorCredit(?string $monitorCredit): self
    {
        $this->monitorCredit = $monitorCredit;

        return $this;
    }

    public function getMonitorCreditFilePath(): ?string
    {
        return $this->monitorCreditFilePath;
    }

    public function setMonitorCreditFilePath(?string $monitorCreditFilePath): self
    {
        $this->monitorCreditFilePath = $monitorCreditFilePath;

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
