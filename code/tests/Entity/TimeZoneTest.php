<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\TimeZone;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class TimeZoneTest extends KernelTestCase
{
    private $timeZone;
    private $validator;

    protected function setUp(): void
    {
        $this->timeZone = new TimeZone();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfTimeZone(): void
    {
        $this->assertInstanceOf(TimeZone::class, $this->timeZone);
        $this->assertClassHasAttribute("name", TimeZone::class);
        $this->assertClassHasAttribute("code", TimeZone::class);
    }

    /**
     * @dataProvider validTimeZoneNameProvider
     */
    public function testSetValidTimeZoneName($name)
    {
        $this->timeZone->setName($name);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertEquals(0, count($errorsList));
    }

    public function validTimeZoneNameProvider(): array
    {
        return [
            ["France"],
        ];
    }

    /**
     * @dataProvider invalidTimeZoneNameProvider
     */
    public function testSetInvalidTimeZoneName(string $name): void
    {
        $this->timeZone->setName($name);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidTimeZoneNameProvider(): array
    {
        return [
            [""],
            ["F"],
        ];
    }


    /**
     * @dataProvider validTimeZoneCodeProvider
     */
    public function testSetValidTimeZoneCode($code)
    {
        $this->timeZone->setCode($code);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertEquals(0, count($errorsList));
    }

    public function validTimeZoneCodeProvider(): array
    {
        return [
            ['Europe/Paris']
        ];
    }

    /**
     * @dataProvider invalidTimeZoneCodeProvider
     */
    public function testSetInvalidTimeZoneCode(string $code): void
    {
        $this->timeZone->setName($code);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidTimeZoneCodeProvider(): array
    {
        return [
            [""],
            ["G"],
        ];
    }
}
