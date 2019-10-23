<?php

namespace App\DataFixtures;

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
        $personalDetails = new PersonalDetails();
        $personalDetails->setUser($user);

        $manager->persist($user);
        $manager->persist($personalDetails);
        $manager->flush();
    }
}
