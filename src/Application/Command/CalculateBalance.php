<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\Wallet;

class CalculateBalance
{
    public function __construct(
        public readonly Wallet $wallet,
        public readonly Transaction $transaction
    ) {
    }
}
