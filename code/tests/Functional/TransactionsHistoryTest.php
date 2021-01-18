<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TransactionsHistoryTest extends WebTestCase
{
    public function testGeTransactionsHistoryPageWhenNotLoggedIn()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transactions-history');

        $this->assertResponseRedirects('/login');
    }
}
