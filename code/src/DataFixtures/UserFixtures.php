<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();

        $user->setEmail("test@test.fr");
        $user->setPassword("Test95qz@a");
        $user->setFirstname("Ben");
        $user->setLastname("Dupont");

        $manager->persist($user);
        $manager->flush();
    }
}
