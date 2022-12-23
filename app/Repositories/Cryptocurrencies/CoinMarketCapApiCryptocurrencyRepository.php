<?php

namespace App\Repositories\Cryptocurrencies;

use App\Models\Collections\CryptocurrencyCollection;
use App\Models\Cryptocurrency;
use CoinMarketCap\Api;

class CoinMarketCapApiCryptocurrencyRepository implements CryptocurrencyRepository
{
    public function getCryptocurrencies(?int $limit = 3, ?string $currency = 'EUR'): CryptocurrencyCollection
    {
        $cryptocurrencyCollection=[];
        $cmc = new Api($_ENV['API_KEY']);
        $cryptocurrencies = $cmc->cryptocurrency()->listingsLatest(['limit' => $limit, 'convert' => $currency])->data;
        foreach ($cryptocurrencies as $cryptocurrency){
            $symbol=$cryptocurrency->symbol;
            $cryptocurrencyInfo=$cmc->cryptocurrency()->info(['symbol' => $symbol])->data->{$symbol};
            $cryptocurrencyCollection[]= $this->CreateCryptocurrency(
                $symbol,
                $currency,
                $cryptocurrency,
                $cryptocurrencyInfo
            );
        }

        return new CryptocurrencyCollection($cryptocurrencyCollection);
    }

    public function getCryptocurrency(string $symbol, ?string $currency='EUR'): Cryptocurrency
    {
        $cmc = new Api($_ENV['API_KEY']);
        $cryptocurrency=$cmc->cryptocurrency()->quotesLatest(['symbol' => $symbol, 'convert' => $currency])->data->{$symbol};
        $cryptocurrencyInfo=$cmc->cryptocurrency()->info(['symbol' => $symbol])->data->{$symbol};
        return $this->CreateCryptocurrency(
            $symbol,
            $currency,
            $cryptocurrency,
            $cryptocurrencyInfo
        );
    }

    private function CreateCryptocurrency(
        string $symbol,
        string $currency,
        $cryptocurrency,
        $cryptocurrencyInfo
    ): Cryptocurrency
    {
        return new Cryptocurrency(
            $symbol,
            $cryptocurrency->name,
            $cryptocurrency->circulating_supply,
            $cryptocurrency->quote->{$currency}->price,
            $cryptocurrency->quote->{$currency}->percent_change_1h,
            $cryptocurrency->quote->{$currency}->percent_change_24h,
            $cryptocurrency->quote->{$currency}->percent_change_7d,
            $cryptocurrency->quote->{$currency}->volume_24h,
            $cryptocurrencyInfo->urls->website[0],
            $cryptocurrencyInfo->description,
            $cryptocurrencyInfo->logo,
            $currency
        );
    }
}
