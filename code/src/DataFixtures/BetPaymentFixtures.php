<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BetPayment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class BetPaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1000; $i > 0; $i -= 100) {
            $betPayment = new BetPayment();

            $even = ($i % 200 === 0);
            $amount = $even ? $i : -$i;

            $betPayment->setAmount($amount);
            $betPayment->setDate(new DateTimeImmutable("now - " . $i . " hours"));
            $betPayment->setTransactionID(uniqid("payment" . $i, true));
            $betPayment->setDescription("Payment of amount: " . $amount);
            $betPayment->setWallet($this->getReference(WalletFixtures::WALLET_REFERENCE));

            $manager->persist($betPayment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            WalletFixtures::class,
        );
    }
}
