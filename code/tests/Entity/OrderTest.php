<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Tests\GeneralTestMethod;
use DateTimeInterface;
use DateTime;
use DateTimeImmutable;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class OrderTest extends KernelTestCase
{
    private Order $order;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->order = new Order();

        $this->validator = GeneralTestMethod::getValidator();
    }

    /********
     * Test *
     ********/

    /** @dataProvider validOrderDate */
    public function testSetValidOrderDate(DateTimeInterface $validDate): void
    {
        $this->order->setDate($validDate);

        $violationList = $this->validator->validate($this->order);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("date", $violationList);
        $obtainedValue = $this->order->getDate();

        $this->assertSame($validDate, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider validOrderTotal */
    public function testSetValidOrderTotal(int $validTotal): void
    {
        $this->order->setTotal($validTotal);

        $violationList = $this->validator->validate($this->order);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("total", $violationList);
        $obtainedValue = $this->order->getTotal();

        $this->assertSame($validTotal, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidOrderTotal */
    public function testSetInvalidOrderTotal(int $invalidTotal): void
    {
        $this->order->setTotal($invalidTotal);

        $violationList = $this->validator->validate($this->order);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("total", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /*****************
     * Data Provider *
     *****************/

    /** @return Generator<array<int, DateTimeInterface>> */
    public function validOrderDate(): Generator
    {
        yield [new DateTime()];
        yield [new DateTimeImmutable()];
        yield [new DateTime("now + 2 minutes")];
        yield [new DateTimeImmutable("now + 2 minutes")];
        yield [new DateTime("now + 2 weeks")];
        yield [new DateTimeImmutable("now + 2 weeks")];
    }

    /** @return Generator<array<int, int>> */
    public function validOrderTotal(): Generator
    {
        yield [100];
        yield [1];
        yield [2000];
    }

    /** @return Generator<array<int, int>> */
    public function invalidOrderTotal(): Generator
    {
        yield [0];
        yield [-1];
        yield [-100];
        yield [-2000];
    }
}
