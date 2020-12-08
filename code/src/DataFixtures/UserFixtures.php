<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

<<<<<<< HEAD
        $user->setEmail("test@test.fr");
        $user->setPassword("Test95qz@a");
=======
>>>>>>> bf7b3250b162b4f25aa9c35e96562cb857ea6a66
        $user->setFirstname("Ben");
        $user->setLastname("Dupont");

        $manager->persist($user);
        $manager->flush();
    }
}
