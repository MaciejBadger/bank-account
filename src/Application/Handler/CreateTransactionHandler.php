<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateTransaction;
use App\Domain\BalanceCalculator;
use App\Domain\Entity\Transaction;
use App\Domain\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateTransactionHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly BalanceCalculator $balanceCalculator
    ) {
    }

    public function __invoke(CreateTransaction $createTransaction)
    {
        $wallet = $this->walletRepository->get($createTransaction->walletId);

        $transaction = new Transaction(
            $createTransaction->amount,
            $createTransaction->type
        );
        $wallet->addTransaction($transaction);
        $balance = $this->balanceCalculator->calculate($wallet->getBalance(), $transaction);
        $wallet->setBalance($balance);
        $this->entityManager->flush();
    }
}
