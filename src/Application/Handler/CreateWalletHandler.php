<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateWallet;
use App\Domain\Entity\Wallet;
use App\Domain\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateWalletHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateWallet $createWallet)
    {
        $this->walletRepository->add(new Wallet());
        $this->entityManager->flush();
    }
}
