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

    public function testInstanceOfEvent(): void
    {
        $this->assertInstanceOf(TimeZone::class, $this->timeZone);
        $this->assertClassHasAttribute("name", TimeZone::class);
        $this->assertClassHasAttribute("code", TimeZone::class);
    }

    /**
     * @dataProvider validTimeZoneNameProvider
     */
    public function testSetvalidTimeZoneName($name)
    {
        $this->timeZone->setName($name);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validTimeZoneNameProvider(): array
    {
        return [
            ["France"],
        ];
    }


    /**
     * @dataProvider validTimeZoneCodeProvider
     */
    public function testSetvalidTimeZoneCode($code)
    {
        $this->timeZone->setCode($code);
        $errorsList = $this->validator->validate($this->timeZone);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validTimeZoneCodeProvider(): array
    {
        return [
            ["GMT+1"],
        ];
    }
}