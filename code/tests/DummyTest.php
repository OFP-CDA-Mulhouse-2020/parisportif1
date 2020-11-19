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

}
