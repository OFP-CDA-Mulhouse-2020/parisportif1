<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Wallet;
use App\Entity\WalletPayment;
use App\Tests\GeneralTestMethod;
use DateTime;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class WalletTest extends KernelTestCase
{
    private Wallet $wallet;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->wallet = new Wallet();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->validator, $this->wallet);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validBalanceProvider */
    public function testSetValidWallet(int $validBalance): void
    {
        $this->wallet->setBalance($validBalance);

        $violationList = $this->validator->validate($this->wallet, null, ['changeWalletBalance']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violationList);
        $obtainedValue = $this->wallet->getBalance();

        $this->assertSame($validBalance, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidBalanceProvider */
    public function testSetInvalidWallet(int $invalidBalance): void
    {
        $this->wallet->setBalance($invalidBalance);

        $violationList = $this->validator->validate($this->wallet, null, ['changeWalletBalance']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validWalletPaymentProvider */
    public function testAddValidPaymentToHistory(WalletPayment $validWalletPayment): void
    {
        $this->wallet->addWalletPaymentToHistory($validWalletPayment);

        $violationList = $this->validator->validate($this->wallet, null, ['updatePaymentHistory']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("walletPaymentHistory", $violationList);
        $obtainedValue = $this->wallet->getWalletPaymentHistory();

        $this->assertContains($validWalletPayment, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidWalletPaymentProvider */
    public function testAddInvalidPaymentToHistory(WalletPayment $invalidPayment): void
    {
        $this->wallet->addWalletPaymentToHistory($invalidPayment);

        $violationList = $this->validator->validate($this->wallet, null, ['updatePaymentHistory']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("walletPaymentHistory", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validWalletPaymentProvider */
    public function testRemovePaymentFromHistory(WalletPayment $payment): void
    {
        $this->wallet->addWalletPaymentToHistory($payment);

        $violationList = $this->validator->validate($this->wallet, null, ['updatePaymentHistory']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("walletPaymentHistory", $violationList);
        $obtainedValue = $this->wallet->getWalletPaymentHistory();

        $this->assertContains($payment, $obtainedValue);
        $this->assertFalse($violationOnAttribute);

        $this->wallet->removeWalletPaymentFromHistory($payment);

        $violationList = $this->validator->validate($this->wallet);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("walletPaymentHistory", $violationList);
        $obtainedValue = $this->wallet->getWalletPaymentHistory();

        $this->assertNotContains($payment, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider amountProvider */
    public function testAddToBalance(int $amount): void
    {
        $this->wallet->setBalance(0);
        $this->wallet->addToBalance($amount);

        $violationList = $this->validator->validate($this->wallet);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violationList);
        $obtainedValue = $this->wallet->getBalance();

        $this->assertSame($amount, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider amountProvider */
    public function testRemoveFromBalance(int $amount): void
    {
        $defaultBalanceValue = 50;
        $this->wallet->setBalance($defaultBalanceValue + $amount);
        $this->wallet->removeFromBalance($amount);

        $violationList = $this->validator->validate($this->wallet);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violationList);
        $obtainedValue = $this->wallet->getBalance();

        $this->assertSame($defaultBalanceValue, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, int>> */
    public function invalidBalanceProvider(): Generator
    {
        yield [-1];
        yield [-1000];
        yield [-2];
        yield [-1245];
    }

    /** @return Generator<array<int, int>> */
    public function validBalanceProvider(): Generator
    {
        yield [10];
        yield [1000];
    }

    /** @return Generator<array<int, WalletPayment>> * */
    public function validWalletPaymentProvider(): Generator
    {
        $walletPayment = new WalletPayment();
        $walletPayment->setAmount(500);
        $walletPayment->setDate(new DateTime());
        $walletPayment->setTransactionID('Bonjour'); //TODO Fix transactionID test once standardized


        yield [$walletPayment];

        $walletPayment->setAmount(200);
        yield [$walletPayment];

        $walletPayment->setDate(new DateTime('now - 2 weeks'));
        $walletPayment->setAmount(2000);
        yield [$walletPayment];
    }

    /** @return Generator<array<int, WalletPayment>> * */
    public function invalidWalletPaymentProvider(): Generator
    {
        yield [(new WalletPayment())->setAmount(500)];
        yield [(new WalletPayment())->setDate(new DateTime())];
    }

    /** @return Generator<array<int, int>> * */
    public function amountProvider(): Generator
    {
        yield [200];
        yield [300];
        yield [5000];
        yield [10000];
    }
}
