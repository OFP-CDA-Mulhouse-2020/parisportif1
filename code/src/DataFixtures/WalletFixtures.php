<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class WalletFixtures extends Fixture
{
    public const WALLET_REFERENCE = "user-wallet";

    public function load(ObjectManager $manager)
    {
        $wallet = new Wallet();

        $wallet->setBalance(0);

        $manager->persist($wallet);
        $manager->flush();

        $this->addReference(self::WALLET_REFERENCE, $wallet);
    }
}
