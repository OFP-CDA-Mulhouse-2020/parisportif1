<?php

use App\Entity\Dummy;
use PHPUnit\Framework\TestCase;

class DummyTest extends TestCase
{

    public function testString()
    {
        $dummyString = new Dummy();
        $dummyString->setDummyString("helloworld");
        $this->assertSame("helloworld", $dummyString->getDummyString());
    }

    public function testInvalidString()
    {
        $dummyString = new Dummy();
        $this->expectException(\InvalidArgumentException::class);
        $dummyString->setDummyString("5");
    }

    public function testInteger()
    {
        $dummyInteger = new Dummy();
        $dummyInteger->setDummyInteger(55);
        $this->assertEquals(55, $dummyInteger->getDummyInteger());
    }
}
