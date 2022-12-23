<?php

namespace App\Services\TransactionServices;

class BuyService extends TransactionService
{
    public function execute(string $symbol, int $amount): Void
    {
        $cryptocurrency=$this->cryptocurrencyRepository->getCryptocurrency($symbol);
        $this->usersRepository->buyCoins($cryptocurrency,$amount);
    }
}
