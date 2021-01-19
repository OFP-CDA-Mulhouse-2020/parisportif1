<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $payment = new Payment();

        $payment->setWallet($this->getReference(WalletFixtures::WALLET_REFERENCE));

        $manager->persist($payment);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            WalletFixtures::class,
        );
    }
}
