<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Competitor;
use App\Entity\CompetitorTeamStatus;
use App\Entity\Status;
use App\Entity\Team;
use App\Tests\GeneralTestMethod;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CompetitorTeamStatusTest extends KernelTestCase
{
    private CompetitorTeamStatus $competitorTeamStatus;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->competitorTeamStatus = new CompetitorTeamStatus();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->validator, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider dateProvider */
    public function testSetDate(DateTimeInterface $date): void
    {
        $this->competitorTeamStatus->setDate($date);

        $this->assertSame($date, $this->competitorTeamStatus->getDate());
    }

    /** @dataProvider validCompetitorProvider */
    public function testSetValidCompetitor(Competitor $validCompetitor): void
    {
        $this->competitorTeamStatus->setCompetitor($validCompetitor);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newCompetitor', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competitor",
            $violationList
        );
        $obtainedValue = $this->competitorTeamStatus->getCompetitor();

        $this->assertSame($validCompetitor, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidCompetitorProvider */
    public function testSetInvalidCompetitor(Competitor $invalidCompetitor): void
    {
        $this->competitorTeamStatus->setCompetitor($invalidCompetitor);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newCompetitor', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "competitor",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validTeamProvider */
    public function testSetValidTeam(Team $validTeam): void
    {
        $this->competitorTeamStatus->setTeam($validTeam);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "team",
            $violationList
        );
        $obtainedValue = $this->competitorTeamStatus->getTeam();

        $this->assertSame($validTeam, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidTeamProvider */
    public function testSetInvalidTeam(Team $invalidTeam): void
    {
        $this->competitorTeamStatus->setTeam($invalidTeam);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "team",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validStatusProvider */
    public function testSetValidStatus(Status $validStatus): void
    {
        $this->competitorTeamStatus->setStatus($validStatus);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newStatus', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "status",
            $violationList
        );
        $obtainedValue = $this->competitorTeamStatus->getStatus();

        $this->assertSame($validStatus, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidStatusProvider */
    public function testSetInvalidStatus(Status $invalidStatus): void
    {
        $this->competitorTeamStatus->setStatus($invalidStatus);

        $violationList = $this->validator->validate(
            $this->competitorTeamStatus,
            null,
            ['newCompetitorTeamStatus', 'newStatus', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "status",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, DateTimeInterface>> */
    public function dateProvider(): Generator
    {
        yield [new DateTime()];
        yield [new DateTimeImmutable()];
    }

    /** @return Generator<array<int, Competitor>> */
    public function validCompetitorProvider(): Generator
    {
        yield [
            (new Competitor())
                ->setName("John Smith")
                ->setCountryCode('US')
        ];
        yield [
            (new Competitor())
                ->setName("Jean Luchen")
                ->setCountryCode('FR')
        ];
    }

    /** @return Generator<array<int, Competitor>> */
    public function invalidCompetitorProvider(): Generator
    {
        yield [
            (new Competitor())
                ->setName("John Smith")
        ];
        yield [
            (new Competitor())
                ->setCountryCode('FR')
        ];
    }

    /** @return Generator<array<int, Team>> */
    public function validTeamProvider(): Generator
    {
        yield [
            (new Team())
                ->setName('Lazer')
                ->setDescription(null)
                ->setCountryCode('US')
        ];
        yield [
            (new Team())
                ->setName('Paris Saint-Germain')
                ->setDescription(null)
                ->setCountryCode('FR')
        ];
    }

    /** @return Generator<array<int, Team>> */
    public function invalidTeamProvider(): Generator
    {
        yield [
            (new Team())
                ->setName('Lazer')
        ];
        yield [
            (new Team())
                ->setCountryCode('FR')
        ];
    }

    /** @return Generator<array<int, Status>> */
    public function validStatusProvider(): Generator
    {
        yield [
            (new Status)
                ->setName("Substitute")
                ->setDescription("Valid description")
        ];
        yield [
            (new Status)
                ->setName("Player")
                ->setDescription("Another valid description")
        ];
    }

    /** @return Generator<array<int, Status>> */
    public function invalidStatusProvider(): Generator
    {
        yield [
            (new Status)
                ->setName("Substitute")
        ];
        yield [
            (new Status)
                ->setDescription("Another valid description")
        ];
    }
}
