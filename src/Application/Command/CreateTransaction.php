<?php

declare(strict_types=1);

namespace App\Application\Command;

class CreateTransaction
{
    public function __construct(
        public readonly string $walletId,
        public readonly float $amount,
        public readonly string $type
    ) {
    }
}
