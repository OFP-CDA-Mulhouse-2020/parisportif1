<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BetPayment;
use App\Tests\GeneralTestMethod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BetPaymentTest extends KernelTestCase
{
    private BetPayment $betPayment;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->validator = GeneralTestMethod::getValidator();

        $this->betPayment = new BetPayment();
    }

    /********
     * Test *
     ********/

    /** @dataProvider validAmountProvider */
    public function testSetValidAmount(int $validAmount): void
    {
        $this->betPayment->setAmount($validAmount);

        $violationList = $this->validator->validate($this->betPayment, null, ['newBetPayment', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("amount", $violationList);
        $obtainedValue = $this->betPayment->getAmount();

        $this->assertSame($validAmount, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidAmountProvider */
    public function testSetInvalidAmount(int $invalidAmount): void
    {
        $this->betPayment->setAmount($invalidAmount);

        $violationList = $this->validator->validate($this->betPayment, null, ['newBetPayment', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("amount", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validPaymentDateProvider */
    public function testSetValidPaymentDate(DateTimeInterface $betPaymentDate): void
    {
        $this->betPayment->setDate($betPaymentDate);

        $violationList = $this->validator->validate($this->betPayment, null, ['newBetPayment', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("betPaymentDate", $violationList);
        $obtainedValue = $this->betPayment->getDate();

        $this->assertSame($betPaymentDate, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /**
     * @dataProvider validDescriptionProvider
     * @TODO Change to valid description once standardized
     */
    public function testSetValidDescription(string $validDescription): void
    {
        $this->betPayment->setDescription($validDescription);

        $violationList = $this->validator->validate($this->betPayment, null, ['newBetPayment', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("description", $violationList);
        $obtainedValue = $this->betPayment->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $description): void
    {
        $this->betPayment->setDescription($description);

        $violationList = $this->validator->validate($this->betPayment, null, ['newBetPayment', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("description", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /*****************
     * Data Provider *
     *****************/

    /** @return Generator<array<int, int>> */
    public function validAmountProvider(): Generator
    {
        yield [1000];
        yield [10000];
        yield [100000];
        yield [-1000];
        yield [-10000];
        yield [-100000];
    }

    /** @return Generator<array<int, int>> */
    public function invalidAmountProvider(): Generator
    {
        yield [10];
        yield [50];
        yield [-5];
        yield [-50];
        yield [-99];
        yield [99];
    }

    /** @return Generator<array<int, DateTimeInterface>> */
    public function validPaymentDateProvider(): Generator
    {
        yield [new DateTime()];
        yield [new DateTimeImmutable()];
        yield [new DateTime("2020-01-01")];
    }

    /** @return Generator<array<int, string>> */
    public function validDescriptionProvider(): Generator
    {
        yield ["Payment de XXXX"];
        yield ["Virement de XXXX"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidDescriptionProvider(): Generator
    {
        yield [""];
        yield ["L"];
    }
}
