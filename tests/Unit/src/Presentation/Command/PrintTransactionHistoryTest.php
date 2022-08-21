<?php

declare(strict_types=1);

namespace App\Tests\Unit\src\Presentation\Command;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\Wallet;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Presentation\Command\PrintTransactionHistory;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class PrintTransactionHistoryTest extends KernelTestCase
{
    private readonly WalletRepositoryInterface|MockObject $walletRepositoryMock;

    private readonly SerializerInterface|MockObject $serializerMock;

    protected function setUp(): void
    {
        $this->walletRepositoryMock = $this->createMock(WalletRepositoryInterface::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);
        $filesystemMock = $this->createMock(Filesystem::class);

        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(
            new PrintTransactionHistory(
                $this->walletRepositoryMock,
                $this->serializerMock,
                $filesystemMock,
                $kernel->getProjectDir()
            )
        );
        $command = $application->find('app:print-transaction-history');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecute(): void
    {
        $wallet = new Wallet();
        $transaction = new Transaction(200, 'income');
        $wallet->addTransaction($transaction);

        $this->walletRepositoryMock
            ->method('get')
            ->with('096fabd2-c673-4e5b-abd2-601ac82bfc76')
            ->willReturn($wallet);

        $this->serializerMock
            ->method('serialize')
            ->willReturn(
                "amount;type;id\n
                200;income;118b2f31-6c8c-40b4-8e19-138c6d66e213\n"
            );

        $this->commandTester->execute([
            'id' => '096fabd2-c673-4e5b-abd2-601ac82bfc76',
            'filename' => 'sample.csv'
        ]);
        $this->commandTester->assertCommandIsSuccessful();
    }
}
