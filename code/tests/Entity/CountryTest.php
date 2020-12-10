<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CountryTest extends KernelTestCase
{
    private $country;
    private $validator;

    protected function setUp(): void
    {
        $this->country = new Country();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfCountry(): void
    {
        $this->assertInstanceOf(Country::class, $this->country);
        $this->assertClassHasAttribute("name", Country::class);
    }

    /**
     * @dataProvider invalidCountryProvider
     */
    public function testSetInvalidCountry($country)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->country->setName($country);
        $this->assertSame($country ,$this->country->getName());
        
    }

    public function invalidCountryProvider(): array
    {
        return [
            ["france"],
            ["amerique"],
            ["japon"],
            ["allemagne"]
        ];
    }

    /**
     * @dataProvider validCountryProvider
     */
    public function testSetValidCountry($country)
    {
        $this->country->setName($country);
        $errorsList = $this->validator->validate($this->country);
        $this->assertEquals(0, count($errorsList));
    }

    public function validCountryProvider(): array
    {
        return [
            ["France"],
            ["Amerique"],
            ["Japon"],
            ["Allemagne"]
        ];
    }

}
