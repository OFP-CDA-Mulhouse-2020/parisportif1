<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\SportType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SportTypeTest extends KernelTestCase
{
    private $sportType;
    private $validator;

    protected function setUp(): void
    {
        $this->sportType = new Sport();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCompetitor(): void
    {
        $this->assertInstanceOf(Sport::class, $this->sportType);
        $this->assertClassHasAttribute("name", Sport::class);
        $this->assertClassHasAttribute("description", Sport::class);
    }

    /**
     * @dataProvider invalidNameProvider
     */
    public function testSetInvalidName(string $name): void
    {
        $this->sportType->setName($name);
        $errorsList = $this->validator->validate($this->sportType);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidNameProvider(): array
    {
        return [
            [""],
            ["T"]
        ];
    }

    /**
     * @dataProvider validNameProvider
     */
    public function testSetValidName(string $name): void
    {
        $this->sportType->setName($name);
        $errorsList = $this->validator->validate($this->sportType);
        $this->assertEquals(0, count($errorsList));
    }

    public function validNameProvider(): array
    {
        return [
            ["BasketBall"]
        ];
    }


        /**
     * @dataProvider invalidDescriptionProvider
     */
    public function testSetInvalidDescription(string $description): void
    {
        $this->sportType->setName($description);
        $errorsList = $this->validator->validate($this->sportType);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidDescriptionProvider(): array
    {
        return [
            [""],
            ["h"]
        ];
    }

    /**
     * @dataProvider validDescriptionProvider
     */
    public function testSetValidDescription(string $description): void
    {
        $this->sportType->setName($description);
        $errorsList = $this->validator->validate($this->sportType);
        $this->assertEquals(0, count($errorsList));
    }

    public function validDescriptionProvider(): array
    {
        return [
            ["Lorem ipsum dolor sit amet."]
            
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitor = null;
        $this->validator = null;
    }
}
