<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Wallet;

interface WalletRepositoryInterface
{
    public function add(Wallet $wallet): void;

    public function get(string $id): Wallet;
}
