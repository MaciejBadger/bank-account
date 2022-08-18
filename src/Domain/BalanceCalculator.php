<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\Transaction;

class BalanceCalculator
{
    public function calculate(float $currentBalance, Transaction $transaction): float
    {
        if ($transaction->getType() === 'income') {
            return $currentBalance + $transaction->getAmount();
        } else {
            if ($transaction->getAmount() > $currentBalance) {
                throw new \Exception(
                    sprintf('Current balance equals: %s, you cannot spend more than the limit', $currentBalance)
                );
            }
            return $currentBalance - $transaction->getAmount();
        }
    }
}
