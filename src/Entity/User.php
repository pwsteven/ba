<?php

namespace App\Entity;

use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SpecShaper\EncryptBundle\Annotations\Encrypted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("main")
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
     * @Groups("main")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Encrypted()
     */
    private $fullName;

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ContactDetails", mappedBy="User", cascade={"persist", "remove"})
     */
    private $contactDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appCurrentForm;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appBACorrespondence;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appFutherCorrespondence;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appComplaints;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appFinancialLoss;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appReimbursements;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appCreditMonitoring;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appEmotionalDistress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $proClaimReference;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FileReference", mappedBy="user")
     */
    private $fileReferences;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BACorrespondence", mappedBy="userID", cascade={"persist", "remove"})
     */
    private $bACorrespondence;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FurtherCorrespondence", mappedBy="User", cascade={"persist", "remove"})
     */
    private $furtherCorrespondence;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Complaints", mappedBy="User", cascade={"persist", "remove"})
     */
    private $complaints;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FinancialLoss", mappedBy="User", cascade={"persist", "remove"})
     */
    private $financialLoss;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reimbursements", mappedBy="User", cascade={"persist", "remove"})
     */
    private $reimbursements;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CreditMonitor", mappedBy="User", cascade={"persist", "remove"})
     */
    private $creditMonitor;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EmotionalDistress", mappedBy="User", cascade={"persist", "remove"})
     */
    private $emotionalDistress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiresAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApiToken", mappedBy="user", orphanRemoval=true)
     */
    private $apiTokens;

    public function __construct()
    {
        $this->fileReferences = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
    }

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

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

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

    public function getContactDetails(): ?ContactDetails
    {
        return $this->contactDetails;
    }

    public function setContactDetails(ContactDetails $contactDetails): self
    {
        $this->contactDetails = $contactDetails;

        // set the owning side of the relation if necessary
        if ($this !== $contactDetails->getUser()) {
            $contactDetails->setUser($this);
        }

        return $this;
    }

    public function getAppCurrentForm(): ?string
    {
        return $this->appCurrentForm;
    }

    public function setAppCurrentForm(?string $appCurrentForm): self
    {
        $this->appCurrentForm = $appCurrentForm;

        return $this;
    }

    public function getAppBACorrespondence(): ?bool
    {
        return $this->appBACorrespondence;
    }

    public function setAppBACorrespondence(?bool $appBACorrespondence): self
    {
        $this->appBACorrespondence = $appBACorrespondence;

        return $this;
    }

    public function getAppFutherCorrespondence(): ?bool
    {
        return $this->appFutherCorrespondence;
    }

    public function setAppFutherCorrespondence(?bool $appFutherCorrespondence): self
    {
        $this->appFutherCorrespondence = $appFutherCorrespondence;

        return $this;
    }

    public function getAppComplaints(): ?bool
    {
        return $this->appComplaints;
    }

    public function setAppComplaints(?bool $appComplaints): self
    {
        $this->appComplaints = $appComplaints;

        return $this;
    }

    public function getAppFinancialLoss(): ?bool
    {
        return $this->appFinancialLoss;
    }

    public function setAppFinancialLoss(?bool $appFinancialLoss): self
    {
        $this->appFinancialLoss = $appFinancialLoss;

        return $this;
    }

    public function getAppReimbursements(): ?bool
    {
        return $this->appReimbursements;
    }

    public function setAppReimbursements(?bool $appReimbursements): self
    {
        $this->appReimbursements = $appReimbursements;

        return $this;
    }

    public function getAppCreditMonitoring(): ?bool
    {
        return $this->appCreditMonitoring;
    }

    public function setAppCreditMonitoring(?bool $appCreditMonitoring): self
    {
        $this->appCreditMonitoring = $appCreditMonitoring;

        return $this;
    }

    public function getAppEmotionalDistress(): ?bool
    {
        return $this->appEmotionalDistress;
    }

    public function setAppEmotionalDistress(?bool $appEmotionalDistress): self
    {
        $this->appEmotionalDistress = $appEmotionalDistress;

        return $this;
    }

    public function getProClaimReference(): ?int
    {
        return $this->proClaimReference;
    }

    public function setProClaimReference(?int $proClaimReference): self
    {
        $this->proClaimReference = $proClaimReference;

        return $this;
    }

    /**
     * @return Collection|FileReference[]
     */
    public function getFileReferences(): Collection
    {
        return $this->fileReferences;
    }

    public function addFileReference(FileReference $fileReference): self
    {
        if (!$this->fileReferences->contains($fileReference)) {
            $this->fileReferences[] = $fileReference;
            $fileReference->setUser($this);
        }

        return $this;
    }

    public function removeFileReference(FileReference $fileReference): self
    {
        if ($this->fileReferences->contains($fileReference)) {
            $this->fileReferences->removeElement($fileReference);
            // set the owning side to null (unless already changed)
            if ($fileReference->getUser() === $this) {
                $fileReference->setUser(null);
            }
        }

        return $this;
    }

    public function getBACorrespondence(): ?BACorrespondence
    {
        return $this->bACorrespondence;
    }

    public function setBACorrespondence(BACorrespondence $bACorrespondence): self
    {
        $this->bACorrespondence = $bACorrespondence;

        // set the owning side of the relation if necessary
        if ($this !== $bACorrespondence->getUserID()) {
            $bACorrespondence->setUserID($this);
        }

        return $this;
    }

    public function getFurtherCorrespondence(): ?FurtherCorrespondence
    {
        return $this->furtherCorrespondence;
    }

    public function setFurtherCorrespondence(FurtherCorrespondence $furtherCorrespondence): self
    {
        $this->furtherCorrespondence = $furtherCorrespondence;

        // set the owning side of the relation if necessary
        if ($this !== $furtherCorrespondence->getUser()) {
            $furtherCorrespondence->setUser($this);
        }

        return $this;
    }

    public function getComplaints(): ?Complaints
    {
        return $this->complaints;
    }

    public function setComplaints(Complaints $complaints): self
    {
        $this->complaints = $complaints;

        // set the owning side of the relation if necessary
        if ($this !== $complaints->getUser()) {
            $complaints->setUser($this);
        }

        return $this;
    }

    public function getFinancialLoss(): ?FinancialLoss
    {
        return $this->financialLoss;
    }

    public function setFinancialLoss(FinancialLoss $financialLoss): self
    {
        $this->financialLoss = $financialLoss;

        // set the owning side of the relation if necessary
        if ($this !== $financialLoss->getUser()) {
            $financialLoss->setUser($this);
        }

        return $this;
    }

    public function getReimbursements(): ?Reimbursements
    {
        return $this->reimbursements;
    }

    public function setReimbursements(Reimbursements $reimbursements): self
    {
        $this->reimbursements = $reimbursements;

        // set the owning side of the relation if necessary
        if ($this !== $reimbursements->getUser()) {
            $reimbursements->setUser($this);
        }

        return $this;
    }

    public function getCreditMonitor(): ?CreditMonitor
    {
        return $this->creditMonitor;
    }

    public function setCreditMonitor(CreditMonitor $creditMonitor): self
    {
        $this->creditMonitor = $creditMonitor;

        // set the owning side of the relation if necessary
        if ($this !== $creditMonitor->getUser()) {
            $creditMonitor->setUser($this);
        }

        return $this;
    }

    public function getEmotionalDistress(): ?EmotionalDistress
    {
        return $this->emotionalDistress;
    }

    public function setEmotionalDistress(EmotionalDistress $emotionalDistress): self
    {
        $this->emotionalDistress = $emotionalDistress;

        // set the owning side of the relation if necessary
        if ($this !== $emotionalDistress->getUser()) {
            $emotionalDistress->setUser($this);
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getAvatar(): ?string
    {
        //return $this->avatar;
        return UploaderHelper::CLIENT_ID_IMAGE.'/'.$this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|ApiToken[]
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->apiTokens->contains($apiToken)) {
            $this->apiTokens->removeElement($apiToken);
            // set the owning side to null (unless already changed)
            if ($apiToken->getUser() === $this) {
                $apiToken->setUser(null);
            }
        }

        return $this;
    }

}
