<?php

declare(strict_types=1);

namespace App\Tests\Unit\src\Domain;

use App\Domain\OutcomeOperation;
use PHPUnit\Framework\TestCase;

class OutcomeOperationTest extends TestCase
{
    public function testInvalidOutcomeAmount(): void
    {
        $operation = new OutcomeOperation();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Current balance equals: 100, you cannot spend more than current balance');
        $operation->calculate(100, 200);
    }
}
