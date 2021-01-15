<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Wallet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class WalletTest extends KernelTestCase
{
    private $wallet;
    private $validator;

    protected function setUp(): void
    {
        $this->wallet = new Wallet();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfWallet(): void
    {
        $this->assertInstanceOf(Wallet::class, $this->wallet);
        $this->assertClassHasAttribute("balance", Wallet::class);
        $this->assertClassHasAttribute("user", Wallet::class);
    }

    /**
     * @dataProvider invalidWalletProvider
     */
    public function testSetInvalidWallet($balance): void
    {
        $this->wallet->setBalance($balance);
        $errorsList = $this->validator->validate($this->wallet);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidWalletProvider(): array
    {
        return [[1]];
    }

    /**
     * @dataProvider validWalletProvider
     */
    public function testSetValidWallet($balance): void
    {
        $this->wallet->setBalance($balance);
        $errorsList = $this->validator->validate($this->wallet);
        $this->assertEquals(0, count($errorsList));
    }

    public function validWalletProvider(): array
    {
        return [
            [10],
            [1000]
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitor = null;
        $this->validator = null;
    }
}
