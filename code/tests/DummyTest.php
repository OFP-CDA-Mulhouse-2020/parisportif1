<?php

use PHPUnit\FrameWork\TestCase;

class DummyTest extends TestCase
{
    public function testString()
    {
        $dummyString = new Dummy();
        $dummyString->setDummyStr("helloworld");
        $this->assertSame("helloworld", $dummyString->get());
    }
}