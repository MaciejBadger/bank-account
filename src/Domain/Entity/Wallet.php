<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'wallet')]
class Wallet
{
    use UuidEntity;

    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Transaction::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'wallets_transactions')]
    #[ORM\JoinColumn(name: 'wallet_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'transaction_id', referencedColumnName: 'id', unique: true)]
    private Collection $transactions;

    #[ORM\Column(type: Types::DECIMAL, scale: 2)]
    private float $balance = 0;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): void
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
        }
    }
}
