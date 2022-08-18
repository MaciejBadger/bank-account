<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM;

use App\Domain\Entity\Wallet;
use App\Domain\Repository\WalletRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DoctrineWalletRepository implements WalletRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function add(Wallet $wallet): void
    {
        $this->entityManager->persist($wallet);
    }

    public function get(string $id): Wallet
    {
        $wallet = $this->entityManager->getRepository(Wallet::class)->find($id);

        if ($wallet === null) {
            throw new NotFoundHttpException(
                sprintf('The wallet with id: %s was not found.', $id)
            );
        }

        return $wallet;
    }
}
