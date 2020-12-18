<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Order;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class OrderTest extends KernelTestCase
{
    private ?Order $order;
    private ?ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->order = new Order();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfOrder(): void
    {
        $this->assertInstanceOf(Order::class, $this->order);
        $this->assertClassHasAttribute("date", Order::class);
    }

    /**
     * @dataProvider validOrderDate
     */
    public function testSetValidOrderDate(DateTimeInterface $date): void
    {
        $this->order->setDate($date);
        $errorsList = $this->validator->validate($this->order);
        $this->assertEquals(0, count($errorsList));
    }

    public function validOrderDate(): array
    {
        return [[new DateTimeImmutable("now")]];
    }

    /**
     * @dataProvider invalidOrderDate
     */
    public function testSetInvalidOrderDate(DateTimeInterface $date): void
    {
        $this->order->setDate($date);
        $errorsList = $this->validator->validate($this->order);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidOrderDate(): array
    {
        return [[new DateTimeImmutable("now - 1 minute")]];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->order = null;
        $this->validator = null;
    }
}
