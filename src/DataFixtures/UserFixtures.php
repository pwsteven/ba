<?php

namespace App\DataFixtures;

use App\Entity\BACorrespondence;
use App\Entity\Complaints;
use App\Entity\ContactDetails;
use App\Entity\CreditMonitor;
use App\Entity\EmotionalDistress;
use App\Entity\FinancialLoss;
use App\Entity\FurtherCorrespondence;
use App\Entity\PersonalDetails;
use App\Entity\Reimbursements;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('psteven13@outlook.com');
        $user->setFirstName('Paul Steven');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'letmein'
        ));
        $user->setRoles(['ROLE_USER']);
        $user->setProClaimReference(1051311);
        $personalDetails = new PersonalDetails();
        $personalDetails->setUser($user);

        $contactDetails = new ContactDetails();
        $contactDetails->setUser($user);

        $baCorrespondenceDetails = new BACorrespondence();
        $baCorrespondenceDetails->setUserID($user);

        $furtherCorrespondenceDetails = new FurtherCorrespondence();
        $furtherCorrespondenceDetails->setUser($user);

        $complaintDetails = new Complaints();
        $complaintDetails->setUser($user);

        $financialLossDetails = new FinancialLoss();
        $financialLossDetails->setUser($user);

        $reimbursementDetails = new Reimbursements();
        $reimbursementDetails->setUser($user);

        $creditMonitorDetails = new CreditMonitor();
        $creditMonitorDetails->setUser($user);

        $emotionalDistressDetails = new EmotionalDistress();
        $emotionalDistressDetails->setUser($user);

        $manager->persist($user);
        $manager->persist($personalDetails);
        $manager->persist($contactDetails);
        $manager->persist($baCorrespondenceDetails);
        $manager->persist($furtherCorrespondenceDetails);
        $manager->persist($complaintDetails);
        $manager->persist($financialLossDetails);
        $manager->persist($reimbursementDetails);
        $manager->persist($creditMonitorDetails);
        $manager->persist($emotionalDistressDetails);

        $manager->flush();
    }
}
