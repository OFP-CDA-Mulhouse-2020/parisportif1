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
        $this->expectException(\InvalidArgumentException::class);
        $dummyString = new Dummy();
        $dummyString->setDummyString("a");
    }

    public function testInteger()
    {
        $dummyInterger = new Dummy();
        $dummyInterger->setDummyInterger('55');
    }
}
