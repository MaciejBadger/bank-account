<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CalculateBalance;
use App\Application\Command\CreateTransaction;
use App\Domain\Entity\Transaction;
use App\Domain\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateTransactionHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function __invoke(CreateTransaction $command)
    {
        $wallet = $this->walletRepository->get($command->walletId);

        $transaction = new Transaction(
            (float) $command->amount,
            $command->type
        );
        $wallet->addTransaction($transaction);

        $this->commandBus->dispatch(
            new CalculateBalance($wallet, $transaction)
        );
        $this->entityManager->flush();
    }
}
