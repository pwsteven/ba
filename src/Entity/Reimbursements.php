<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReimbursementsRepository")
 */
class Reimbursements
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="reimbursements", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $financialLossSuffered;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $provider;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amountReimbursed;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $reimbursementFilesPath = [];

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

    public function getFinancialLossSuffered(): ?string
    {
        return $this->financialLossSuffered;
    }

    public function setFinancialLossSuffered(?string $financialLossSuffered): self
    {
        $this->financialLossSuffered = $financialLossSuffered;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getAmountReimbursed(): ?float
    {
        return $this->amountReimbursed;
    }

    public function setAmountReimbursed(?float $amountReimbursed): self
    {
        $this->amountReimbursed = $amountReimbursed;

        return $this;
    }

    public function getReimbursementFilesPath(): ?array
    {
        return $this->reimbursementFilesPath;
    }

    public function setReimbursementFilesPath(?array $reimbursementFilesPath): self
    {
        $this->reimbursementFilesPath = $reimbursementFilesPath;

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
