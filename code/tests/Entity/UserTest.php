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
        $this->assertClassHasAttribute("isActived", User::class);
        $this->assertClassHasAttribute("UserSuspended", User::class);
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
    public function testisActivedBool()
    {
        $user = new User();
        $user->setisActived(true);
        $this->assertTrue($user->getisActived());
    }

    public function testUserSuspendedBool()
    {
        $user = new User();
        $user->setUserSuspended(true);
        $this->assertTrue($user->getUserSuspended());
    }

    public function testUserDeletedBool()
    {
        $user = new User();
        $user->setUserDeleted(true);
        $this->assertTrue($user->getUserDeleted());
    }
}
