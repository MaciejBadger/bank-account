<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateWalletControllerTest extends WebTestCase
{
    public function testWalletCreation(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/wallet');
        $this->assertResponseStatusCodeSame(201);
    }
}
