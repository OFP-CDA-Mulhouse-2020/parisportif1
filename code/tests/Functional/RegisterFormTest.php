<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterFormTest extends WebTestCase
{
    public function testGetRegistrationPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
    }

    public function testLoadRegistrationPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertSelectorTextContains('html h1', 'Hello RegisterController!');
    }
}
