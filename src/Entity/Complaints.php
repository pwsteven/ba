<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComplaintsRepository")
 */
class Complaints
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="complaints", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lodgedComplaint;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $complaintMade;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $receivedResponse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $satisfiedResponse;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reasonUnsatisfied;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactedIOC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactedActionFraud;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accessedGetSafeOnline;

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

    public function getLodgedComplaint(): ?string
    {
        return $this->lodgedComplaint;
    }

    public function setLodgedComplaint(?string $lodgedComplaint): self
    {
        $this->lodgedComplaint = $lodgedComplaint;

        return $this;
    }

    public function getComplaintMade(): ?\DateTimeInterface
    {
        return $this->complaintMade;
    }

    public function setComplaintMade(?\DateTimeInterface $complaintMade): self
    {
        $this->complaintMade = $complaintMade;

        return $this;
    }

    public function getReceivedResponse(): ?string
    {
        return $this->receivedResponse;
    }

    public function setReceivedResponse(?string $receivedResponse): self
    {
        $this->receivedResponse = $receivedResponse;

        return $this;
    }

    public function getSatisfiedResponse(): ?string
    {
        return $this->satisfiedResponse;
    }

    public function setSatisfiedResponse(?string $satisfiedResponse): self
    {
        $this->satisfiedResponse = $satisfiedResponse;

        return $this;
    }

    public function getReasonUnsatisfied(): ?string
    {
        return $this->reasonUnsatisfied;
    }

    public function setReasonUnsatisfied(?string $reasonUnsatisfied): self
    {
        $this->reasonUnsatisfied = $reasonUnsatisfied;

        return $this;
    }

    public function getContactedIOC(): ?string
    {
        return $this->contactedIOC;
    }

    public function setContactedIOC(?string $contactedIOC): self
    {
        $this->contactedIOC = $contactedIOC;

        return $this;
    }

    public function getContactedActionFraud(): ?string
    {
        return $this->contactedActionFraud;
    }

    public function setContactedActionFraud(?string $contactedActionFraud): self
    {
        $this->contactedActionFraud = $contactedActionFraud;

        return $this;
    }

    public function getAccessedGetSafeOnline(): ?string
    {
        return $this->accessedGetSafeOnline;
    }

    public function setAccessedGetSafeOnline(?string $accessedGetSafeOnline): self
    {
        $this->accessedGetSafeOnline = $accessedGetSafeOnline;

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
