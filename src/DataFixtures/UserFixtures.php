<?php

namespace App\DataFixtures;

use App\Entity\BACorrespondence;
use App\Entity\ContactDetails;
use App\Entity\PersonalDetails;
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
        $user->setEmail('pwsteven13@gmail.com');
        $user->setFirstName('Paul');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'letmein'
        ));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setProClaimReference(1051311);
        $personalDetails = new PersonalDetails();
        $personalDetails->setUser($user);

        $contactDetails = new ContactDetails();
        $contactDetails->setUser($user);

        $baCorrespondenceDetails = new BACorrespondence();
        $baCorrespondenceDetails->setUserID($user);

        $manager->persist($user);
        $manager->persist($personalDetails);
        $manager->persist($contactDetails);
        $manager->persist($baCorrespondenceDetails);

        $manager->flush();
    }
}
