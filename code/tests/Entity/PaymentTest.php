<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BetPayment;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class PaymentTest extends KernelTestCase
{
    private $betPayment;
    private $validator;

    protected function setUp(): void
    {
        $this->betPayment = new BetPayment();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfPayment(): void
    {
        $this->assertInstanceOf(BetPayment::class, $this->betPayment);
        $this->assertClassHasAttribute("amount", BetPayment::class);
        $this->assertClassHasAttribute("betPaymentDate", BetPayment::class);
        $this->assertClassHasAttribute("transactionID", BetPayment::class);
        $this->assertClassHasAttribute("description", BetPayment::class);
        $this->assertClassHasAttribute("wallet", BetPayment::class);
    }

    /**
     * @dataProvider validAmountProvider
     */
    public function testSetValidAmount($amount)
    {
        $this->betPayment->setAmount($amount);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertEquals(0, count($errorsList));
    }

    public function validAmountProvider(): array
    {
        return [
            [1000],
            [10000],
            [100000]

        ];
    }

    /**
     * @dataProvider invalidAmountProvider
     */
    public function testSetInvalidAmount($amount)
    {
        $this->betPayment->setAmount($amount);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidAmountProvider(): array
    {
        return [
            [10]

        ];
    }

    /**
     * @dataProvider validPaymentDateProvider
     */
    public function testSetValidPaymentDate($betPaymentDate)
    {
        $this->betPayment->setBetPaymentDate($betPaymentDate);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertEquals(0, count($errorsList));
    }

    public function validPaymentDateProvider(): array
    {
        return [
            [new DateTime('@' . strtotime('now'))],

        ];
    }

    /**
     * @dataProvider invalidTransactionIDProvider
     */
    public function testSetInvalidTransactionID(string $transactionID): void
    {
        $this->betPayment->setTransactionID($transactionID);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidTransactionIDProvider(): array
    {
        return [
            [""],
            ["P"],
            ["M"],
        ];
    }

    /**
     * @dataProvider validTransactionIDProvider
     */
    public function testSetValidTransactionID($transactionID)
    {
        $this->betPayment->setTransactionID($transactionID);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertEquals(0, count($errorsList));
    }

    public function validTransactionIDProvider(): array
    {
        return [
            [uniqid()],
            [uniqid()],

        ];
    }

    /**
     * @dataProvider validDescriptionProvider
     */
    public function testSetValidDescription($description)
    {
        $this->betPayment->setDescription($description);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertEquals(0, count($errorsList));
    }

    public function validDescriptionProvider(): array
    {
        return [

            ["Payment de XXXX"],
            ["Virement de XXXX"],

        ];
    }

    /**
     * @dataProvider invalidDescriptionProvider
     */
    public function testSetInvalidDescription($description)
    {
        $this->betPayment->setDescription($description);
        $errorsList = $this->validator->validate($this->betPayment);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidDescriptionProvider(): array
    {
        return [
            [""],
            ["L"]

        ];
    }
}
