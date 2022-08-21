<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetBalanceControllerTest extends WebTestCase
{
    public function testGetBalanceSuccess(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/wallet/{id}/balance');
        $this->assertResponseStatusCodeSame(200);
    }
}
