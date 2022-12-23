<?php

namespace App\Services;

use App\Repositories\Cryptocurrencies\CryptocurrencyRepository;

class ShowCryptocurrenciesService
{
    private CryptocurrencyRepository $cryptocurrencyRepository;

    public function __construct(CryptocurrencyRepository $cryptocurrencyRepository)
    {
        $this->cryptocurrencyRepository=$cryptocurrencyRepository;
    }

    public function execute(?int $limit=3, ?string $currency='EUR'): array
    {
        return $this->cryptocurrencyRepository->getCryptocurrencies($limit, $currency)->getCryptocurrencyCollection();
    }
}
