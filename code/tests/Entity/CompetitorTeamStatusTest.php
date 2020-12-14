<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CompetitorTeamStatus;
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
    public function testSetValidCompetitorTeamStatusDate()
    {
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->competitorTeamStatus = null;
        $this->validator = null;
    }
}
