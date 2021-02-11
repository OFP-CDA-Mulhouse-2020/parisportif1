<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Competitor;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CompetitorTest extends KernelTestCase
{
    private Competitor $competitor;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->competitor = new Competitor();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->competitor, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validNameProvider */
    public function testSetValidName(string $validName): void
    {
        $this->competitor->setName($validName);

        $violationList = $this->validator->validate(
            $this->competitor,
            null,
            ['newCompetitor', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "name",
            $violationList
        );
        $obtainedValue = $this->competitor->getName();

        $this->assertSame($validName, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidNameProvider */
    public function testSetInvalidName(string $invalidName): void
    {
        $this->competitor->setName($invalidName);

        $violationList = $this->validator->validate(
            $this->competitor,
            null,
            ['newCompetitor', 'Default']
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
        $this->competitor->setCountryCode($validCountryCode);

        $violationList = $this->validator->validate(
            $this->competitor,
            null,
            ['newCompetitor', 'Default']
        );
        $violationOnAttribute = GeneralTestMethod::isViolationOn(
            "countryCode",
            $violationList
        );
        $obtainedValue = $this->competitor->getCountryCode();

        $this->assertSame($validCountryCode, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> */
    public function validNameProvider(): Generator
    {
        yield ["John Smith"];
        yield ["Luc Isadore"];
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
}
