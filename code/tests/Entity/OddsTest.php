<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Odds;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class OddsTest extends KernelTestCase
{
    private Odds $odds;
    private ValidatorInterface $validator;


    protected function setUp(): void
    {
        $this->odds = new Odds();

        $this->validator = GeneralTestMethod::getValidator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->odds, $this->validator);
    }

    /**************
     **** Test ****
     **************/

    /** @dataProvider validDescriptionProvider */
    public function testSetValidDescription(string $validDescription): void
    {
        $this->odds->setDescription($validDescription);

        $violationList = $this->validator->validate($this->odds, null, ['newOdds', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("description", $violationList);
        $obtainedValue = $this->odds->getDescription();

        $this->assertSame($validDescription, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidDescriptionProvider */
    public function testSetInvalidDescription(string $invalidDescription): void
    {
        $this->odds->setDescription($invalidDescription);

        $violationList = $this->validator->validate($this->odds, null, ['newOdds', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("description", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /** @dataProvider validOddsValueProvider */
    public function testSetValidOddsValue(float $validOddsValue): void
    {
        $this->odds->setOddsValue($validOddsValue);

        $violationList = $this->validator->validate($this->odds, null, ['newOdds', 'updateOdds', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsValue", $violationList);
        $obtainedValue = $this->odds->getOddsValue();

        $this->assertSame($validOddsValue, $obtainedValue);
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider invalidOddsValueProvider */
    public function testSetInvalidOddValueProvider(float $invalidOddValue): void
    {
        $this->odds->setOddsValue($invalidOddValue);

        $violationList = $this->validator->validate($this->odds, null, ['newOdds', 'updateOdds', 'Default']);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("oddsValue", $violationList);

        $this->assertGreaterThanOrEqual(1, count($violationList));
        $this->assertTrue($violationOnAttribute);
    }

    /***********************
     **** Data Provider ****
     ***********************/

    /** @return Generator<array<int, string>> * */
    public function validDescriptionProvider(): Generator
    {
        //TODO Change when description standardized
        yield ["Description"];
        yield ["Test"];
    }

    /** @return Generator<array<int, string>> * */
    public function invalidDescriptionProvider(): Generator
    {
        yield [""];
        yield ["e"];
    }

    /** @return Generator<array<int, float>> * */
    public function validOddsValueProvider(): Generator
    {
        yield [1.05];
        yield [7.55];
    }

    /** @return Generator<array<int, float>> * */
    public function invalidOddsValueProvider(): Generator
    {
        yield [1.00];
        yield [0.5];
        yield [-1.0];
    }
}
