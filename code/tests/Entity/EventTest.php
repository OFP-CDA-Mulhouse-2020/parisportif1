<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Event;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EventTest extends KernelTestCase
{
    private $event;
    private $validator;

    protected function setUp(): void
    {
        $this->event = new Event();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfEvent(): void
    {
        $this->assertInstanceOf(Event::class, $this->event);
        $this->assertClassHasAttribute("name", Event::class);
        $this->assertClassHasAttribute("eventDate", Event::class);
        $this->assertClassHasAttribute("location", Event::class);
        $this->assertClassHasAttribute("illustration", Event::class);
        $this->assertClassHasAttribute("score", Event::class);
    }

    /**
     * @dataProvider invalidCountryProvider
     */
    public function testSetInvalidCountry($name)
    {
        $this->event->setName($name);
        $errorsList = $this->validator->validate($this->event);
        $this->assertEquals(0 , count($errorsList));
    }

    public function invalidCountryProvider(): array
    {
        return [
            ["paris vs lyon"],
            ["amerique vs japon"],
            ["japon vs chine"],
            ["allemagne vs mexique"]
        ];
    }

    /**
     * @dataProvider validNameProvider
     */
    public function testSetValidName($name)
    {
        $this->event->setName($name);
        $errorsList = $this->validator->validate($this->event);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validNameProvider(): array
    {
        return [
            ["Paris vs Lyon"],
            ["Amerique vs Japon"],
            ["Japon vs Chine"],
            ["Allemagne vs Mexique"]
        ];
    }


    /**
     * @dataProvider validEventDateProvider
     */
    public function testSetValidEventDate($eventDate)
    {
        $this->event->setEventDate($eventDate);
        $errorsList = $this->validator->validate($this->event);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validEventDateProvider(): array
    {
        return [
            [new \DateTime('@'.strtotime('now'))],
            [new \DateTime('@'.strtotime('now'))]
            
        ];
    }

}
