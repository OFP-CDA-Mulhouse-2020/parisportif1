<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Sport;
use App\Entity\SportType;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SportTest extends KernelTestCase
{
    private Sport $sport;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->sport = new Sport();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->sport, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->sport->setName($validName);

        $violationList = $this->validator->validate(
            $this->sport,
            null,
            ['newSport', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->sport->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->sport->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->sport,
            null,
            ['newSport', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validDescriptionProvider */
    public function testSetValidDescription(string $validDescription): void
    {
        $this->sport->setDescription($validDescription);

        $violationList = $this->validator->validate(
            $this->sport,
            null,
            ['newSport', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );
        $obtainedValue = $this->sport->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->sport->setDescription($invalidDescription);

        $violationList = $this->validator->validate(
            $this->sport,
            null,
            ['newSport', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validSportTypeProvider */
    public function testSetValidSportType(SportType $validSportType): void
    {
        $this->sport->setSportType($validSportType);

        $violationList = $this->validator->validate(
            $this->sport,
            null,
            ['newSport', 'newSportType', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "sportType",
            $violationList
        );
        $obtainedValue = $this->sport->getSportType();

        $this->assertSame($validSportType, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validNameProvider(): Generator
    {
        yield ["Individual"];
        yield ["Group"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidNameProvider(): Generator
    {
        yield [""];
        yield ["  "];
        yield ["   "];
    }

    /** @return Generator<array<int, string>> */
    public function validDescriptionProvider(): Generator
    {
        yield ["Valid description"];
        yield ["Another valid description"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidDescriptionProvider(): Generator
    {
        yield [""];
        yield ["  "];
        yield ["   "];
    }

    /** @return Generator<array<int, SportType>> */
    public function validSportTypeProvider(): Generator
    {
        yield [
            (new SportType())
                ->setName("Individual")
                ->setDescription("Valid description")
        ];
        yield [
            (new SportType())
                ->setName("Groups")
                ->setDescription("Another valid description")
        ];
    }

    /** @return Generator<array<int, SportType>> */
    public function invalidSportTypeProvider(): Generator
    {
        yield [
            (new SportType())
                ->setName("Individual")
        ];
        yield [
            (new SportType())
                ->setDescription("Another valid description")
        ];
    }
}
