<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Status;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class StatusTest extends KernelTestCase
{
    private Status $status;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->status = new Status();

        $this->validator = GeneralTestMethod::getValidator();
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->status->setName($validName);

        $violationList = $this->validator->validate(
            $this->status,
            null,
            ['newStatus', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->status->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->status->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->status,
            null,
            ['newStatus', 'Default']
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
        $this->status->setDescription($validDescription);

        $violationList = $this->validator->validate(
            $this->status,
            null,
            ['newStatus', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "description",
            $violationList
        );
        $obtainedValue = $this->status->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->status->setDescription($invalidDescription);

        $violationList = $this->validator->validate(
            $this->status,
            null,
            ['newStatus', 'Default']
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
        yield ["Substitute"];
        yield ["Player"];
    }

    /** @return Generator<array<int, string>> */
    public function invalidNameProvider(): Generator
    {
        yield [""];
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
    }
}
