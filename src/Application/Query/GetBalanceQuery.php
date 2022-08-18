<?php

namespace App\Application\Query;

class GetBalanceQuery
{
    public function __construct(public readonly string $id)
    {
    }
}
