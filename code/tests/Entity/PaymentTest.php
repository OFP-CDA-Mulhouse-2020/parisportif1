<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Payment;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class PaymentTest extends KernelTestCase
{
    private $payment;
    private $validator;

    protected function setUp(): void
    {
        $this->payment = new Payment();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfPayment(): void
    {
        $this->assertInstanceOf(Payment::class, $this->payment);
        $this->assertClassHasAttribute("amount", Payment::class);
        $this->assertClassHasAttribute("paymentDate", Payment::class);
        $this->assertClassHasAttribute("transactionID", Payment::class);
        $this->assertClassHasAttribute("description", Payment::class);
        $this->assertClassHasAttribute("wallet", Payment::class);
    }

    /**
     * @dataProvider validAmountProvider
     */
    public function testSetValidAmount($amount)
    {
        $this->payment->setAmount($amount);
        $errorsList = $this->validator->validate($this->payment);
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
        $this->payment->setAmount($amount);
        $errorsList = $this->validator->validate($this->payment);
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
    public function testSetValidPaymentDate($paymentDate)
    {
        $this->payment->setPaymentDate($paymentDate);
        $errorsList = $this->validator->validate($this->payment);
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
        $this->payment->setTransactionID($transactionID);
        $errorsList = $this->validator->validate($this->payment);
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
        $this->payment->setTransactionID($transactionID);
        $errorsList = $this->validator->validate($this->payment);
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
        $this->payment->setDescription($description);
        $errorsList = $this->validator->validate($this->payment);
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
        $this->payment->setDescription($description);
        $errorsList = $this->validator->validate($this->payment);
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
