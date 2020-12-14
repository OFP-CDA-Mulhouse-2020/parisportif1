<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SportTest extends KernelTestCase
{
    private $sport;
    private $validator;

    protected function setUp(): void
    {
        $this->sport = new Sport();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCompetitor(): void
    {
        $this->assertInstanceOf(Sport::class, $this->sport);
        $this->assertClassHasAttribute("name", Sport::class);
        $this->assertClassHasAttribute("description", Sport::class);
    }

    /**
     * @dataProvider invalidNameProvider
     */
    public function testSetInvalidName(string $name): void
    {
        $this->sport->setName($name);
        $errorsList = $this->validator->validate($this->sport);
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
        $this->sport->setName($name);
        $errorsList = $this->validator->validate($this->sport);
        $this->assertEquals(0, count($errorsList));
    }

    public function validNameProvider(): array
    {
        return [
            ["FootBall"]
        ];
    }


        /**
     * @dataProvider invalidDescriptionProvider
     */
    public function testSetInvalidDescription(string $description): void
    {
        $this->sport->setName($description);
        $errorsList = $this->validator->validate($this->sport);
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
        $this->sport->setName($description);
        $errorsList = $this->validator->validate($this->sport);
        $this->assertEquals(0, count($errorsList));
    }

    public function validDescriptionProvider(): array
    {
        return [
            ["Hello Word"]
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitor = null;
        $this->validator = null;
    }
}
