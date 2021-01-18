<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TransactionsHistoryTest extends WebTestCase
{
    public function testGetTransactionsHistoryPageWhenNotLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/transactions-history');

        $this->assertResponseRedirects('/login');
    }

    public function testGetTransactionsHistoryPageWhenLoggedIn(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail("test@test.fr");
        $client->loginUser($testUser);

        $client->request('GET', '/transactions-history');

        $this->assertResponseRedirects('/login');
    }

    public function testGetTransactionsHistoryPageWhenLoggedIn(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail("test@test.fr");
        // $client->loginUser($testUser);

        $crawler = $client->request('GET', '/transactions-history');

        $this->assertResponseIsSuccessful();
    }
}
