<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Exception;

final class UserTest extends TestCase
{
    public function testInstanceOfUser(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
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
    }

    public function testSetLastName()
    {
        $user = new User();
        $user->setLastname("Dupont");
        $this->assertSame("Dupont", $user->getLastname());
    }

    public function testSetLastNameInvalidated()
    {
        $this->expectException(\Exception::class);
        $user = new User();
        $user->setLastname("D");
        $this->assertSame("D", $user->getLastname());
    }

    //firstname
    public function testSetFirstName()
    {
        $user = new User();
        $user->setFirstname("Ben");
        $this->assertSame("Ben", $user->getFirstname());
    }


    public function testSetFirstNameInvalidated()
    {
        $this->expectException(\Exception::class);
        $user = new User();
        $user->setFirstname("B");
        $this->assertSame("B", $user->getFirstname());
    }

    //email
    public function testEmailValidated()
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $this->assertSame("test@test.fr", $user->getEmail());
    }

    public function testEmailInvalidated()
    {
        $this->expectException(\Exception::class);
        $user = new User();
        $user->setEmail("test@test");
        $this->assertSame("test@test", $user->getEmail());
    }

    //password
    public function testPasswordValidated()
    {
        $user = new User();
        $user->setPassword("Test95qz@a");
        $this->assertSame("Test95qz@a", $user->getPassword());
    }

    public function testInvalidPassword()
    {
        $this->expectException(\Exception::class);
        $user = new User();
        $user->setPassword("pas");
        $this->assertSame("pas", $user->getPassword());
    }

    //boolean
    public function testActiveBool()
    {
        $user = new User();
        $user->setActive(true);
        $this->assertTrue($user->getActive());
    }

    public function testSuspendedBool()
    {
        $user = new User();
        $user->setSuspended(true);
        $this->assertTrue($user->getSuspended());
    }

    public function testdeletedBool()
    {
        $user = new User();
        $user->setdeleted(true);
        $this->assertTrue($user->getdeleted());
    }
}
