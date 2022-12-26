<?php

namespace App\Models\Collections;

class TransactionsCollection
{
    private array $transactionsCollection;

    public function __construct(array $transactionsCollection)
    {
        $this->transactionsCollection = $transactionsCollection;
    }

    public function getTransactionsCollection(): array
    {
        return $this->transactionsCollection;
    }
}
