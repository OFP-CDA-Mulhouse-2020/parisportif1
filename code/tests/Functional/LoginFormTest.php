<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFormTest extends WebTestCase
{
    public function testGetLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testLoadForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        //check if the form exist
        $this->assertSelectorExists('form', "not form exist");
        $this->assertCount(1, $crawler->filter('form'), "form exist");
        //check if the input email exists
        $this->assertSelectorExists('input[name*=email]', "not input email exist");
        $this->assertCount(1, $crawler->filter('input[name*=email]'), "input email exist");
        //check if the input password exists
        $this->assertSelectorExists('input[name*=password]', "not input password exist");
        $this->assertCount(1, $crawler->filter('input[name*=password]'), "input password exist");
    }

   
    public function testLoginPage()
    {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz@a";

        $crawler = $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
    }

    public function testLoginPageInvalid()
    {
        // We expect an exception
        $this->expectException(\Exception::class);

        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz";
        
        $crawler = $client->submit($form);
        
    }
}
