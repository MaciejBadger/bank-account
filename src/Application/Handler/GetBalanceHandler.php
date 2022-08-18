<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Query\GetBalanceQuery;
use App\Domain\Repository\WalletRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetBalanceHandler implements MessageHandlerInterface
{
    public function __construct(private readonly WalletRepositoryInterface $walletRepository)
    {
    }

    public function __invoke(GetBalanceQuery $query): float
    {
        $wallet = $this->walletRepository->get($query->id);

        return $wallet->getBalance();
    }
}
