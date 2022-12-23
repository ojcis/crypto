<?php

namespace App\Services;

use App\Models\Cryptocurrency;
use App\Repositories\Cryptocurrencies\CryptocurrencyRepository;

class ShowCryptocurrencyService
{
    private CryptocurrencyRepository $cryptocurrencyRepository;

    public function __construct(CryptocurrencyRepository $cryptocurrencyRepository)
    {
        $this->cryptocurrencyRepository=$cryptocurrencyRepository;
    }

    public function execute(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        return $this->cryptocurrencyRepository->getCryptocurrency($symbol,$currency);
    }
}