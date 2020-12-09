<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Event;
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



}
