<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted()
     */
    private $firstName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appStarted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appCompleted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appPersonalDetails;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appContactDetails;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PersonalDetails", mappedBy="User", cascade={"persist", "remove"})
     */
    private $personalDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAppStarted(): ?bool
    {
        return $this->appStarted;
    }

    public function setAppStarted(?bool $appStarted): self
    {
        $this->appStarted = $appStarted;

        return $this;
    }

    public function getAppCompleted(): ?bool
    {
        return $this->appCompleted;
    }

    public function setAppCompleted(?bool $appCompleted): self
    {
        $this->appCompleted = $appCompleted;

        return $this;
    }

    public function getAppPersonalDetails(): ?bool
    {
        return $this->appPersonalDetails;
    }

    public function setAppPersonalDetails(?bool $appPersonalDetails): self
    {
        $this->appPersonalDetails = $appPersonalDetails;

        return $this;
    }

    public function getAppContactDetails(): ?bool
    {
        return $this->appContactDetails;
    }

    public function setAppContactDetails(?bool $appContactDetails): self
    {
        $this->appContactDetails = $appContactDetails;

        return $this;
    }

    public function getPersonalDetails(): ?PersonalDetails
    {
        return $this->personalDetails;
    }

    public function setPersonalDetails(PersonalDetails $personalDetails): self
    {
        $this->personalDetails = $personalDetails;

        // set the owning side of the relation if necessary
        if ($this !== $personalDetails->getUser()) {
            $personalDetails->setUser($this);
        }

        return $this;
    }
}
