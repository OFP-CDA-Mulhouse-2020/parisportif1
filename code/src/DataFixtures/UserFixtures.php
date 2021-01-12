<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends Fixture
{

    private $encode;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encode = $encoder;
    }

    public function load(ObjectManager $manager )
    {
        $user = new User();

        $user->setEmail("test@test.fr");
        $user->setPassword($this->encode->encodePassword(
            $user,
            "Test95qz@a"
        ));
        $user->setFirstname("Ben");
        $user->setLastname("Dupont");
        $user->setBirthDate(new DateTimeImmutable("now"));
        $user->setCreationDate(new DateTimeImmutable("now"));

        $manager->persist($user);
        $manager->flush();
    }
}
