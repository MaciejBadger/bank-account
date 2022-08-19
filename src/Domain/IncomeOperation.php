<?php

declare(strict_types=1);

namespace App\Domain;

class IncomeOperation implements OperationInterface
{
    public function calculate(float $currentBalance, float $transactionAmount): float
    {
        return $currentBalance + $transactionAmount;
    }
}
