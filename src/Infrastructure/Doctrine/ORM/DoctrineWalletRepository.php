<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM;

use App\Domain\Entity\Wallet;
use App\Domain\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineWalletRepository implements WalletRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function add(Wallet $wallet): void
    {
        $this->entityManager->persist($wallet);
    }
}
