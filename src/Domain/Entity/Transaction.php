<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'transaction')]
class Transaction
{
    use UuidEntity;

    private const TRANSACTION_TYPES = ['income', 'outcome'];

    public function __construct(
        #[ORM\Column(type: Types::DECIMAL, scale: 2)]
        private readonly float $amount,
        #[ORM\Column]
        private readonly string $type
    ) {
        if ($amount <= 0) {
            throw new \InvalidArgumentException(
                sprintf('Amount provided must be greater than 0, %s given.', $amount)
            );
        }
        if (!in_array($type, self::TRANSACTION_TYPES)) {
            throw new \InvalidArgumentException(
                'Provided transaction type does not match any of allowed types.'
            );
        }
    }
}
