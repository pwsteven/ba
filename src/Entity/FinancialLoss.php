<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FinancialLossRepository")
 */
class FinancialLoss
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="financialLoss", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $typeFinancialLoss = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Encrypted()
     */
    private $typeFinancialLossOtherComment;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalLossAmount;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $financialLossFilesPath = [];

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

    public function getTypeFinancialLoss(): ?array
    {
        return $this->typeFinancialLoss;
    }

    public function setTypeFinancialLoss(?array $typeFinancialLoss): self
    {
        $this->typeFinancialLoss = $typeFinancialLoss;

        return $this;
    }

    public function getTypeFinancialLossOtherComment(): ?string
    {
        return $this->typeFinancialLossOtherComment;
    }

    public function setTypeFinancialLossOtherComment(?string $typeFinancialLossOtherComment): self
    {
        $this->typeFinancialLossOtherComment = $typeFinancialLossOtherComment;

        return $this;
    }

    public function getTotalLossAmount(): ?float
    {
        return $this->totalLossAmount;
    }

    public function setTotalLossAmount(?float $totalLossAmount): self
    {
        $this->totalLossAmount = $totalLossAmount;

        return $this;
    }

    public function getFinancialLossFilesPath(): ?array
    {
        return $this->financialLossFilesPath;
    }

    public function setFinancialLossFilesPath(?array $financialLossFilesPath): self
    {
        $this->financialLossFilesPath = $financialLossFilesPath;

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
