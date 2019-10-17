<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('pwsteven13@gmail.com');
        $user->setFirstName('Paul');
        $user->setPassword('letmein');
        $manager->persist($user);

        $manager->flush();
    }
}
