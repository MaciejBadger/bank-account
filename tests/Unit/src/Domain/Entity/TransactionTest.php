<?php

declare(strict_types=1);

namespace App\Tests\Unit\src\Domain\Entity;

use App\Domain\Entity\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testInvalidTransactionAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount provided must be greater than 0, -100 given.');
        new Transaction(-100, 'income');
    }

    public function testInvalidTransactionType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Provided transaction type does not match any of allowed types.');
        new Transaction(100, 'another_type');
    }
}
