<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Exception;

class UserTest extends TestCase
{
    public function testInstanceOfUser(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
        $this->assertClassHasAttribute('birthdate', User::class);
    }

    public function testSetGender()
    {
        $user = new User();
        $user->setGender("male");
        $this->assertSame("male", $user->getGender());
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
        $user->setLastname("Dupont");
        $this->assertSame("Dupont", $user->getLastname());
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
        $user->setFirstname("Ben");
        $this->assertSame("Ben", $user->getFirstname());
    }

    //adresse
    public function testSetAddress()
    {
        $user = new User();
        $user->setAddress("10 Rue de tarte au pomme 98432");
        $this->assertSame("10 Rue de tarte au pomme 98432", $user->getAddress());
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
    public function testUserStatusBool()
    {
        $user = new User();
        $user->setUserStatus(true);
        $this->assertTrue($user->getUserStatus());
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
