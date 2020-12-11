<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Status;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class StatusTest extends KernelTestCase
{
    private $status;
    private $validator;

    protected function setUp(): void
    {
        $this->status = new Status();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfEvent(): void
    {
        $this->assertInstanceOf(Status::class, $this->status);
        $this->assertClassHasAttribute("name", Status::class);
        $this->assertClassHasAttribute("description", Status::class);
    }

    /**
     * @dataProvider validStatusNameProvider
     */
    public function testSetvalidStatusName($name)
    {
        $this->status->setName($name);
        $errorsList = $this->validator->validate($this->status);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validStatusNameProvider(): array
    {
        return [
            ["Team France"],
        ];
    }


    /**
     * @dataProvider validStatusDescProvider
     */
    public function testSetvalidStatusDesc($description)
    {
        $this->status->setDescription($description);
        $errorsList = $this->validator->validate($this->status);
        $this->assertEquals(0 , count($errorsList));
    }

    public function validStatusDescProvider(): array
    {
        return [
            ["Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, consectetur!"],
        ];
    }
}
