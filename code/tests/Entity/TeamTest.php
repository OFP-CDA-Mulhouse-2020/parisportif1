<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Team;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TeamTest extends KernelTestCase
{
    private Team $team;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->team = new Team();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->team, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->team->setName($validName);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->team->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->team->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validCountryCodeProvider */
    public function testSetValidCountryCode(string $validCountryCode): void
    {
        $this->team->setCountryCode($validCountryCode);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "countryCode",
            $violationList
        );
        $obtainedValue = $this->team->getCountryCode();

        $this->assertSame($validCountryCode, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidCountryCodeProvider */
    public function testSetInvalidCountryCode(string $invalidCountryCode): void
    {
        $this->team->setCountryCode($invalidCountryCode);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "countryCode",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validDescriptionProvider */
    public function testSetValidDescription(?string $validDescription): void
    {
        $this->team->setDescription($validDescription);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );
        $obtainedValue = $this->team->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->team->setDescription($invalidDescription);

        $violationList = $this->validator->validate(
            $this->team,
            null,
            ['newTeam', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validNameProvider(): Generator
    {
        yield ["Cubs"];
        yield ["Destroyers"];
        yield ["Vipers"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidNameProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["   "];
    }

    /** @return Generator<array<int, string>> */
    public function validCountryCodeProvider(): Generator
    {
        yield ["FR"];
        yield ["US"];
        yield ["GB"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidCountryCodeProvider(): Generator
    {
        yield [""];
        yield ["France"];
    }

    /** @return Generator<array<int|null, string|null>> */
    public function validDescriptionProvider(): Generator
    {
        yield [null];
        yield ["Valid description"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidDescriptionProvider(): Generator
    {
        yield [""];
        yield [" "];
        yield ["   "];
    }
}
