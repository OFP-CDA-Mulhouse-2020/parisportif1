<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CompetitorTeamStatus;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CompetitorTeamStatusTest extends KernelTestCase
{
    private ?CompetitorTeamStatus $competitorTeamStatus;
    private ?ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->competitorTeamStatus = new CompetitorTeamStatus();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCompetitorTeamStatus()
    {
        $this->assertInstanceOf(CompetitorTeamStatus::class, $this->competitorTeamStatus);
        $this->assertClassHasAttribute("date", CompetitorTeamStatus::class);
    }

    /**
     * @dataProvider validCompetitorTeamStatusDate
     */
    public function testSetValidCompetitorTeamStatusDate(DateTimeInterface $date): void
    {
        $this->competitorTeamStatus->setDate($date);
        $errorsList = $this->validator->validate($this->competitorTeamStatus);
        $this->assertEquals(0, count($errorsList));
    }

    public function validCompetitorTeamStatusDate(): array
    {
        return [[new DateTimeImmutable("tomorrow")]];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitorTeamStatus = null;
        $this->validator = null;
    }
}
