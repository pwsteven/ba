<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmotionalDistressRepository")
 */
class EmotionalDistress
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="emotionalDistress", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personalDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emotionsExperienced;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emotionsExperiencedComment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emotionalDistressLasted;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionA = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionA_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionB = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionB_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionC = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionC_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionD = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionD_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionE = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionE_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionF = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionF_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $breachQuestionG = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $breachQuestionG_example;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $diagnosedConditions = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $diagnosedConditionsExample;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $impactCondition = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $impactConditionExample;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $stepsTaken = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $stepsTakenExample;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $stepsTakenDetails;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $stepsTakenFilesPath = [];

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $adverseConsequences = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adverseConsequencesExample;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adverseConsequencesDetails;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $adverseConsequencesFilesPath = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $additionalInformation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leadTestClaimant;

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

    public function getPersonalDetails(): ?string
    {
        return $this->personalDetails;
    }

    public function setPersonalDetails(?string $personalDetails): self
    {
        $this->personalDetails = $personalDetails;

        return $this;
    }

    public function getEmotionsExperienced(): ?string
    {
        return $this->emotionsExperienced;
    }

    public function setEmotionsExperienced(?string $emotionsExperienced): self
    {
        $this->emotionsExperienced = $emotionsExperienced;

        return $this;
    }

    public function getEmotionsExperiencedComment(): ?string
    {
        return $this->emotionsExperiencedComment;
    }

    public function setEmotionsExperiencedComment(?string $emotionsExperiencedComment): self
    {
        $this->emotionsExperiencedComment = $emotionsExperiencedComment;

        return $this;
    }

    public function getEmotionalDistressLasted(): ?string
    {
        return $this->emotionalDistressLasted;
    }

    public function setEmotionalDistressLasted(?string $emotionalDistressLasted): self
    {
        $this->emotionalDistressLasted = $emotionalDistressLasted;

        return $this;
    }

    public function getBreachQuestionA(): ?array
    {
        return $this->breachQuestionA;
    }

    public function setBreachQuestionA(?array $breachQuestionA): self
    {
        $this->breachQuestionA = $breachQuestionA;

        return $this;
    }

    public function getBreachQuestionAExample(): ?string
    {
        return $this->breachQuestionA_example;
    }

    public function setBreachQuestionAExample(?string $breachQuestionA_example): self
    {
        $this->breachQuestionA_example = $breachQuestionA_example;

        return $this;
    }

    public function getBreachQuestionB(): ?array
    {
        return $this->breachQuestionB;
    }

    public function setBreachQuestionB(?array $breachQuestionB): self
    {
        $this->breachQuestionB = $breachQuestionB;

        return $this;
    }

    public function getBreachQuestionBExample(): ?string
    {
        return $this->breachQuestionB_example;
    }

    public function setBreachQuestionBExample(?string $breachQuestionB_example): self
    {
        $this->breachQuestionB_example = $breachQuestionB_example;

        return $this;
    }

    public function getBreachQuestionC(): ?array
    {
        return $this->breachQuestionC;
    }

    public function setBreachQuestionC(?array $breachQuestionC): self
    {
        $this->breachQuestionC = $breachQuestionC;

        return $this;
    }

    public function getBreachQuestionCExample(): ?string
    {
        return $this->breachQuestionC_example;
    }

    public function setBreachQuestionCExample(?string $breachQuestionC_example): self
    {
        $this->breachQuestionC_example = $breachQuestionC_example;

        return $this;
    }

    public function getBreachQuestionD(): ?array
    {
        return $this->breachQuestionD;
    }

    public function setBreachQuestionD(?array $breachQuestionD): self
    {
        $this->breachQuestionD = $breachQuestionD;

        return $this;
    }

    public function getBreachQuestionDExample(): ?string
    {
        return $this->breachQuestionD_example;
    }

    public function setBreachQuestionDExample(?string $breachQuestionD_example): self
    {
        $this->breachQuestionD_example = $breachQuestionD_example;

        return $this;
    }

    public function getBreachQuestionE(): ?array
    {
        return $this->breachQuestionE;
    }

    public function setBreachQuestionE(?array $breachQuestionE): self
    {
        $this->breachQuestionE = $breachQuestionE;

        return $this;
    }

    public function getBreachQuestionEExample(): ?string
    {
        return $this->breachQuestionE_example;
    }

    public function setBreachQuestionEExample(?string $breachQuestionE_example): self
    {
        $this->breachQuestionE_example = $breachQuestionE_example;

        return $this;
    }

    public function getBreachQuestionF(): ?array
    {
        return $this->breachQuestionF;
    }

    public function setBreachQuestionF(?array $breachQuestionF): self
    {
        $this->breachQuestionF = $breachQuestionF;

        return $this;
    }

    public function getBreachQuestionFExample(): ?string
    {
        return $this->breachQuestionF_example;
    }

    public function setBreachQuestionFExample(?string $breachQuestionF_example): self
    {
        $this->breachQuestionF_example = $breachQuestionF_example;

        return $this;
    }

    public function getBreachQuestionG(): ?array
    {
        return $this->breachQuestionG;
    }

    public function setBreachQuestionG(?array $breachQuestionG): self
    {
        $this->breachQuestionG = $breachQuestionG;

        return $this;
    }

    public function getBreachQuestionGExample(): ?string
    {
        return $this->breachQuestionG_example;
    }

    public function setBreachQuestionGExample(?string $breachQuestionG_example): self
    {
        $this->breachQuestionG_example = $breachQuestionG_example;

        return $this;
    }

    public function getDiagnosedConditions(): ?array
    {
        return $this->diagnosedConditions;
    }

    public function setDiagnosedConditions(?array $diagnosedConditions): self
    {
        $this->diagnosedConditions = $diagnosedConditions;

        return $this;
    }

    public function getDiagnosedConditionsExample(): ?string
    {
        return $this->diagnosedConditionsExample;
    }

    public function setDiagnosedConditionsExample(?string $diagnosedConditionsExample): self
    {
        $this->diagnosedConditionsExample = $diagnosedConditionsExample;

        return $this;
    }

    public function getImpactCondition(): ?array
    {
        return $this->impactCondition;
    }

    public function setImpactCondition(?array $impactCondition): self
    {
        $this->impactCondition = $impactCondition;

        return $this;
    }

    public function getImpactConditionExample(): ?string
    {
        return $this->impactConditionExample;
    }

    public function setImpactConditionExample(?string $impactConditionExample): self
    {
        $this->impactConditionExample = $impactConditionExample;

        return $this;
    }

    public function getStepsTaken(): ?array
    {
        return $this->stepsTaken;
    }

    public function setStepsTaken(?array $stepsTaken): self
    {
        $this->stepsTaken = $stepsTaken;

        return $this;
    }

    public function getStepsTakenExample(): ?string
    {
        return $this->stepsTakenExample;
    }

    public function setStepsTakenExample(?string $stepsTakenExample): self
    {
        $this->stepsTakenExample = $stepsTakenExample;

        return $this;
    }

    public function getStepsTakenDetails(): ?string
    {
        return $this->stepsTakenDetails;
    }

    public function setStepsTakenDetails(?string $stepsTakenDetails): self
    {
        $this->stepsTakenDetails = $stepsTakenDetails;

        return $this;
    }

    public function getStepsTakenFilesPath(): ?array
    {
        return $this->stepsTakenFilesPath;
    }

    public function setStepsTakenFilesPath(?array $stepsTakenFilesPath): self
    {
        $this->stepsTakenFilesPath = $stepsTakenFilesPath;

        return $this;
    }

    public function getAdverseConsequences(): ?array
    {
        return $this->adverseConsequences;
    }

    public function setAdverseConsequences(?array $adverseConsequences): self
    {
        $this->adverseConsequences = $adverseConsequences;

        return $this;
    }

    public function getAdverseConsequencesExample(): ?string
    {
        return $this->adverseConsequencesExample;
    }

    public function setAdverseConsequencesExample(?string $adverseConsequencesExample): self
    {
        $this->adverseConsequencesExample = $adverseConsequencesExample;

        return $this;
    }

    public function getAdverseConsequencesDetails(): ?string
    {
        return $this->adverseConsequencesDetails;
    }

    public function setAdverseConsequencesDetails(?string $adverseConsequencesDetails): self
    {
        $this->adverseConsequencesDetails = $adverseConsequencesDetails;

        return $this;
    }

    public function getAdverseConsequencesFilesPath(): ?array
    {
        return $this->adverseConsequencesFilesPath;
    }

    public function setAdverseConsequencesFilesPath(?array $adverseConsequencesFilesPath): self
    {
        $this->adverseConsequencesFilesPath = $adverseConsequencesFilesPath;

        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    public function getLeadTestClaimant(): ?string
    {
        return $this->leadTestClaimant;
    }

    public function setLeadTestClaimant(?string $leadTestClaimant): self
    {
        $this->leadTestClaimant = $leadTestClaimant;

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
