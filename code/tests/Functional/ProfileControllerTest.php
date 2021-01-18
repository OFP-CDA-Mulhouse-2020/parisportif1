<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        
        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz@a";

        $crawler = $client->submit($form);
        $this->assertResponseRedirects('/profile');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Hello World');
    }

    public function testLogout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/edit');

        
        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz@a";

        $crawler = $client->submit($form);
        $this->assertResponseRedirects('/profile');
        $client->followRedirect();
        //$this->assertSelectorTextContains('h1', 'Hello World');
        $crawler = $client->clickLink('Logout');

        /*
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');*/
    }

    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        
        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz@a";

        $crawler = $client->submit($form);
        $this->assertResponseRedirects('/profile');
        $client->followRedirect();
        //$this->assertSelectorTextContains('h1', 'Hello World');
        $crawler = $client->clickLink('Edit');
        $this->assertResponseIsSuccessful();
        /*
        
        $this->assertSelectorTextContains('h1', 'Hello World');*/
    }
}
