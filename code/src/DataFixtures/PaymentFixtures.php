<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Payment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1000; $i > 0; $i -= 100) {
            $payment = new Payment();

            $even = ($i % 200 === 0);
            $amount = $even ? $i : -$i;

            $payment->setAmount($amount);
            $payment->setPaymentDate(new DateTimeImmutable("now - " . $i . " hours"));
            $payment->setTransactionID(uniqid("payment" . $i, true));
            $payment->setDescription("Payment of amount: " . $amount);
            $payment->setWallet($this->getReference(WalletFixtures::WALLET_REFERENCE));

            $manager->persist($payment);
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
