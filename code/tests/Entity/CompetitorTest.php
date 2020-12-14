<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Competitor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CompetitorTest extends KernelTestCase
{
    private $competitor;
    private $validator;

    protected function setUp(): void
    {
        $this->competitor = new Competitor();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCompetitor(): void
    {
        $this->assertInstanceOf(Competitor::class, $this->competitor);
        $this->assertClassHasAttribute("name", Competitor::class);
    }

    /**
     * @dataProvider invalidCompetitorNameProvider
     */
    public function testSetInvalidCompetitorName(string $name): void
    {
        $this->competitor->setName($name);
        $errorsList = $this->validator->validate($this->competitor);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidCompetitorNameProvider(): array
    {
        return [[""]];
    }

    /**
     * @dataProvider validCompetitorNameProvider
     */
    public function testSetValidCompetitorName(string $name): void
    {
        $this->competitor->setName($name);
        $errorsList = $this->validator->validate($this->competitor);
        $this->assertEquals(0, count($errorsList));
    }

    public function validCompetitorNameProvider(): array
    {
        return [["Pierre de Coubertin"]];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitor = null;
        $this->validator = null;
    }
}
