<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CalculateBalance;
use App\Domain\IncomeOperation;
use App\Domain\OutcomeOperation;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CalculateBalanceHandler implements MessageHandlerInterface
{
    /**
     * @throws \Exception
     */
    public function __invoke(CalculateBalance $command)
    {
        $wallet = $command->wallet;
        $transaction = $command->transaction;

        $operation = $transaction->getType() === 'income'
            ? new IncomeOperation()
            : new OutcomeOperation();

        $balance = $operation->calculate($wallet->getBalance(), $transaction->getAmount());
        $wallet->setBalance($balance);
    }
}
