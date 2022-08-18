<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
        }

        return $this;
    }
}
