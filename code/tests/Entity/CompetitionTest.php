<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Competition;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CompetitionTest extends KernelTestCase
{
    private Competition $competition;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->competition = new Competition();

        $kernel = self::bootKernel();
        $kernel->boot();

        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCompetition(): void
    {
        $this->assertInstanceOf(Competition::class, $this->competition);
        $this->assertClassHasAttribute("name", Competition::class);
    }

    /**
     * @dataProvider invalidNameProvider
     */
    public function testSetInvalidCompetitionName(string $name)
    {
        $this->competition->setName($name);
        $errorsList = $this->validator->validate($this->competition);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidNameProvider(): array
    {
        return [[""]];
    }
}
