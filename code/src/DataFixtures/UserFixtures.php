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

        $user->setGender("male");
        $user->setFirstname("Ben");
        $user->setLastname("Dupont");
        $user->setAddress("10 Rue de tarte au pomme 98432");

        $manager->persist($user);
        $manager->flush();
    }
}