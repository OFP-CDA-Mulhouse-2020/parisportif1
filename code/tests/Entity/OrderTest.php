<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Order;
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

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->order = null;
        $this->validator = null;
    }
}
