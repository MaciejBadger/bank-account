<?php

declare(strict_types=1);

namespace App\Tests\Functional\Presentation\Controller;

use App\Domain\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateTransactionControllerTest extends WebTestCase
{
    public function testTransactionCreationSuccess(): void
    {
        $client = static::createClient();

        $wallet = new Wallet();

        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get('doctrine')->getManager();
        $em->persist($wallet);
        $em->flush();

        $client->request('POST', '/api/transaction', [
            'json' => [
                'walletId' => $wallet->getId()->toString(),
                'amount' => 200,
                'type' => 'income',
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(1, $wallet->getTransactions()->count());
        $this->assertEquals(200, $wallet->getBalance());
    }
}
