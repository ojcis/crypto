<?php

namespace App\Models\Collections;

use App\Models\Cryptocurrency;

class CryptocurrencyCollection
{
    private array $cryptocurrencyCollection;

    public function __construct(array $cryptocurrencyCollection)
    {
        $this->cryptocurrencyCollection=$cryptocurrencyCollection;
    }

    public function getCryptocurrencyCollection(): array
    {
        return $this->cryptocurrencyCollection;
    }
}
