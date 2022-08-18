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

    /**
     * @throws \Exception
     */
    public function __invoke(CreateTransaction $command)
    {
        $wallet = $this->walletRepository->get($command->walletId);

        $transaction = new Transaction(
            $command->amount,
            $command->type
        );
        $wallet->addTransaction($transaction);
        $balance = $this->balanceCalculator->calculate($wallet->getBalance(), $transaction);
        $wallet->setBalance($balance);
        $this->entityManager->flush();
    }
}
