<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RegisterFormTest extends WebTestCase
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
        $form["register_form[lastname]"] = "test";
        $form["register_form[firstname]"] = "test";

        $crawler = $client->submit($form);
        $this->assertResponseIsSuccessful();
    }

    public function testSubmitRegistrationPage()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request("GET", "/register");

        $form = $crawler->filter("form")->form();
        $form["register_form[email]"] = "doe.j@codeur.online";
        $form["register_form[password]"] = "!ohNdoe1";
        $form["register_form[lastname]"] = "DOE";
        $form["register_form[firstname]"] = "John";

        $crawler = $client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("title", "Welcome!");

        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail("doe.j@codeur.online");
        $this->assertInstanceOf(User::class, $user);
    }
}
