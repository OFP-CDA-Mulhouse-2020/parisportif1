<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

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
    public function testSetFirstName()
    {
        $user = new User();
        $user->setFirstname("Ben");
        $this->assertSame("Ben", $user->getFirstname());
    }
    public function testSetAddress()
    {
        $user = new User();
        $user->setAddress("10 Rue de tarte au pomme 98432");
        $this->assertSame("10 Rue de tarte au pomme 98432", $user->getAddress());
    }

    public function testEmailValidate()
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $this->assertSame("test@test.fr", $user->getEmail());
    }

    public function testPassword()
    {
        $user = new User();
        $user->setPassword("password");
        $this->assertSame("password", $user->getPassword());
    }

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
}
