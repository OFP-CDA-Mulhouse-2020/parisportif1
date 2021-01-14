<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UserTest extends KernelTestCase
{
    private $user;
    private $validator;

    protected function setUp(): void
    {
        $this->user = new User();

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOfUser(): void
    {
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertClassHasAttribute("email", User::class);
        $this->assertClassHasAttribute("password", User::class);
        $this->assertClassHasAttribute("lastname", User::class);
        $this->assertClassHasAttribute("firstname", User::class);
        $this->assertClassHasAttribute("birthdate", User::class);
        $this->assertClassHasAttribute("creationDate", User::class);
        $this->assertClassHasAttribute("active", User::class);
        $this->assertClassHasAttribute("activeSince", User::class);
        $this->assertClassHasAttribute("suspended", User::class);
        $this->assertClassHasAttribute("suspendedSince", User::class);
        $this->assertClassHasAttribute("deleted", User::class);
        $this->assertClassHasAttribute("deletedSince", User::class);
        $this->assertClassHasAttribute("wallet", User::class);
    }

    public function testSetLastName()
    {
        $this->user->setLastname("Dupont");
        $this->assertSame("Dupont", $this->user->getLastname());
    }

    public function testSetLastNameInvalidated()
    {
        $this->expectException(\Exception::class);
        $this->user->setLastname("D");
        $this->assertSame("D", $this->user->getLastname());
    }

    //firstname
    public function testSetFirstName()
    {
        $this->user->setFirstname("Ben");
        $this->assertSame("Ben", $this->user->getFirstname());
    }


    public function testSetFirstNameInvalidated()
    {
        $this->expectException(\Exception::class);
        $this->user->setFirstname("B");
        $this->assertSame("B", $this->user->getFirstname());
    }


    /**
     * @dataProvider invalidEmailProvider
     */
    public function testSetInvalidEmail($email)
    {
        $this->user->setEmail($email);
        $errorsList = $this->validator->validate($this->user ,null , ['read']);
        $this->assertGreaterThan(0, count($errorsList));
    }

    public function invalidEmailProvider(): array
    {
        return [
            [""],
               
        ];
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function testSetValidEmail($email)
    {
        $this->user->setEmail($email);
        $errorsList = $this->validator->validate($this->user);
        $this->assertEquals(0, count($errorsList));
    }

    public function validEmailProvider(): array
    {
        return [
            ["doe.j@codeur.online"],
            ["john@doe.com"]
        ];
    }

    //password
    public function testPasswordValidated()
    {
        $this->user->setPassword("Test95qz@a");
        $this->assertSame("Test95qz@a", $this->user->getPassword());
    }

    public function testInvalidPassword()
    {
        $this->expectException(\Exception::class);
        $this->user->setPassword("pas");
        $this->assertSame("pas", $this->user->getPassword());
    }

    //boolean
    public function testActiveBool()
    {
        $this->user->setActive(true);
        $this->assertTrue($this->user->getActive());
    }

    public function testSuspendedBool()
    {
        $this->user->setSuspended(true);
        $this->assertTrue($this->user->getSuspended());
    }

    public function testDeletedBool()
    {
        $this->user->setDeleted(true);
        $this->assertTrue($this->user->getDeleted());
    }
}
