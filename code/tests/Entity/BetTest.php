<?php

declare (strict_types = 1);

namespace App\Tests\Entity;

use App\Entity\Bet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BetTest extends KernelTestCase
{
    private $bet;
    private $validator;

    protected function setUp(): void
    {
        $this->bet = new Bet();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfStatus(): void
    {
        $this->assertInstanceOf(Bet::class, $this->bet);
        $this->assertClassHasAttribute("amount", Bet::class);
        $this->assertClassHasAttribute("odds", Bet::class);
        $this->assertClassHasAttribute("resolve", Bet::class);
    }



    /**
     * @dataProvider validBetAmountProvider
     */
    public function testSetvalidBetAmount(int $amount)
    {
        $this->bet->setAmount($amount);
        $errorsList = $this->validator->validate($this->bet);
        $this->assertEquals(0, count($errorsList));
    }

    public function validBetAmountProvider(): array
    {
        return [
            [10],
            [100]
        ];
    }

    /**
     * @dataProvider invalidBetAmountProvider
     */
    public function testSetInvalidOddsValue(int $amount): void
    {
        $this->bet->setAmount($amount);
        $errorsList = $this->validator->validate($this->bet);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidBetAmountProvider(): array
    {
        return [
            [1]
        ];
    }




    /**
     * @dataProvider validBetOddsProvider
     */
    public function testSetvalidBetOdds(float $odds)
    {
        $this->bet->setOdds($odds);
        $errorsList = $this->validator->validate($this->bet);
        $this->assertEquals(0, count($errorsList));
    }

    public function validBetOddsProvider(): array
    {
        return [
            [1.5],
            [5.3]
        ];
    }

    /**
     * @dataProvider invalidBetOddsProvider
     */
    public function testSetInvalidOdds(float $odds): void
    {
        $this->bet->setOdds($odds);
        $errorsList = $this->validator->validate($this->bet);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidBetOddsProvider(): array
    {
        return [
            [0.5]
            
        ];
    }

    /**
     * @dataProvider validBetResolveProvider
     */
    public function testSetValidWinning($resolve):void
    {
        $this->bet->setResolve($resolve);
        $errorsList = $this->validator->validate($this->bet);
        $this->assertEquals(0, count($errorsList));
    }

    public function validBetResolveProvider(): array
    {
        return [
            [true],
            [false],
            [false],
            
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->bet = null;
        $this->validator = null;
    }

}
