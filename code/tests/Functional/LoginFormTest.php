<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LoginFormTest extends WebTestCase
{
    public function testGetLoginPage()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testLoadForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertSelectorExists('form', "not form exist");
        $this->assertCount(1, $crawler->filter('form'), "form exist");

        $this->assertSelectorExists('input[name*=email]', "not input email exist");
        $this->assertCount(1, $crawler->filter('input[name*=email]'), "input email exist");

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

        $client->submit($form);
        $this->assertResponseRedirects('/profile');
        $client->followRedirect();
    }

    public function testLoginPageInvalid()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->filter('form')->form();
        $form['email'] = "test@test.fr";
        $form['password'] = "Test95qz";

        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }
}
