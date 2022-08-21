<?php

declare(strict_types=1);

namespace App\Domain;

class OutcomeOperation implements OperationInterface
{
    public function calculate(float $currentBalance, float $transactionAmount): float
    {
        if ($transactionAmount > $currentBalance) {
            throw new \Exception(
                sprintf('Current balance equals: %s, you cannot spend more than current balance', $currentBalance)
            );
        }
        return $currentBalance - $transactionAmount;
    }
}
