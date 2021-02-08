<?php

/**
 * @author  Etienne Schmitt <etienne@schmitt-etienne.fr>
 * @license GPL 2.0 or any later
 */

namespace App\Tests\Entity;

use App\Entity\WalletPayment;
use App\Tests\GeneralTestMethod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WalletPaymentTest extends KernelTestCase
{
    private WalletPayment $walletPayment;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->walletPayment = new WalletPayment();

        $this->validator = GeneralTestMethod::getValidator();
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider dateProvider */
    public function testSetDate(DateTimeInterface $date): void
    {
        $this->walletPayment->setDate($date);

        $violationList = $this->validator->validate($this->walletPayment);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("date", $violationList);
        $obtainedValue = $this->walletPayment->getDate();

        $this->assertSame($date, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider transactionIdProvider */
    public function testSetTransaction(string $transactionId): void
    {
        $this->walletPayment->setTransactionID($transactionId);

        $violationList = $this->validator->validate($this->walletPayment);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("transactionID", $violationList);
        $obtainedValue = $this->walletPayment->getTransactionID();

        $this->assertSame($transactionId, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider amountProvider */
    public function testSetAmount(int $amount): void
    {
        $this->walletPayment->setAmount($amount);

        $violationList = $this->validator->validate($this->walletPayment);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("amount", $violationList);
        $obtainedValue = $this->walletPayment->getAmount();

        $this->assertSame($amount, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, DateTimeInterface>> * */
    public function dateProvider(): Generator
    {
        yield [new DateTime()];
        yield [new DateTimeImmutable()];
        yield [new DateTime("now - 2 weeks")];
    }

    /** @return Generator<array<int, string>> * */
    public function transactionIdProvider(): Generator
    {
        yield [""];
        yield ["hello"];
        yield ["hello it's me!"];
    }

    /** @return Generator<array<int, int>> * */
    public function amountProvider(): Generator
    {
        yield [100];
        yield [1];
        yield [-50];
        yield [-200];
    }
}
