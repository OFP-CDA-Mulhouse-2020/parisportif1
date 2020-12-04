<?php

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterFormTest extends WebTestCase
{
    public function testGetRegistrationPage()
    {
        $client = static::createClient();
        $crawler = $client->request("GET", "/register");

        $this->assertResponseIsSuccessful();
    }

    public function testLoadRegistrationPage()
    {
        $client = static::createClient();
        $crawler = $client->request("GET", "/register");

        $form = $crawler->filter("form")->form();
        $form["register_form[email]"] = "test@test.fr";
        $form["register_form[password]"] = "Test95qz@a";
        $form["register_form[gender]"] = "male";
        $form["register_form[lastname]"] = "test";
        $form["register_form[firstname]"] = "test";
        $form["register_form[address]"] = "10 Rue de tarte au pomme 98432";
        $form["register_form[userStatus]"] = true;
        $form["register_form[UserSuspended]"] = true;
        $form["register_form[userDeleted]"] = true;

        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSubmitRegistrationPage()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request("GET", "/register");

        $form = $crawler->filter("form")->form();
        $form["register_form[email]"] = "test@test.fr";
        $form["register_form[password]"] = "Test95qz@a";

        $crawler = $client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("title", "Welcome!");

        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail("test@test.fr");
    }
}
