<?php

declare(strict_types=1);

namespace App\Domain;

interface OperationInterface
{
    public function calculate(float $currentBalance, float $transactionAmount): float;
}
