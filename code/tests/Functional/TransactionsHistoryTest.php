<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TransactionsHistoryTest extends WebTestCase
{
    public function testGeTransactionsHistoryPageWhenLoggedIn()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transactions-history');

        $this->assertResponseIsSuccessful();
    }
}
