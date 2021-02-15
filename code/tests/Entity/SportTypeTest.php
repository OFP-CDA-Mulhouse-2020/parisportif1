<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\SportType;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SportTypeTest extends KernelTestCase
{
    private SportType $sportType;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->sportType = new SportType();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->sportType, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->sportType->setName($validName);

        $violationList = $this->validator->validate(
            $this->sportType,
            null,
            ['newSportType', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->sportType->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->sportType->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->sportType,
            null,
            ['newSportType', 'Default']
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
        $this->sportType->setDescription($validDescription);

        $violationList = $this->validator->validate(
            $this->sportType,
            null,
            ['newSportType', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );
        $obtainedValue = $this->sportType->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->sportType->setDescription($invalidDescription);

        $violationList = $this->validator->validate(
            $this->sportType,
            null,
            ['newSportType', 'Default']
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
}
