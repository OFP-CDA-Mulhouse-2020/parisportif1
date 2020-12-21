<?php

declare (strict_types = 1);

namespace App\Tests\Entity;

use App\Entity\Odds;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class OddsTest extends KernelTestCase
{
    private $odds;
    private $validator;

    protected function setUp(): void
    {
        $this->odds = new Odds();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfStatus(): void
    {
        $this->assertInstanceOf(Odds::class, $this->odds);
        $this->assertClassHasAttribute("description", Odds::class);
        $this->assertClassHasAttribute("value", Odds::class);
    }

    /**
     * @dataProvider validDescriptionProvider
     */
    public function testSetvalidDescription($description)
    {
        $this->odds->setDescription($description);
        $errorsList = $this->validator->validate($this->odds);
        $this->assertEquals(0, count($errorsList));
    }

    public function validDescriptionProvider(): array
    {
        return [
            ["Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, consectetur!"],
        ];
    }

    /**
     * @dataProvider invalidDescriptionProvider
     */
    public function testSetInvalidDescription($description): void
    {
        $this->odds->setDescription($description);
        $errorsList = $this->validator->validate($this->odds);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidDescriptionProvider(): array
    {
        return [
            [""],
            ["L"],
        ];
    }

    /**
     * @dataProvider validOddsValueProvider
     */
    public function testSetvalidOddsValue(float $value)
    {
        $this->odds->setValue($value);
        $errorsList = $this->validator->validate($this->odds);
        $this->assertEquals(0, count($errorsList));
    }

    public function validOddsValueProvider(): array
    {
        return [
            [1.5],
            [5.3]
        ];
    }

    /**
     * @dataProvider invalidOddsValueProvider
     */
    public function testSetInvalidOddsValue(float $value): void
    {
        $this->odds->setValue($value);
        $errorsList = $this->validator->validate($this->odds);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidOddsValueProvider(): array
    {
        return [
            [0.5]
            
        ];
    }

    /**
     * @dataProvider validOddsWinningProvider
     */
    public function testSetValidWinning($value):void
    {
        $this->odds->setWinning($value);
        $errorsList = $this->validator->validate($this->odds);
        $this->assertEquals(0, count($errorsList));
    }

    public function validOddsWinningProvider(): array
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
        $this->odds = null;
        $this->validator = null;
    }

}
